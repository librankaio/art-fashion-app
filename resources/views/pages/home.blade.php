@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Art Fashion Inventory Apps</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Home</a></div>
            {{-- <div class="breadcrumb-item"><a class="text-muted">Master Data Warna</a></div> --}}
        </div>
    </div>
    <div class="section-body">
        <form action="" method="POST" id="thisform">
            @csrf
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Header Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-none d-xl-block">
                                <img alt="image" src="{{ asset('../assets/img/banner.png') }}" style="width: 1560px; height:800px">
                            </div>
                            <div class="d-none d-lg-block d-xl-none">
                                <img alt="image" src="{{ asset('../assets/img/banner.png') }}" style="width: 710px; height:602px">
                            </div>
                            <div class="d-none d-md-block d-lg-none">
                                <img alt="image" src="{{ asset('../assets/img/banner.png') }}" style="width: 710px; height:602px">
                            </div>
                            <div class="d-none d-sm-block d-md-none">
                                <img alt="image" src="{{ asset('../assets/img/banner.png') }}" style="width: 710px; height:400px">
                            </div>
                            <div class="d-block d-sm-none">
                                <img alt="image" src="{{ asset('../assets/img/banner-mobile.png') }}" style="width: 265px; height:400px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
</script>
@endsection