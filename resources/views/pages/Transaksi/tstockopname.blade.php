@extends('layouts.main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Transaksi Stock Opname</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
                <div class="breadcrumb-item"><a class="text-muted">Stock Opname</a></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    @include('layouts.flash-message')
                </div>
            </div>
            <form action="" method="POST" id="thisform">
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
                                            @foreach ($notrans as $key => $code)
                                                @php $codetrans = $code->codetrans @endphp
                                            @endforeach
                                            <input type="text" class="form-control" name="no" id="no"
                                                value="{{ $code->codetrans }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control" name="dt"
                                                value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Counter</label>
                                            <select class="form-control select2" name="counter" id="counter">
                                                <option value="">--Select Counter--</option>
                                                @foreach ($counters as $ctr)
                                                    <option value="{{ $ctr->code }}">{{ $ctr->name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Pilih counter terlebih dahulu sebelum memilih kode
                                                artikel</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <textarea class="form-control" style="height:100px" name="note"></textarea>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" id="confirm" type="submit"
                                    formaction="{{ route('tstockopnamepost') }}">Save</button>
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
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var rowCounter = 0;

            // Init select2 for counter
            $('#counter').select2({
                placeholder: '--Select Counter--'
            });

            // When counter changes, reinit kode_artikel select2 AJAX
            $('#counter').on('change', function() {
                var code_counter = $(this).val();

                // Reset item fields
                $('#nama_item').val('');
                $('#stock_item').val('');
                $('#harga_item').val('');

                if (!code_counter) {
                    // Destroy select2 and disable
                    if ($('#kode_artikel').data('select2')) {
                        $('#kode_artikel').select2('destroy');
                    }
                    $('#kode_artikel').empty().append('<option value="">--Pilih Counter dulu--</option>')
                        .prop('disabled', true);
                    return;
                }

                // Enable and init select2 AJAX
                $('#kode_artikel').prop('disabled', false).empty().append(
                    '<option value="">--Select Kode Artikel--</option>');

                if ($('#kode_artikel').data('select2')) {
                    $('#kode_artikel').select2('destroy');
                }

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

                // Trigger load of default 10 items
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
                            $(option).attr('data-nama', item.name_mitem)
                                .attr('data-stock', item.stock)
                                .attr('data-harga', item.harga);
                            $('#kode_artikel').append(option);
                        });
                        $('#kode_artikel').trigger('change.select2');
                    }
                });
            });

            // When kode artikel selected, fill info
            $('#kode_artikel').on('select2:select', function(e) {
                var data = e.params.data;
                $('#nama_item').val(data.name_mitem != null ? data.name_mitem : '');
                $('#stock_item').val(data.stock != null ? data.stock : 0);
                $('#harga_item').val(data.harga != null ? data.harga : 0);
            });

            $('#kode_artikel').on('select2:clear', function() {
                $('#nama_item').val('');
                $('#stock_item').val('');
                $('#harga_item').val('');
            });

            // Add item to table
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

                var tablerow = "<tr row_id='" + rowId + "'>" +
                    "<th class='border border-5'>" + rowId + "</th>" +
                    "<td class='border border-5'><input readonly form='thisform' class='form-control kodeclass' name='kode_d[]' type='text' value='" +
                    kode + "' style='width:130px;'></td>" +
                    "<td class='border border-5'><input readonly form='thisform' class='form-control namaclass' name='nama_d[]' type='text' value='" +
                    nama + "' style='width:160px;'></td>" +
                    "<td class='border border-5'><input readonly form='thisform' class='form-control stockclass' name='stock_d[]' type='text' value='" +
                    stock + "' style='width:90px;' id='stock_d_" + rowId + "'></td>" +
                    "<td class='border border-5'><input readonly form='thisform' class='form-control hargaclass' name='harga_d[]' type='text' value='" +
                    harga + "' style='width:120px;'></td>" +
                    "<td class='border border-5'><input form='thisform' class='form-control hasil-opname' name='hasil_opname_d[]' type='number' min='0' value='0' style='width:110px;' id='hasil_d_" +
                    rowId + "' data-rowid='" + rowId + "'></td>" +
                    "<td class='border border-5'><input readonly form='thisform' class='form-control adjustment' name='adjustment_d[]' type='text' value='0' style='width:110px;' id='adj_d_" +
                    rowId + "'></td>" +
                    "<td class='border border-5'><a title='Delete' class='delete' href='#'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td>" +
                    "</tr>";

                $('#datatable tbody').append(tablerow);

                // reset item panel
                $('#kode_artikel').val(null).trigger('change');
                $('#nama_item').val('');
                $('#stock_item').val('');
                $('#harga_item').val('');
            });

            // Compute adjustment when hasil opname changes
            $(document).on('input keyup', '.hasil-opname', function() {
                // only numbers
                this.value = this.value.replace(/[^0-9]/g, '');
                var rowId = $(this).data('rowid');
                var stock = parseInt($('#stock_d_' + rowId).val()) || 0;
                var hasil = parseInt($(this).val()) || 0;
                var adj = hasil - stock;
                var adjStr = adj >= 0 ? '+' + adj : '' + adj;
                $('#adj_d_' + rowId).val(adjStr);
            });

            // Delete row
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                if (confirm('Hapus item ini?')) {
                    $(this).closest('tr').remove();
                    rowCounter--;
                    // renumber
                    var table = document.getElementById('datatable');
                    for (var i = 1; i < table.rows.length; i++) {
                        table.rows[i].cells[0].innerText = i;
                    }
                }
            });

            // Save validation
            $(document).on('click', '#confirm', function(e) {
                var no = $('#no').val();
                var counter = $('#counter').val();
                if (!no) {
                    swal('WARNING', 'No Trans tidak boleh kosong!', 'warning');
                    return false;
                }
                if (!counter) {
                    swal('WARNING', 'Pilih Counter terlebih dahulu!', 'warning');
                    return false;
                }
                if ($('#datatable tbody tr').length === 0) {
                    swal('WARNING', 'Item pada tabel minimal harus ada 1!', 'warning');
                    return false;
                }
                show_loading();
            });
        });
    </script>
@endsection
