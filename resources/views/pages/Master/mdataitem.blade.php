@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Master Data</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Master Data</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Master Data Item</a></div>
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
                        <h4>Master Data Item</h4>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="nama" id="nama">
                                    </div>
                                    <div class="form-group">
                                        <label>Warna</label>
                                        <textarea class="form-control" style="height:90px" name="warna"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Price (Rp)</label>
                                        <input type="text" class="form-control" name="price" id="price" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Satuan</label>
                                        <input type="text" class="form-control" name="satuan" id="satuan">
                                    </div>
                                    <div class="form-group">
                                        <label>Harga Gross</label>
                                        <input type="text" class="form-control" name="price_gross" id="price_gross" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Special Price</label>
                                        <input type="text" class="form-control" name="price_special" id="price_special" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Kode / Artikel</label>
                                                <input type="text" class="form-control" name="kode" id="kode">
                                            </div>
                                            <div class="col-md-6 align-self-end">
                                                <button class="btn btn-success mr-1" type="button" id="">Print</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <input type="text" class="form-control" name="kategori" id="kategori">
                                    </div>
                                    <div class="form-group">
                                        <label>Size</label>
                                        <input type="text" class="form-control" name="size" id="size">
                                    </div>
                                    <div class="form-group">
                                        <label>Materil</label>
                                        <input type="text" class="form-control" name="material" id="material">
                                    </div>
                                    <div class="form-group">
                                        <label>Harga Nett</label>
                                        <input type="text" class="form-control" name="price_nett" id="price_nett" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">            
                            <button class="btn btn-primary mr-1" type="submit"
                                formaction="{{ route('mitempost') }}" id="confirm">Save</button>
                            <button class="btn btn-secondary" type="reset">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lists</h4>
                        <div class="card-header-action">
                          <form formaction="/mitem" method="get">
                            <div class="input-group">
                              <input type="text" class="form-control" placeholder="Search" name="search" value="@php if(request()->input('search')==NULL){ echo date('d/m/Y');} else{ echo $_GET['search']; } @endphp">
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
                            {{-- <table class="table table-bordered yajra-datatable"> --}}
                                <thead>
                                    <tr>
                                        <th scope="col" class="border border-5" style="text-align: center;">No</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Kode / Artikel</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Nama</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Warna</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Kategori</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Price (Rp.)</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Size</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Satuan</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Material</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Harga Gross</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Harga Nett</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Special Price</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 0 @endphp
                                    @foreach($datas as $data => $item)
                                    @php $counter++ @endphp
                                    <tr>
                                        <th scope="row" class="border border-5">{{ $counter }}</th>
                                        <td class="border border-5" style="text-align: center;">{{ $item->code }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->name }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->warna }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->kategori }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->hrgjual }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->size }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->satuan }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->material }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->gross }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->nett }}</td>
                                        <td class="border border-5" style="text-align: center;">{{ $item->spcprice }}</td>
                                        <td style="text-align: center;" class="d-flex justify-content-center">
                                            <a href="/mitem/{{ $item->id }}/edit"
                                                class="btn btn-icon icon-left btn-primary"><i class="far fa-edit">
                                                    Edit</i></a>
                                            <form action="/mitem/delete/{{ $item->id }}" id="del-{{ $item->id }}"
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
                            <div class="card-footer text-right">
                                {{ $datas->links() }}
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('pluginjs')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
@stop
@section('botscripts')
<script type="text/javascript">
    // $('#datatable').DataTable({
    //     // "ordering":false,
    //     // "bInfo" : false
    //     ajax: "mitem",
    //     // columns: [
    //     //     {data: 'id', name: 'id'},
    //     //     {data: 'code', name: 'code'},
    //     //     {data: 'name', name: 'name'},
    //     //     {data: 'warna', name: 'warna'},
    //     //     {data: 'kategori', name: 'kategori'},
    //     //     {data: 'hrgjual', name: 'hrgjual'},
    //     //     {data: 'size', name: 'size'},
    //     //     {data: 'satuan', name: 'satuan'},
    //     //     {data: 'material', name: 'material'},
    //     //     {data: 'gross', name: 'gross'},
    //     //     {data: 'nett', name: 'nett'},
    //     //     {data: 'spcprice', name: 'spcprice'},
    //     //     {data: 'spcprice', name: 'spcprice'},
    //     // ]
    //     columns: [
    //         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    //         {data: 'code', name: 'code'},
    //         {data: 'name', name: 'name'},
    //         {data: 'warna', name: 'warna'},
    //         {data: 'kategori', name: 'kategori'},
    //         {data: 'hrgjual', name: 'hrgjual'},
    //         {data: 'size', name: 'size'},
    //         {data: 'satuan', name: 'satuan'},
    //         {data: 'material', name: 'material'},
    //         {data: 'gross', name: 'gross'},
    //         {data: 'nett', name: 'nett'},
    //         {data: 'spcprice', name: 'spcprice'},
    //         {
    //             data: 'action', 
    //             name: 'action', 
    //             orderable: true, 
    //             searchable: true
    //         },
    //     ],
    // });

    $('#datatable').DataTable({
        "ordering":false,
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
        nama = $("#nama").val();
        warna = $("#warna").val();
        price = $("#price").val();
        satuan = $("#satuan").val();
        price_gross = $("#price_gross").val();
        price_special = $("#price_special").val();
        kode = $("#kode").val();
        kategori = $("#kategori").val();
        size = $("#size").val();
        material = $("#material").val();
        price_nett = $("#price_nett").val();


        if (kode == ""){
            swal('WARNING', 'Kode Tidak boleh kosong!', 'warning');
            return false;
        }else if (nama == ""){
            swal('WARNING', 'Nama Tidak boleh kosong!', 'warning');
            return false;
        }else if (warna == ""){
            swal('WARNING', 'Warna Tidak boleh kosong!', 'warning');
            return false;
        }else if (price == ""){
            swal('WARNING', 'Price Tidak boleh kosong!', 'warning');
            return false;
        }else if (satuan == ""){
            swal('WARNING', 'Satuan Tidak boleh kosong!', 'warning');
            return false;
        }else if (price_gross == ""){
            swal('WARNING', 'Price Gross Tidak boleh kosong!', 'warning');
            return false;
        }else if (price_special == ""){
            swal('WARNING', 'Price Special Tidak boleh kosong!', 'warning');
            return false;
        }else if(kategori == ""){
            swal('WARNING', 'Kategori Tidak boleh kosong!', 'warning');
            return false;
        }else if(size == ""){
            swal('WARNING', 'Size Tidak boleh kosong!', 'warning');
            return false;
        }else if(material == ""){
            swal('WARNING', 'Material Tidak boleh kosong!', 'warning');
            return false;
        }else if(price_nett == ""){
            swal('WARNING', 'Price Nett Tidak boleh kosong!', 'warning');
            return false;
        }
        // End Validate ifnull
    });

    $("#price").keyup(function(e){
        if (/\D/g.test(this.value)){
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }            
    });

    $("#price_gross").keyup(function(e){
        if (/\D/g.test(this.value)){
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }            
    });

    $("#price_special").keyup(function(e){
        if (/\D/g.test(this.value)){
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }            
    });

    $("#price_nett").keyup(function(e){
        if (/\D/g.test(this.value)){
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }            
    });
</script>
@endsection