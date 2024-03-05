@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Master Data</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Master Data</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Master Data SPG</a></div>
        </div>
    </div>
    @php
        // $mbank_save = session('mbank_save');
        // $mbank_updt = session('mbank_updt');
        // $mbank_dlt = session('mbank_dlt');
    @endphp
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                @include('layouts.flash-message')
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Master Data SPG</h4>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="text" class="form-control" name="nik" id="nik" value="{{ $user->nik }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Counter / Lokasi</label>
                                        <select class="form-control select2" name="counter" id="counter">
                                            <option selected>{{ $user->counter }}</option>
                                            @foreach($counters as $counter)
                                            <option>{{ $counter->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No Handphone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ $user->hp }}">                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" id="password">                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis</label>
                                        <select class="form-control select2" name="jenis" id="jenis">
                                            <option selected>{{ $user->jenis }}</option>
                                            <option>SPG DS</option>
                                            <option>SPG SR</option>
                                            <option>ADMIN</option>
                                            <option>USER</option>
                                            <option>GUDANG</option>
                                        </select>                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">    
                            <button class="btn btn-primary mr-1" type="submit"
                                formaction="/mspg/{{ $user->id }}" id="confirm">Update</button>
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
        }else if (nama == 0){
            swal('WARNING', 'Nama Tidak boleh kosong!', 'warning');
            return false;
        }
    });
</script>
@endsection