<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class miningController extends Controller
{
    public function index(){
        $datamining = DB::table('mining')->orderBy('timestamp','DESC')->Paginate(10);
        $jumlah_coin = DB::table('mining')->sum('hasil_mining');
        return view('mining.index',compact('datamining','jumlah_coin'));
    }

    public function create(){
        return view('mining.create');
       
   }
   public function proses(Request $request){
        $batas = $request->id_user;
        for($count = 0; $count < count($batas); $count++){
            $data = array(
                'id_user' => $request->id_user[$count],
                'id_mining' => $request->id_mining[$count],
                'coin_user' => $request->coin_user[$count],
                'rupiah_user' => $request->rupiah_user[$count],
                'persentase_user' => $request->persentase_user[$count],
                'hashrate_user' => $request->hashrate_user[$count],
                'fee_user' => $request->fee_user[$count],
            );
            $insert_data[] = $data; 
        }
        DB::table('transaksi_mining')->insert($insert_data);

        return redirect()->route('mining.index')->with('success','Berhasil Kalkulasi');
       
   }
   public function datadasar(){
        $datauser = DB::table('users')->where('id',session()->get('id_user'))->get();
        $data_transaksi_mining = DB::table('transaksi_mining')->where('id_user',session()->get('id_user'))->get();
        
        return view('mining.data_dasar',compact('datauser','data_transaksi_mining')
        );
       
   }
   public function transaksimining(Request $request){
       if(request()->start_date || request()->end_date){
         $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
        $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
        
        $data_transaksi_mining = DB::table('transaksi_mining')
            ->where('id_user',session()->get('id_user'))
            ->orderBy('id','DESC')->whereBetween('created_at',[$start_date,$end_date])
            ->Paginate(10);
            
        $data_transaksi_mining2 = DB::table('transaksi_mining')->where('id_user',session()->get('id_user'))->whereBetween('created_at',[$start_date,$end_date])->get();
       }
       else{
       $data_transaksi_mining = DB::table('transaksi_mining')->where('id_user',session()->get('id_user'))->orderBy('id','DESC')->Paginate(10);
        $data_transaksi_mining2 = DB::table('transaksi_mining')->where('id_user',session()->get('id_user'))->get();
       }
        return view('mining.transaksi_mining',
            compact(
                'data_transaksi_mining',
                'data_transaksi_mining2'
            )
        );
       
   }
    
    public function kalkulasi(Request $request){
        $datamining = DB::table('mining')->where('id',$request->id)->get();
        $datauser = DB::table('users')->orderBy('name','ASC')->where('status',1)->get();
        $dataexchange = DB::table('exchange_information')->where('status',1)->get();
        $total_hashrate = DB::table('users')->where('status',1)->sum('hashrate');
        $total_payout_rupiah = DB::table('users')->where('payout_rupiah',1)->count('payout_rupiah');
        //dd($datamining[0]->kurs);
        return view('mining.kalkulasi',[
            'datauser'=>$datauser,
            'total_hashrate'=>$total_hashrate,
            'datamining'=>$datamining,
            'dataexchange'=>$dataexchange,
            'total_payout_rupiah'=>$total_payout_rupiah
            ]);
       
   }
   public function store(Request $request){
    $data_insert[] = array(
        'kurs' => $request->kurs,
        'hasil_mining' => $request->hasil_mining
    );

    // dd($data_insert);
        DB::table('mining')->insert( $data_insert);
        return Redirect()->route('mining.index') -> with('success','berhasil menambah data');
    }
    public function update(Request $request,  $id)
    {
       dd($request->all());
    }

    
    public function edit($id)
    {
         $datamining = DB::table('mining')->where('id','=', $id)->first();
         return view('mining.edit',[
             'datamining'=>$datamining
             ]);
    }
    public function destroy($id)

    {
        // dd($id);
        
        DB::table('mining')->where('id','=', $id)->delete();
        
        return redirect()->route('mining.index') -> with('deleted','berhasil menghapus');
    }
    

}
