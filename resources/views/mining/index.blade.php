@extends('layouts.master')
@section('title', 'Data mining')

@section('content')

    <section class="section">
        <div class="section-header">
        <div class="row">
            <div class="col-md-6">
        <h1><a href="{{ route('mining.create') }}" class="btn btn-info">Tambah Data Mining</a> </h1> 
                
            </div>
            <div class="col-md-6">
                Total Mining {{ number_format($jumlah_coin,8) }}
            </div>
        </div>
        
        </div>
    </section>
    <div class="section-body">
        
        <div class="row">
            
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="table-responsive">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                        @if ($message = Session::get('deleted'))
                        <div class="alert alert-danger">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                        <table class="table table-striped table-md">
                            <tr>
                                <th >Tgl</th>
                                <th width="300 px">Hasil Mining </th>
                                <th >Kurs</th>  
                                <th width="300 px">Action  </th>
                            </tr>
                            @foreach ($datamining as $no => $item)
                                <tr>
                                    <td> {{$item->timestamp}} </td>
                                    <td >{{$item->hasil_mining }} </a> </td>
                                    <td >@currency($item->kurs) </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('mining.kalkulasi',$item->id) }}">Show</a>
                                        @if ($message = Session::get('grupnya') == '2')
                                        <form class="pull-left" action="{{ route('mining.destroy',$item->id) }}" method="POST">
                                            @csrf
                                            @if(DB::table('transaksi_mining')->where('id_mining',$item->id)->first())
                                             @else
                                            <a class="btn btn-success" href="{{ route('mining.kalkulasi',$item->id) }}">Kalkulasi</a>
                                             @endif
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="col-md-12">
                                    
                            {{ $datamining->onEachSide(1)->links() }}
                                </div>
            </div>

        </div>
    </div>
    </div>
@endsection

@push('page-script')

@endpush
