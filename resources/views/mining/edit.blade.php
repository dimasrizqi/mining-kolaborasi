@extends('layouts.master')
@section('title', 'Edit Hasil Mining')

@section('content')
    <section class="section">
        <div class="section-header">
        
        <h1>Silahkan ubah dan klik simpan atau <a href="{{  route('mining.index')}}" class="btn btn-info">Kembali</a> </h1> 
        </div>
    </section>
    <div class="section-body">
        
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    @if ($message = Session::get('success'))
                    
                    <div class="alert alert-success">
                        
                        <p>{{ $message }}</p>
                        
                    </div>
                    
                    @endif
                   
                    <form action="{{ route('mining.update',$datamining->id) }}" method="POST">
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Hasil mining</label></label>
                                        <input type="text" value="{{$datamining->hasil_mining}}" placeholder="Masukan jumlah koin" name="hasil_mining" class="form-control" required> 
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Kurs Saat Payout</label></label>
                                        <input type="text" value="@currency($datamining->kurs)" placeholder="Masukan kurs saat payout" name="kurs" class="form-control" required> 
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @csrf
                        <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
            </div>

        </div>
    </div>
    </div>
@endsection

@push('page-script')

@endpush
