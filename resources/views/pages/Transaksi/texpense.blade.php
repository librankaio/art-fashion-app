@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Transaksi</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Transaksi</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Transaksi Biaya Operasional</a></div>
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
                                        <input type="date" class="form-control" name="dt" value="{{ date("Y-m-d") }}">
                                    </div>
                                </div>        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total</label>
                                        <input type="text" class="form-control" name="total" id="total">
                                    </div>
                                </div>                        
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control" style="height:100px" name="note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">                            
                            <button class="btn btn-primary mr-1" type="submit" 
                            formaction="{{ route('texpensepost') }}" id="confirm">Save</button>                                
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
                                        <th scope="col" class="border border-5" style="text-align: center;">Tanggal</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Deskripsi</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Total</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 0 @endphp
                                    @foreach($datas as $data => $item)
                                    @php $counter++ @endphp
                                    <tr>
                                        <th scope="row" class="border border-5" style="text-align: center;">{{ $counter }}</th>
                                        <td class="border border-5" style="text-align: center;">{{ date("Y-m-d", strtotime($item->tgl)) }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->note }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ number_format($item->total, 2, '.', ',') }}</td>
                                        <td style="text-align: center;" class="d-flex justify-content-center">
                                            <a href="texpense/{{ $item->id }}/edit"
                                                class="btn btn-icon icon-left btn-primary"><i class="far fa-edit">
                                                    Edit</i></a>
                                            <form action="/texpense/delete/{{ $item->id }}" id="del-{{ $item->id }}"
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
        kode = $("#kode").val();
        nama = $("#nama").val();
        if (kode == ""){
            swal('WARNING', 'Kode Tidak boleh kosong!', 'warning');
            return false;
        }else if (nama == ""){
            swal('WARNING', 'Nama Tidak boleh kosong!', 'warning');
            return false;
        }
        show_loading()
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