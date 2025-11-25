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
                                            <label>Nama Label</label>
                                            <input type="text" class="form-control" name="name_lbl" id="name_lbl">
                                        </div>
                                        <div class="form-group">
                                            <label>Warna</label>
                                            <select class="form-control select2" id="warna" name="warna">
                                                <option disabled selected>--Select Warna--</option>
                                                @foreach ($warnas as $data => $warna)
                                                    <option value="{{ $warna->code }}">
                                                        {{ $warna->code . ' - ' . $warna->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Price (Rp)</label>
                                            <input type="text" class="form-control" name="price" id="price"
                                                value="0">
                                        </div>
                                        <div class="form-group">
                                            <label>Satuan</label>
                                            <input type="text" class="form-control" name="satuan" id="satuan">
                                        </div>
                                        <div class="form-group">
                                            <label>Harga Gross</label>
                                            <input type="text" class="form-control" name="price_gross" id="price_gross"
                                                value="0">
                                        </div>
                                        <div class="form-group">
                                            <label>Special Price</label>
                                            <input type="text" class="form-control" name="price_special"
                                                id="price_special" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode / Artikel</label>
                                            <input type="text" class="form-control" name="kode" id="kode">
                                            {{-- <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6 align-self-end">
                                                
                                            </div>
                                        </div> --}}
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
                                            <input type="text" class="form-control" name="price_nett" id="price_nett"
                                                value="0">
                                        </div>
                                        <div class="form-group">
                                            <label>Barcode</label>
                                            <input type="text" class="form-control" name="barcode" id="barcode">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" type="submit" formaction="{{ route('mitempost') }}"
                                    id="confirm">Save</button>
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
                                        <input type="text" class="form-control" placeholder="Search" name="search"
                                            value="@php if(request()->input('search')==NULL){ echo "";} else{ echo $_GET['search']; } @endphp">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row pb-3">
                                <div class="col-6"></div>
                                <div class="col-6 d-flex justify-content-end">
                                    <button type="submit" formaction="mitemexcel" formtarget="_blank"
                                        class="btn btn-success"><i class="far fa-file-excel"></i><span> Export
                                            Excel</span></button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatable">
                                    {{-- <table class="table table-bordered yajra-datatable"> --}}
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border border-5" style="text-align: center;">No
                                            </th>
                                            <th scope="col" class="border border-5" style="text-align: center;">Kode /
                                                Artikel</th>
                                            <th scope="col" class="border border-5" style="text-align: center;">Nama
                                            </th>
                                            <th scope="col" class="border border-5" style="text-align: center;">Warna
                                            </th>
                                            <th scope="col" class="border border-5" style="text-align: center;">
                                                Kategori</th>
                                            <th scope="col" class="border border-5" style="text-align: center;">Price
                                                (Rp.)</th>
                                            <th scope="col" class="border border-5" style="text-align: center;">Size
                                            </th>
                                            <th scope="col" class="border border-5" style="text-align: center;">Satuan
                                            </th>
                                            <th scope="col" class="border border-5" style="text-align: center;">
                                                Material</th>
                                            <th scope="col" class="border border-5" style="text-align: center;">Harga
                                                Gross</th>
                                            <th scope="col" class="border border-5" style="text-align: center;">Harga
                                                Nett</th>
                                            <th scope="col" class="border border-5" style="text-align: center;">
                                                Special Price</th>
                                            <th scope="col" class="border border-5" style="text-align: center;">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 0 @endphp
                                        @foreach ($datas as $data => $item)
                                            @php $counter++ @endphp
                                            <tr>
                                                <th scope="row" class="border border-5">{{ $counter }}</th>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ $item->code }}</td>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ $item->name }}</td>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ $item->warna }}</td>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ $item->kategori }}</td>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ number_format($item->hrgjual, 2, '.', ',') }}</td>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ $item->size }}</td>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ $item->satuan }}</td>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ $item->material }}</td>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ number_format($item->gross, 2, '.', ',') }}</td>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ number_format($item->nett, 2, '.', ',') }}</td>
                                                <td class="border border-5" style="text-align: center;">
                                                    {{ number_format($item->spcprice, 2, '.', ',') }}</td>
                                                <td style="text-align: center;" class="d-flex justify-content-center">
                                                    <a href="/mitem/{{ $item->id }}/edit"
                                                        class="btn btn-icon icon-left btn-primary"><i class="far fa-edit">
                                                            Edit</i></a>
                                                    @if ($item->exist_trans == 'Y')
                                                        <form action="/mitem/delete/{{ $item->id }}"
                                                            id="del-{{ $item->id }}" method="POST" class="px-2">
                                                            @csrf
                                                            <button class="btn btn-icon icon-left btn-danger" disabled
                                                                id="del-{{ $item->id }}" type="submit"
                                                                data-confirm="WARNING!|Do you want to delete {{ $item->name }} data?"
                                                                data-confirm-yes="submitDel({{ $item->id }})"><i
                                                                    class="fa fa-trash">
                                                                    Delete</i></button>
                                                        </form>
                                                    @else
                                                        <form action="/mitem/delete/{{ $item->id }}"
                                                            id="del-{{ $item->id }}" method="POST" class="px-2">
                                                            @csrf
                                                            <button class="btn btn-icon icon-left btn-danger"
                                                                id="del-{{ $item->id }}" type="submit"
                                                                data-confirm="WARNING!|Do you want to delete {{ $item->name }} data?"
                                                                data-confirm-yes="submitDel({{ $item->id }})"><i
                                                                    class="fa fa-trash">
                                                                    Delete</i></button>
                                                        </form>
                                                    @endif
                                                    <div class="div pr-2">
                                                        <a href="/mitem/{{ $item->id }}/print"
                                                            class="btn btn-icon icon-left btn-success" target="_blank"><i
                                                                class="far fa-print">
                                                                Print</i></a>
                                                    </div>
                                                    <a href="/mitem/{{ $item->id }}/barcode"
                                                        class="btn btn-icon icon-left btn-success" target="_blank"><i
                                                            class="far fa-print">
                                                            Barcode</i></a>
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
            "ordering": false,
            "bInfo": false,
            "bPaginate": false,
            "searching": false
        });

        $(".alert button.close").click(function(e) {
            $(this).parent().fadeOut(2000);
        });

        function submitDel(id) {
            $('#del-' + id).submit()
        }
        $(document).on("click", "#confirm", function(e) {
            // Validate ifnull
            nama = $("#nama").val();
            warna = $("#warna").prop('selectedIndex');
            price = $("#price").val();
            satuan = $("#satuan").val();
            price_gross = $("#price_gross").val();
            price_special = $("#price_special").val();
            kode = $("#kode").val();
            kategori = $("#kategori").val();
            size = $("#size").val();
            material = $("#material").val();
            price_nett = $("#price_nett").val();


            if (nama == "") {
                swal('WARNING', 'Nama Tidak boleh kosong!', 'warning');
                return false;
            } else if (kode == "") {
                swal('WARNING', 'Kode Tidak boleh kosong!', 'warning');
                return false;
            } else if (warna == "" || warna == 0) {
                swal('WARNING', 'Warna Tidak boleh kosong!', 'warning');
                return false;
            } else if (price == "") {
                swal('WARNING', 'Price Tidak boleh kosong!', 'warning');
                return false;
            } else if (satuan == "") {
                swal('WARNING', 'Satuan Tidak boleh kosong!', 'warning');
                return false;
            } else if (price_gross == "") {
                swal('WARNING', 'Price Gross Tidak boleh kosong!', 'warning');
                return false;
            } else if (price_special == "") {
                swal('WARNING', 'Price Special Tidak boleh kosong!', 'warning');
                return false;
            } else if (kategori == "") {
                swal('WARNING', 'Kategori Tidak boleh kosong!', 'warning');
                return false;
            } else if (price_nett == "") {
                swal('WARNING', 'Price Nett Tidak boleh kosong!', 'warning');
                return false;
            }
            // End Validate ifnull
        });

        $('#kode')
            .on('keydown', function(e) {
                if (e.key === ' ' || e.keyCode === 32) e.preventDefault();
            })
            .on('input', function() {
                this.value = this.value.replace(/\s/g, '');
            });
        $("#name_lbl").keyup(function(e) {
            if (this.value.length > 8) {
                swal('WARNING', 'Nama label Tidak boleh lebih dari 8 karakter!', 'warning');
                this.value = this.value.slice(0, 8);
            }
        });

        $("#price").keyup(function(e) {
            if (/\D/g.test(this.value)) {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });

        $(document).on("change", "#price", function(e) {
            if ($('#price').val() == '') {
                $('#price').val(0);
            }
            $(this).val(thousands_separators($(this).val()));
        });

        $(document).on("click", "#price", function(e) {
            if (/\D/g.test(this.value)) {
                // Filter comma
                this.value = this.value.replace(/\,/g, "");
                this.value = Number(Math.trunc(this.value))
            }
        });

        $("#price_gross").keyup(function(e) {
            if (/\D/g.test(this.value)) {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });

        $(document).on("change", "#price_gross", function(e) {
            if ($('#price_gross').val() == '') {
                $('#price_gross').val(0);
            }
            $(this).val(thousands_separators($(this).val()));
        });

        $(document).on("click", "#price_gross", function(e) {
            if (/\D/g.test(this.value)) {
                // Filter comma
                this.value = this.value.replace(/\,/g, "");
                this.value = Number(Math.trunc(this.value))
            }
        });

        $("#price_special").keyup(function(e) {
            if (/\D/g.test(this.value)) {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });

        $(document).on("change", "#price_special", function(e) {
            if ($('#price_special').val() == '') {
                $('#price_special').val(0);
            }
            $(this).val(thousands_separators($(this).val()));
        });

        $(document).on("click", "#price_special", function(e) {
            if (/\D/g.test(this.value)) {
                // Filter comma
                this.value = this.value.replace(/\,/g, "");
                this.value = Number(Math.trunc(this.value))
            }
        });

        $("#price_nett").keyup(function(e) {
            if (/\D/g.test(this.value)) {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });

        $(document).on("change", "#price_nett", function(e) {
            if ($('#price_nett').val() == '') {
                $('#price_nett').val(0);
            }
            $(this).val(thousands_separators($(this).val()));
        });

        $(document).on("click", "#price_nett", function(e) {
            if (/\D/g.test(this.value)) {
                // Filter comma
                this.value = this.value.replace(/\,/g, "");
                this.value = Number(Math.trunc(this.value))
            }
        });

        $("#barcode").keyup(function(e) {
            var input = $(this).val();
            if (input.length > 16) {
                $(this).val(input.substring(0, 16)); // Truncate the input to 16 characters
            }
        });
    </script>
@endsection
