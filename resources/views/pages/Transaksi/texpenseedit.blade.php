@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Transaksi</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Transaksi</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Transaksi Biaya Operasional Edit</a></div>
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
            <div class="col-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Transaksi Biaya Operasional</h4>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="dt" value="{{ date("Y-m-d", strtotime($texpenseh->tgl)) }}">
                                    </div>
                                </div>        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total</label>
                                        <input type="text" class="form-control" name="total" id="total" value="{{ number_format($texpenseh->total, 2, '.', ',') }}">
                                    </div>
                                </div>                        
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control" style="height:100px" name="note">{{ $texpenseh->note }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">                            
                            <button class="btn btn-primary mr-1" type="submit" 
                            formaction="/texpense/{{ $texpenseh->id }}" id="confirm">Update</button>                                
                            <button class="btn btn-secondary" type="reset">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>            
        </div>
    </div>
</section>
@stop
@section('botscripts')
<script type="text/javascript">
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

    $(document).on('keyup', '#total', function(event) 
    {
        event.preventDefault(); 
        if (/\D/g.test(this.value)){
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }
    }); 

    $(document).on('click', '#total', function(event) 
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

    $(document).on('focusout', '#total', function(event) 
    {
        event.preventDefault();
        total = $(this).val();

        $(this).val(thousands_separators(Number(total).toFixed(2)));
    })	
</script>
@endsection