@extends('layouts.main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Stock Opname</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
                <div class="breadcrumb-item"><a href="{{ route('tstockopnamelist') }}" class="text-muted">Stock Opname List</a>
                </div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    @include('layouts.flash-message')
                </div>
            </div>
            <form action="{{ route('tstockopnameupdate', $header->id) }}" method="POST" id="editform">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Header Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>No Trans</label>
                                            <input type="text" class="form-control" name="no" id="no"
                                                value="{{ $header->no }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control" name="dt"
                                                value="{{ $header->tanggal }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Counter</label>
                                            <select class="form-control select2" name="counter" id="counter">
                                                <option value="">--Select Counter--</option>
                                                @foreach ($counters as $ctr)
                                                    <option value="{{ $ctr->code }}"
                                                        {{ $header->counter == $ctr->code ? 'selected' : '' }}>
                                                        {{ $ctr->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <textarea class="form-control" style="height:100px" name="note">{{ $header->note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card" style="border: 1px solid lightblue">
                            <div class="card-header">
                                <h4>Add Items</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Artikel</label>
                                            <select class="form-control" id="kode_artikel" disabled>
                                                <option value="">--Pilih Counter dulu--</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Item</label>
                                            <input type="text" class="form-control" id="nama_item" readonly>
                                        </div>
                                        <div class="form-group">
                                            <a href="" id="addItem">
                                                <i class="fa fa-plus" style="font-size:18pt"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Stock</label>
                                            <input type="text" class="form-control" id="stock_item" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input type="text" class="form-control" id="harga_item" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th class="border border-5">No</th>
                                                <th class="border border-5">Kode Artikel</th>
                                                <th class="border border-5">Nama</th>
                                                <th class="border border-5">Stock</th>
                                                <th class="border border-5">Harga</th>
                                                <th class="border border-5">Hasil Opname</th>
                                                <th class="border border-5">Adjustment</th>
                                                <th class="border border-5">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($details as $d)
                                                <tr row_id="{{ $d->no }}">
                                                    <th class="border border-5">{{ $d->no }}</th>
                                                    <td class="border border-5">
                                                        <input readonly form="editform" class="form-control kodeclass"
                                                            name="kode_d[]" type="text" value="{{ $d->kode_barang }}"
                                                            style="width:130px;">
                                                    </td>
                                                    <td class="border border-5">
                                                        <input readonly form="editform" class="form-control namaclass"
                                                            name="nama_d[]" type="text" value="{{ $d->nama_barang }}"
                                                            style="width:160px;">
                                                    </td>
                                                    <td class="border border-5">
                                                        <input readonly form="editform" class="form-control stockclass"
                                                            name="stock_d[]" type="text"
                                                            value="{{ number_format($d->stock, 0, '.', '') }}"
                                                            style="width:90px;" id="stock_d_{{ $d->no }}">
                                                    </td>
                                                    <td class="border border-5">
                                                        <input readonly form="editform" class="form-control hargaclass"
                                                            name="harga_d[]" type="text"
                                                            value="{{ number_format($d->harga, 2, '.', ',') }}"
                                                            style="width:120px;">
                                                    </td>
                                                    <td class="border border-5">
                                                        <input form="editform" class="form-control hasil-opname"
                                                            name="hasil_opname_d[]" type="number" min="0"
                                                            value="{{ number_format($d->hasil_opname, 0, '.', '') }}"
                                                            style="width:110px;" id="hasil_d_{{ $d->no }}"
                                                            data-rowid="{{ $d->no }}">
                                                    </td>
                                                    <td class="border border-5">
                                                        <input readonly form="editform" class="form-control adjustment"
                                                            name="adjustment_d[]" type="text"
                                                            value="{{ number_format($d->adjustment, 0, '.', '') }}"
                                                            style="width:110px;" id="adj_d_{{ $d->no }}">
                                                    </td>
                                                    <td class="border border-5">
                                                        <a title="Delete" class="delete" href="#">
                                                            <i style="font-size:15pt;color:#6777ef;"
                                                                class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('tstockopnamelist') }}" class="btn btn-secondary mr-1">Kembali</a>
                                <button class="btn btn-primary mr-1" id="confirm" type="submit">Update</button>
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
        function formatNum(n) {
            if (n === '' || n === null || isNaN(n)) return n;
            return Number(n).toLocaleString('id-ID');
        }

        function stripNum(s) {
            if (typeof s === 'string') return s.replace(/\./g, '').replace(/,/g, '');
            return s;
        }

        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var rowCounter = $('#datatable tbody tr').length;

            // Init select2 for counter
            $('#counter').select2({
                placeholder: '--Select Counter--'
            });

            // Trigger items load if counter already selected
            var initialCounter = $('#counter').val();
            if (initialCounter) {
                initKodeArtikel(initialCounter);
            }

            $('#counter').on('change', function() {
                var code_counter = $(this).val();
                $('#nama_item').val('');
                $('#stock_item').val('');
                $('#harga_item').val('');

                if (!code_counter) {
                    if ($('#kode_artikel').data('select2')) $('#kode_artikel').select2('destroy');
                    $('#kode_artikel').empty().append('<option value="">--Pilih Counter dulu--</option>')
                        .prop('disabled', true);
                    return;
                }
                initKodeArtikel(code_counter);
            });

            function initKodeArtikel(code_counter) {
                $('#kode_artikel').prop('disabled', false).empty().append(
                    '<option value="">--Select Kode Artikel--</option>');
                if ($('#kode_artikel').data('select2')) $('#kode_artikel').select2('destroy');

                $('#kode_artikel').select2({
                    placeholder: '--Select Kode Artikel--',
                    allowClear: true,
                    ajax: {
                        url: '{{ route('getitemsbycounter') }}',
                        type: 'post',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                _token: CSRF_TOKEN,
                                code_counter: code_counter,
                                search: params.term || ''
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: false
                    },
                    minimumInputLength: 0
                });

                $.ajax({
                    url: '{{ route('getitemsbycounter') }}',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        code_counter: code_counter,
                        search: ''
                    },
                    success: function(response) {
                        $.each(response, function(i, item) {
                            var option = new Option(item.text, item.id, false, false);
                            $(option).attr('data-nama', item.name_mitem).attr('data-stock', item
                                .stock).attr('data-harga', item.harga);
                            $('#kode_artikel').append(option);
                        });
                        $('#kode_artikel').trigger('change.select2');
                    }
                });
            }

            $('#kode_artikel').on('select2:select', function(e) {
                var data = e.params.data;
                $('#nama_item').val(data.name_mitem != null ? data.name_mitem : '');
                $('#stock_item').val(data.stock != null ? formatNum(data.stock) : 0);
                $('#harga_item').val(data.harga != null ? formatNum(data.harga) : 0);
            });

            $('#kode_artikel').on('select2:clear', function() {
                $('#nama_item').val('');
                $('#stock_item').val('');
                $('#harga_item').val('');
            });

            $(document).on('click', '#addItem', function(e) {
                e.preventDefault();
                var kode = $('#kode_artikel').val();
                var nama = $('#nama_item').val();
                var stock = $('#stock_item').val();
                var harga = $('#harga_item').val();

                if (!kode) {
                    alert('Pilih Kode Artikel terlebih dahulu');
                    return false;
                }
                if (!$('#counter').val()) {
                    alert('Pilih Counter terlebih dahulu');
                    return false;
                }

                rowCounter++;
                var rowId = rowCounter;

                var stockRaw = stripNum(stock);
                var hargaRaw = stripNum(harga);
                var tablerow = "<tr row_id='" + rowId + "'>" +
                    "<th class='border border-5'>" + rowId + "</th>" +
                    "<td class='border border-5'><input readonly form='editform' class='form-control kodeclass' name='kode_d[]' type='text' value='" +
                    kode + "' style='width:130px;'></td>" +
                    "<td class='border border-5'><input readonly form='editform' class='form-control namaclass' name='nama_d[]' type='text' value='" +
                    nama + "' style='width:160px;'></td>" +
                    "<td class='border border-5'><input readonly form='editform' class='form-control stockclass' name='stock_d[]' type='text' value='" +
                    stockRaw + "' data-raw='" + stockRaw + "' style='width:90px;' id='stock_d_" + rowId +
                    "'></td>" +
                    "<td class='border border-5'><input readonly form='editform' class='form-control hargaclass' name='harga_d[]' type='text' value='" +
                    formatNum(hargaRaw) + "' data-raw='" + hargaRaw + "' style='width:120px;'></td>" +
                    "<td class='border border-5'><input form='editform' class='form-control hasil-opname' name='hasil_opname_d[]' type='number' min='0' value='0' style='width:110px;' id='hasil_d_" +
                    rowId + "' data-rowid='" + rowId + "'></td>" +
                    "<td class='border border-5'><input readonly form='editform' class='form-control adjustment' name='adjustment_d[]' type='text' value='0' style='width:110px;' id='adj_d_" +
                    rowId + "'></td>" +
                    "<td class='border border-5'><a title='Delete' class='delete' href='#'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td>" +
                    "</tr>";

                $('#datatable tbody').append(tablerow);
                $('#kode_artikel').val(null).trigger('change');
                $('#nama_item').val('');
                $('#stock_item').val('');
                $('#harga_item').val('');
            });

            $(document).on('input keyup', '.hasil-opname', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                var rowId = $(this).data('rowid');
                var hasil = parseInt($(this).val()) || 0;
                var adj = hasil;
                var adjStr = adj > 0 ? '+' + formatNum(adj) : '' + formatNum(adj);
                $('#adj_d_' + rowId).val(adjStr);
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                if (confirm('Hapus item ini?')) {
                    $(this).closest('tr').remove();
                    var table = document.getElementById('datatable');
                    for (var i = 1; i < table.rows.length; i++) {
                        table.rows[i].cells[0].innerText = i;
                    }
                }
            });

            // Format existing rows on load
            $('#datatable tbody tr').each(function() {
                var $tr = $(this);
                var rowId = $tr.attr('row_id');
                var $stock = $('#stock_d_' + rowId);
                var $adj = $('#adj_d_' + rowId);
                var rawStock = stripNum($stock.val());
                $stock.val(rawStock).attr('data-raw', rawStock);
                var adjVal = stripNum($adj.val());
                var adjNum = parseInt(adjVal) || 0;
                $adj.val(adjNum > 0 ? '+' + formatNum(adjNum) : formatNum(adjNum));
                $tr.find('.hargaclass').each(function() {
                    var raw = stripNum($(this).val());
                    $(this).val(formatNum(raw)).attr('data-raw', raw);
                });
            });

            $(document).on('click', '#confirm', function(e) {
                var counter = $('#counter').val();
                if (!counter) {
                    swal('WARNING', 'Pilih Counter terlebih dahulu!', 'warning');
                    return false;
                }
                if ($('#datatable tbody tr').length === 0) {
                    swal('WARNING', 'Item pada tabel minimal harus ada 1!', 'warning');
                    return false;
                }
                // Strip formatting before submit
                $('#datatable tbody .stockclass').each(function() {
                    $(this).val(stripNum($(this).val()));
                });
                $('#datatable tbody .hargaclass').each(function() {
                    $(this).val(stripNum($(this).val()));
                });
                $('#datatable tbody .adjustment').each(function() {
                    $(this).val(stripNum($(this).val()));
                });
                show_loading();
            });
        });
    </script>
@endsection
