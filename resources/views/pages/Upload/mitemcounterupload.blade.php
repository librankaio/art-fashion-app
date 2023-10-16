@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Upload Data Mitem Counter</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Upload Data</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Upload Data Mitem Counter</a></div>
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
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Upload Data</h4>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="section-title">File Browser</div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="file_upload">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tipe Master Data</label>
                                        <select class="form-control select2" name="jenis" id="jenis">
                                            <option disabled selected>--Select Master Data--</option>
                                            <option>TEST</option>
                                            <option>TEST</option>
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-footer text-right">                            
                            <button class="btn btn-primary mr-1" type="submit" 
                            formaction="{{ route('uploadmitemcounterpost') }}" id="confirm">Upload</button> 
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
        file_upload = $("#customFile").val();
        if (kode == ""){
            swal('WARNING', 'Kode Tidak boleh kosong!', 'warning');
            return false;
        }else if (nama == ""){
            swal('WARNING', 'Nama Tidak boleh kosong!', 'warning');
            return false;
        }else if(file_upload == ''){
            swal('WARNING', 'File upload kosong!', 'warning');
            return false;
        }
    });

    $('#customFile').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        cleanFileName = fileName.replace('C:\\fakepath\\', " ");
        $(this).next('.custom-file-label').html(cleanFileName);
    })
</script>
@endsection