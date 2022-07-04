@extends('layouts.master')
@section('title','HOME')

@section('content')
  <section class="section">
    

    <div class="section-body">
     <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <form action="{{route('index')}} " method="GET">
            <div class="input-group mb-3">
                <input type="date" class="form-control" name="start_date">
                <input type="date" class="form-control" name="end_date">
                <button class="btn btn-primary" type="submit">GET</button>
            </div>
        </form>
        </div>
    </div>
     <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
        <canvas id="myChart"></canvas>
        </div>
    </div>
    </div>

   
    </div>
  </section>
@endsection

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('assets/js/Chart.js')}}"></script>
    <script>
    
		var ctx = document.getElementById("myChart").getContext('2d');
		const labels =[ @foreach($data_transaksi_mining as $no => $item)
					        '{{Carbon::parse($item->created_at)->format('d-m-y')}}' ,
					    @endforeach
					    ];
		var data = {
				labels: labels,
				datasets: [{
					label: 'Grafik Pendapatan Rupiah',
					data: [
					    @foreach($data_transaksi_mining as $no => $item)
					       {{$data_transaksi_mining->average('rupiah_user').','}}
					    @endforeach
					],
					fill: false,
					borderColor: 'brown',
					type: 'line',
					order: 0
				},{
					label: 'Grafik Pendapatan Rupiah',
					data: [
					    @foreach($data_transaksi_mining as $no => $item)
					       {{$item->rupiah_user.','}}
					    @endforeach
					],
					fill: false,
					backgroundColor: 'green',
					order: 1
				},]
			}
	
         var option = {
             responsive: true,
             tooltips: {
                  enabled: true,
                  callbacks: {
                    label: function(tooltipItem, data) {
                      var val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                      return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                    }
                  }
            
                },
             legend: {
                 display: false,
             },
             title: {
              display: true,
              text: 'Grafik Pendapatan'
             }
            };
                
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: data,
			options: option,
		});
	</script>
@endpush
    

