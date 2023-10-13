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
                                        <input type="text" class="form-control" name="nik" id="nik">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="name" id="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Counter / Lokasi</label>
                                        <select class="form-control select2" name="counter" id="counter">
                                            <option disabled selected>--Select Counter--</option>
                                            @foreach($counters as $counter)
                                            <option>{{ $counter->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No Handphone</label>
                                        <input type="text" class="form-control" name="phone" id="phone">                                        
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
                                            <option disabled selected>--Select Jenis--</option>
                                            <option>SPG DS</option>
                                            <option>SPG SR</option>
                                            <option>ADMIN</option>
                                        </select>                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">    
                            <button class="btn btn-primary mr-1" type="submit"
                                formaction="{{ route('mspgpost') }}" id="confirm">Save</button>
                            <button class="btn btn-secondary" type="reset">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border border-5" style="text-align: center;">No</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">NIK</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Nama</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Counter/Lokas</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Handphone</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 0 @endphp
                                    @foreach($datas as $data => $item)
                                    @php $counter++ @endphp
                                    <tr>
                                        <th scope="row" class="border border-5" style="text-align: center;">{{ $counter }}</th>
                                        <td class="border border-5" style="text-align: center;">{{ $item->nik }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->name }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->counter }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->hp }}</td>
                                        <td style="text-align: center;" class="d-flex justify-content-center">
                                            <a href="/mspg/{{ $item->id }}/edit"
                                                class="btn btn-icon icon-left btn-primary"><i class="far fa-edit">
                                                    Edit</i></a>
                                            <form action="/mspg/delete/{{ $item->id }}" id="del-{{ $item->id }}"
                                                method="POST" class="px-2">
                                                @csrf
                                                <button class="btn btn-icon icon-left btn-danger"
                                                    id="del-{{ $item->id }}" type="submit"
                                                    data-confirm="WARNING!|Do you want to delete {{ $item->name }} data?"
                                                    data-confirm-yes="submitDel({{ $item->id }})"><i
                                                        class="fa fa-trash">
                                                        Delete</i></button>
                                            </form>
                                        </td>
                                        {{-- <td class="border border-5" style="vertical-align: midddle;">
                                            <a href="/masterbank/{{ $item->id }}/edit"
                                                class="btn btn-icon icon-left btn-primary"><i class="far fa-edit">
                                                    Edit</i></a>
                                            <form action="/masterbank/delete/{{ $item->id }}" id="del-{{ $item->id }}"
                                                method="POST">
                                                @csrf
                                                <button class="btn btn-icon icon-left btn-danger"
                                                    id="del-{{ $item->id }}" type="submit"
                                                    data-confirm="WARNING!|Do you want to delete {{ $item->name }} data?"
                                                    data-confirm-yes="submitDel({{ $item->id }})"><i
                                                        class="fa fa-trash">
                                                        Delete</i></button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
        nik = $("#nik").val();
        name = $("#name").val();
        counter = $("#counter").prop('selectedIndex');
        phone = $("#phone").val();
        password = $("#password").val();
        jenis = $("#jenis").prop('selectedIndex');

        if (nik == ""){
            swal('WARNING', 'NIK Tidak boleh kosong!', 'warning');
            return false;
        }else if (name == ""){
            swal('WARNING', 'Nama Tidak boleh kosong!', 'warning');
            return false;
        }else if (counter == 0){
            swal('WARNING', 'Counter Tidak boleh kosong!', 'warning');
            return false;
        }else if (phone == ""){
            swal('WARNING', 'No Handphone Tidak boleh kosong!', 'warning');
            return false;
        }else if (phone == ""){
            swal('WARNING', 'Password Tidak boleh kosong!', 'warning');
            return false;
        }else if (jenis == 0){
            swal('WARNING', 'Jenis Tidak boleh kosong!', 'warning');
            return false;
        }

    });
</script>
@endsection