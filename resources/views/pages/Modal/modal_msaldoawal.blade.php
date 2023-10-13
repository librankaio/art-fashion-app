@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Master Data</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Master Data</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Master Data Saldo Counter</a></div>
        </div>
    </div>
    @php
        $mbank_save = session('mbank_save');
        $mbank_updt = session('mbank_updt');
        $mbank_dlt = session('mbank_dlt');
    @endphp
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                @include('layouts.flash-message')
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-2">We've created a plugin to easily create a bootstrap modal.</p>
                        <button class="btn btn-primary" id="modal-4">Launch Modal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- MODAL -->
  <div class="modal" tabindex="-1" id="mymodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">INPUT SALDO AWAL</h5>
          {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> --}}
        </div>
        <form action="{{ route('msaldoawalpost') }}" method="POST">
            @csrf
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="dt" value="{{ date("Y-m-d") }}">
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Saldo</label>
                                <input type="text" class="form-control" name="saldo" id="saldo" value="{{  number_format(500000) }}">
                            </div>
                        </div>
                    </div>            
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
            <button class="btn btn-primary mr-1" type="submit" id="confirm" onclick="submitForm();">Save</button> 
            </div>
        </form>
      </div>
    </div>
  </div>
{{-- END MODAL --}}
@stop
@section('pluginjs')
<script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
@stop
@section('botscripts')
<script type="text/javascript">
    $(document).ready(function() {
        // $('#modal-3').modal('show');
        $('#mymodal').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                });
    });
    $('#datatable').DataTable({
        // "ordering":false,
        "bInfo" : false
    });

    $(".alert button.close").click(function (e) {
        $(this).parent().fadeOut(2000);
    });

    function submitDel(id){
        $('#del-'+id).submit()
    }
    function submitForm(){
        // alert('Form has been submitted');
        $('#confirm').submit()
    }
    $(document).on("click","#confirm",function(e){
        // Validate ifnull
        kode = $("#kode").val();
        nama = $("#nama").val();
        if (kode == ""){
            swal('WARNING', 'Kode Tidak boleh kosong!', 'warning');
            return false;
        }else if (nama == ""){
            swal('WARNING', 'Nama Tidak boleh kosong!', 'warning');
            return false;
        }
    });

    $(document).on('keyup', '#saldo', function(event) 
    {
        event.preventDefault(); 
        if (/\D/g.test(this.value)){
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }
    }); 

    $(document).on('click', '#saldo', function(event) 
    {
        event.preventDefault(); 
        
        if (/\D/g.test(this.value))
        {
            // Filter comma
            this.value = this.value.replace(/\,/g,"");
            this.value = Number(Math.trunc(this.value))
        }

        $(this).focus();
    }); 

    $(document).on('focusout', '#saldo', function(event) 
    {
        event.preventDefault();
        saldo = $(this).val();

        $(this).val(thousands_separators(Number(saldo).toFixed(2)));
    })
</script>
@endsection