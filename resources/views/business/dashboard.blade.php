@extends('business.layouts.main')
@section('content')
@section('title', 'Dashboard')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <x-business-alert />
      </div>
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="far fa-credit-card"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Credit</span>
            <span class="info-box-number">{{ $businessDetails->credit }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-clipboard-check"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Complited Appoinment</span>
            <span class="info-box-number">{{ $businessDetails->complited_count }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-clipboard"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">All Appoinment</span>
            <span class="info-box-number">{{ $businessDetails->all_count }}</span>
          </div>
        </div>
      </div>

      <div class="col-12 mt-3">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Appoinment</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <div class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand">
                  <div class=""></div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                  <div class=""></div>
                </div>
              </div>
              <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>


    </div>

  </div>
</section>

@push('js')
<!-- ChartJS -->
<script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
<script>
  $(function() {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    function charAjax() {
      $.ajax({
        url: "{{ route('business.dashboard.analytics') }}",
        type: "POST",
        data: {
          '_method': 'post',
          'id': ''
        },
        dataType: "json",
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        beforeSend: function() {
          // loader(true)
        },
        success: function(result) {
          if (result.success) {
            appointmrntChart(result.data);
          } else {
            toastr.error(result.message);
          }
          // loader(true)
        },
        error: function(e) {
          toastr.error('Somthing Wrong');
          console.log(e);
          // loader(true)
        }
      });
    }

    charAjax();



    //-------------
    //- BAR CHART -
    //-------------
    function appointmrntChart(data) {

      var areaChartData = {
        labels: data.appointmrntChart.lable,
        datasets: [{
            label: 'Complited',
            backgroundColor: 'rgba(60,141,188,0.9)',
            data: data.appointmrntChart.Complited
          },
          {
            label: 'All',
            backgroundColor: 'rgba(210, 214, 222, 1)',
            data: data.appointmrntChart.All
          },
        ]
      }

      var barChartCanvas = $('#barChart').get(0).getContext('2d')
      var barChartData = $.extend(true, {}, areaChartData)
      var temp0 = areaChartData.datasets[0]
      var temp1 = areaChartData.datasets[1]
      barChartData.datasets[0] = temp1
      barChartData.datasets[1] = temp0

      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false,
      }

      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })
    }

  })
</script>
@endpush


@endsection