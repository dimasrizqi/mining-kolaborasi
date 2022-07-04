@extends('layouts.master')
@section('title', 'Hasil Mining')

@section('content')
    <section class="section">
        <div class="section-header">
        <div class="row">
            <div class="col-lg-12">
        <h1>Rekap Transaksi pemining</h1> 
        </div>
        
        </div>
    </section>
    <div class="section-body">
        
        <div class="row">
            
            <div class="col-12 col-md-12 col-lg-12">
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
            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <!--<div class="table-responsive">-->
                        <div class="">
                            <form action="{{route('mining.transaksimining')}} " method="GET">
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control" name="start_date">
                                    <input type="date" class="form-control" name="end_date">
                                    <button class="btn btn-primary" type="submit">GET</button>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped table-bordered">
                                <tr>
                                    <td> Total coin </td>
                                    <td > {{$data_transaksi_mining2->sum('coin_user') }}  ETH</td>
                                </tr>
                                <tr>
                                    <td> Total Rupiah </td>
                                    <td >
                                        @currency($data_transaksi_mining2->sum('rupiah_user'))
                                    </td>
                                </tr>
                        </table>
                    </div>
                    
            </div>

        </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="table-responsive">
                    <div>
                        
                        <table class="table table-sm table-striped table-bordered">
                                <tr>
                                    <td>No </td>
                                    <td>Coin </td>
                                    <td>Rupiah </td>
                                    <td>Fee Payout </td>
                                    <td>Persentase </td>
                                    <td>Hashrate </td>
                                    <td>Tanggal</td>    
                                </tr>
                                    @foreach($data_transaksi_mining as $no => $item)
                                <tr>
                                    <td > {{ ($data_transaksi_mining->currentPage() - 1)  * $data_transaksi_mining->count() + $loop->iteration }} </td>
                                    <td > {{$item->coin_user}} ETH</td>
                                    <td >
                                          @currency($item->rupiah_user)
                                    </td>
                                    <td >
                                          @currency($item->fee_user)
                                    </td>
                                    <td >
                                          {{($item->persentase_user)}} %
                                    </td>
                                    <td >
                                          {{($item->hashrate_user)}} Mhs
                                    </td>
                                    <td> {{ $item->created_at }} </td>
                                </tr>
                                @endforeach
                        </table>
                    </div>
                    {{  $data_transaksi_mining->onEachSide(1)->links()}}
            </div>

        </div>
    </div>
    </div>
@endsection

@push('page-script')

@endpush
