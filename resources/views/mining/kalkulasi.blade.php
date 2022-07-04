@extends('layouts.master')
@section('title', 'Kalkulasi Hasil mining')

@section('content')
    <section class="section">
        
    </section>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">

                    <form action="{{ route('mining.proses') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            <div class="row">
                                
                                @if ($message = Session::get('failed'))
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        <p>{{ $message }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="col-md-4">
                                        perhitungan Mining {{Carbon\Carbon::now()->isoFormat('D MMMM Y')}}
                                </div>
                                
                                <div class="col-md-4">
                                        Hasil Mining = <b><u>{{ $datamining[0]->hasil_mining  }}</u></b> ETH<br>
                                </div>
                                
                                <div class="col-md-4">
                                    
                                       
                                        Kurs Saat Payout = <b><u>@currency($datamining[0]->kurs)</u></b> ETH<br>
                                        
                                </div>
                                <div class="col-md-12">
                                    
                                   
                                    <div class="">
                                        <form action="{{ route('mining.proses') }}" method="POST">
                                            
                                   <table class="table table-sm table-bordered table-striped">
                                        <tr>
                                            <th width="50px">NO.</th>
                                            <th width="150px">Nama</th>
                                            <th width="80px" >Hashrate</th>
                                            <th width="50px">Persentase Mining</th>
                                            <th width="100px">Hasil Coin</th>
                                            <th >Fee Payout </th>
                                            <th >Hasil Rupiah </th>
                                            
                                        </tr>
                                        @foreach ($datauser  as $no => $datanya)
                                            <tr>
                                                <td>{{  $no + 1 }} </td>
                                                <td>{{  $datanya->name}} <input type="hidden" value="{{$datanya->name}}"> </td>
                                                <td>{{  $datanya->hashrate}} Mhs</td>
                                                <td>{{  number_format($totalpersen = ($datanya->hashrate/$total_hashrate) *100,2)}} %</td>
                                                <td>{{  number_format($hasil_koin = (($totalpersen/100)*$datamining[0]->hasil_mining)- ((($totalpersen/100)*$datamining[0]->hasil_mining)*($datanya->fee/100)),8)}}</td>
                                                <td>
                                                    @if ($datanya->payout_rupiah == 1)
                                                       Rp {{$fee_exchange = ($dataexchange[0]->fee / $total_payout_rupiah) }}
                                                    @elseif ($datanya->payout_rupiah == 0)
                                                        {{ $fee_exchange = 0}}
                                                    @else
                                                        Error - tidak ada pilihan
                                                    @endif  
                                                </td>
                                                <td align="right">@currency(($hasil_rupiah=$hasil_koin*$datamining[0]->kurs)-$fee_exchange ) </td>    
                                            </tr>
                                            	
                                            <input type="hidden" value="{{$datanya->id}}" name="id_user[]">
                                            <input type="hidden" value="{{$datamining[0]->id}}" name="id_mining[]">
                                            <input type="hidden" value="{{number_format($hasil_koin,8)}}" name="coin_user[]">
                                            <input type="hidden" value="{{round($hasil_rupiah)}}" name="rupiah_user[]">
                                            <input type="hidden" value="{{$totalpersen}}" name="persentase_user[]">
                                            <input type="hidden" value="{{$datanya->hashrate}}" name="hashrate_user[]">
                                            @if ($datanya->payout_rupiah == 1)
                                                       <input type="hidden" value="{{$dataexchange[0]->fee / $total_payout_rupiah}}" name="fee_user[]">
                                                    @elseif ($datanya->payout_rupiah == 0)
                                                       <input type="hidden" value="0" name="fee_user[]">
                                                    @else
                                                        Error - tidak ada pilihan
                                                    @endif
                                        @endforeach
                                        
                                        
                                    </table>
                                    </form>
                                    <div class="col-md-12">
                                    <div class="card-footer text-right">
                                        @if(DB::table('transaksi_mining')->where('id_mining',$datamining[0]->id)->first())
                                             @else
                                        <button class="btn btn-primary mr-1" type="submit">Proses</button>
                                         @endif
                                    </div>
                                </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                
                </form>
            </div>

        </div>
    </div>
    </div>
@endsection

@push('page-scripts')

@endpush