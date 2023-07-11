@extends('layouts.main')
@section('topscripts')
{{-- chartjs --}}
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
{{-- end chartjs --}}
@stop
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Sweet Alert</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Modules</a></div>
        <div class="breadcrumb-item">Sweet Alert</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Sweet Alert</h2>
      <p class="section-lead">
        We use 'Sweet Alert 2' made by 'Tristan Edwards'. You can check the full documentation <a href="https://sweetalert.js.org/">here</a>.
      </p>

      <div class="row">
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-2">Simple Sweet Alert</div>
              <button class="btn btn-primary" id="swal-1">Launch</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-2">Success Message</div>
              <button class="btn btn-primary" id="swal-2">Launch</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-2">Warning Message</div>
              <button class="btn btn-primary" id="swal-3">Launch</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-2">Info Message</div>
              <button class="btn btn-primary" id="swal-4">Launch</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-2">Error Message</div>
              <button class="btn btn-primary" id="swal-5">Launch</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-2">Confirmation</div>
              <button class="btn btn-primary" id="swal-6">Launch</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-2">Input Text</div>
              <button class="btn btn-primary" id="swal-7">Launch</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-2">Auto Hide</div>
              <button class="btn btn-primary" id="swal-8">Launch</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@stop
@section('botscripts')
<script>
    
</script>
<script src="{{ asset('/assets/js/page/modules-sweetalert.js') }}"></script>
@endsection