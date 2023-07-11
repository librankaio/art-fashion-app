@extends('layouts.main')
@section('topscripts')
{{-- chartjs --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
{{-- end chartjs --}}
@stop
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Welcome, {{ session('comp_name') }}</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Modules</a></div>
        <div class="breadcrumb-item">Chart.js</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Chart.js</h2>
      <p class="section-lead">
        We use 'Chart.JS' made by @chartjs. You can check the full documentation <a href="http://www.chartjs.org/">here</a>.
      </p>

      <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Line Chart</h4>
            </div>
            <div class="card-body">
              <canvas id="myChart"></canvas>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Bar Chart</h4>
            </div>
            <div class="card-body">
              <canvas id="myChart2"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Doughnut Chart</h4>
            </div>
            <div class="card-body">
              <canvas id="myChart3"></canvas>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Pie Chart</h4>
            </div>
            <div class="card-body">
              <canvas id="myChart4"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@stop
@section('botscripts')
<script src="{{ asset('assets/js/page/modules-chartjs.js') }}"></script>
@endsection