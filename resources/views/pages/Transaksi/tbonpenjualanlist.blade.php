@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Bon Penjualan List</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Bon Penjualan List</a></div>
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
        {{-- <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Master Data Warna</h4>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Warna</label>
                                        <input type="text" class="form-control" name="kode" id="kode">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="nama" id="nama">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">                            
                            <button class="btn btn-primary mr-1" type="submit" 
                            formaction="{{ route('mwarnapost') }}" id="confirm">Save</button>                                
                            <button class="btn btn-secondary" type="reset">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>            
        </div> --}}
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lists</h4>
                        <div class="card-header-action">
                          <form formaction="/tbonjuallist" method="get">
                            <div class="input-group">
                              <input type="text" class="form-control" placeholder="Search" name="search" value="@php if(request()->input('search')==NULL){ echo "";} else{ echo $_GET['search']; } @endphp">
                              <div class="input-group-btn">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border border-5" style="text-align: center;">No</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">No Trans</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Tanggal</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Counter</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Diskon</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Harga Sebelum Diskon</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Grand Total</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 0 @endphp
                                    @foreach($tpenjualanhs as $data => $item)
                                    @php $counter++ @endphp
                                    <tr>
                                        <th scope="row" class="border border-5" style="text-align: center;">{{ $counter }}</th>
                                        <td class="border border-5" style="text-align: center;">{{ $item->no }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ date("Y-m-d", strtotime($item->tgl)) }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->counter }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ number_format($item->diskon, 2, '.', ',') }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ number_format($item->hrgsblmdisc, 2, '.', ',') }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ number_format($item->grdtotal, 2, '.', ',')}}</td>
                                        <td style="text-align: center;" class="d-flex justify-content-center">
                                            <a href="/tbonjual/{{ $item->id }}/edit"
                                                class="btn btn-icon icon-left btn-primary"><i class="far fa-edit">
                                                    Edit</i></a>
                                            <form action="/tbonjual/delete/{{ $item->id }}" id="del-{{ $item->id }}"
                                                method="POST" class="px-2">
                                                @csrf
                                                <button class="btn btn-icon icon-left btn-danger"
                                                    id="del-{{ $item->id }}" type="submit"
                                                    data-confirm="WARNING!|Do you want to delete {{ $item->no }} data?"
                                                    data-confirm-yes="submitDel({{ $item->id }})"><i
                                                        class="fa fa-trash">
                                                        Delete</i></button>
                                            </form>
                                            <a href="/tbonjual/{{ $item->id }}/print"
                                                class="btn btn-icon icon-left btn-success" target="_blank"><i class="far fa-print">
                                                    Print</i></a>
                                            <a href="/tbonjual/{{ $item->id }}/printpdfbonjual"
                                                class="btn btn-icon icon-left btn-success" target="_blank"><i class="far fa-print">
                                                    Print Matrix</i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer text-right">
                                {{ $tpenjualanhs->links() }}
                              </div>
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
        "bInfo" : false,
        "bPaginate": false,
        "searching": false
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