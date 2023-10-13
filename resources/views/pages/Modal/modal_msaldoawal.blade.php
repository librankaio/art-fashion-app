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
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
@stop
@section('pluginjs')
<script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
@stop
@section('botscripts')
<script type="text/javascript">
    $(document).ready(function() {
        // $('#modal-3').modal('show');
        $("#modal-4").fireModal({
        footerClass: 'bg-whitesmoke',
        body: 'Add the <code>bg-whitesmoke</code> class to the <code>footerClass</code> option.',
        buttons: [
            {
            text: 'No Action!',
            class: 'btn btn-primary btn-shadow',
            handler: function(modal) {
            }
            }
        ]
        });
        $('#modal-4').modal('show');
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