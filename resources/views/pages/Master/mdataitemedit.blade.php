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
                                            <input type="text" class="form-control" name="nama" id="nama"
                                                value="{{ $mitem->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Label</label>
                                            <input type="text" class="form-control" name="name_lbl" id="name_lbl"
                                                value="{{ $mitem->name_lbl }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Warna</label>
                                            <textarea class="form-control" style="height:90px" name="warna">{{ $mitem->warna }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Price (Rp)</label>
                                            <input type="text" class="form-control" name="price" id="price"
                                                value="{{ number_format($mitem->hrgjual) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Satuan</label>
                                            <input type="text" class="form-control" name="satuan" id="satuan"
                                                value="{{ $mitem->satuan }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Harga Gross</label>
                                            <input type="text" class="form-control" name="price_gross" id="price_gross"
                                                value="{{ number_format($mitem->gross) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Special Price</label>
                                            <input type="text" class="form-control" name="price_special"
                                                id="price_special" value="{{ number_format($mitem->spcprice) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                @if ($mitem->exist_trans == 'Y')
                                                    <div class="col-md-6">
                                                        <label>Kode / Artikel</label>
                                                        <input type="text" class="form-control" name="kode"
                                                            id="kode" value="{{ $mitem->code }}" readonly>
                                                    </div>
                                                @else
                                                    <div class="col-md-6">
                                                        <label>Kode / Artikel</label>
                                                        <input type="text" class="form-control" name="kode"
                                                            id="kode" value="{{ $mitem->code }}">
                                                    </div>
                                                @endif
                                                <div class="col-md-6" style="display:none;">
                                                    <label>Kode Lama</label>
                                                    <input type="text" class="form-control" name="old_kode"
                                                        id="old_kode" value="{{ $mitem->code }}">
                                                </div>
                                                {{-- <div class="col-md-6 align-self-end">
                                                <button class="btn btn-success mr-1" type="button" id="">Print</button>
                                            </div> --}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <input type="text" class="form-control" name="kategori" id="kategori"
                                                value="{{ $mitem->kategori }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Size</label>
                                            <input type="text" class="form-control" name="size" id="size"
                                                value="{{ $mitem->size }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Materil</label>
                                            <input type="text" class="form-control" name="material" id="material"
                                                value="{{ $mitem->material }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Harga Nett</label>
                                            <input type="text" class="form-control" name="price_nett" id="price_nett"
                                                value="{{ number_format($mitem->nett) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Barcode</label>
                                            <input type="text" class="form-control" name="barcode" id="barcode"
                                                value="{{ $mitem->barcode }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" type="submit"
                                    formaction="/mitem/{{ $mitem->id }}" id="confirm">Update</button>
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
            "bInfo": false
        });

        $(".alert button.close").click(function(e) {
            $(this).parent().fadeOut(2000);
        });

        function submitDel(id) {
            $('#del-' + id).submit()
        }
        $(document).on("click", "#confirm", function(e) {
            // Validate ifnull
            kode = $("#kode").val();
            nama = $("#nama").val();
            if (kode == "") {
                swal('WARNING', 'Kode Tidak boleh kosong!', 'warning');
                return false;
            } else if (nama == 0) {
                swal('WARNING', 'Nama Tidak boleh kosong!', 'warning');
                return false;
            }
        });

        $("#name_lbl").keyup(function(e) {
            if (this.value.length > 8) {
                swal('WARNING', 'Nama label Tidak boleh lebih dari 8 karakter!', 'warning');
                this.value = this.value.slice(0, 8);
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
