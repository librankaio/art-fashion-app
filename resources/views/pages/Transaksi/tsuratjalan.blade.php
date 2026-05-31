@extends('layouts.main')

@section('topscripts')
    <style>
        /* Tabel item: center semua konten, padding rapi */
        #datatable thead th,
        #datatable tbody td,
        #datatable tbody th {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 6px 8px !important;
        }

        #datatable tbody td input.form-control {
            text-align: center;
            margin: 0 auto;
        }

        /* Stock label di kolom qty agar simetris dan tidak mentok ke garis tabel */
        #datatable tbody td .stock-label-row {
            display: block;
            margin-top: 5px;
            margin-bottom: 2px;
            font-size: 11px;
            line-height: 1.4;
            white-space: nowrap;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Surat Jalan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
                <div class="breadcrumb-item"><a class="text-muted">Surat Jalan</a></div>
            </div>
        </div>
        @php
            $tpos_save = session('tpos_save');
        @endphp
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    @include('layouts.flash-message-sj')
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
                                            <label>No SOB.</label>
                                            <select class="form-control select2" name="nosob" id="nosob">
                                                <option disabled selected>--Select No SOB--</option>
                                                @foreach ($sobs as $data => $sob)
                                                    <option>{{ $sob->no }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Counter From</label>
                                            <select class="form-control select2" name="counter_from" id="counter_from">
                                                {{-- <option disabled selected>--Select Counter--</option> --}}
                                                @foreach ($counters as $counter)
                                                    <option>{{ $counter->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Counter To</label>
                                            {{-- @foreach ($counters as $counter)
                                    <input type="text" class="form-control" name="counter" id="counter" value="{{ $counter->name}}" readonly>
                                    @endforeach --}}
                                            <select class="form-control select2" name="counter" id="counter">
                                                {{-- <option disabled selected>--Select Counter--</option> --}}
                                                @foreach ($counters as $counter)
                                                    <option>{{ $counter->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select class="form-control" name="jenis" id="jenis">
                                                <option>Normal</option>
                                                <option>Retur</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control" name="dt"
                                                value="{{ date('Y-m-d') }}">
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
                        <div class="card" id="card_items" style="border: 1px solid lightblue;">
                            {{-- <div class="card" id="card_items" style="border: 1px solid lightblue; [display:none;]"> --}}
                            <div class="card-header">
                                <h4>Add Items</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode</label>
                                            <select class="form-control select2" id="kode">
                                                <option></option>
                                                {{-- @foreach ($mitems as $data => $item)                                        
                                        <option value="{{ $item->code }}">{{ $item->code." - ".$item->name }}</option>
                                        @endforeach --}}
                                            </select>
                                            <small id="stock_label" class="mt-1 d-block" style="display:none;"></small>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Item</label>
                                            <input type="text" class="form-control" id="nama_item" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Warna</label>
                                            <input type="text" class="form-control" id="warna" disabled>
                                        </div>
                                        <div class="form-group">
                                            <a href="" id="addItem">
                                                <i class="fa fa-plus" style="font-size:18pt"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Satuan</label>
                                            <input type="text" class="form-control" id="satuan" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="text" class="form-control" id="quantity" value="0">
                                        </div>
                                        <div class="form-group">
                                            <label>Harga Jual</label>
                                            <input type="text" class="form-control" id="hrgjual" value="0">
                                        </div>
                                        <div class="form-group">
                                            <label>Subtotal</label>
                                            <input type="text" class="form-control" id="subtot" disabled>
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
                                    <div class="form-group">
                                        {{-- <label>counter</label> --}}
                                        <input type="text" class="form-control" id="number_counter" value="0"
                                            hidden readonly>
                                    </div>
                                    <table class="table table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="border border-5">No</th>
                                                <th scope="col" class="border border-5">Kode</th>
                                                <th scope="col" class="border border-5">Nama Item</th>
                                                <th scope="col" class="border border-5">Warna</th>
                                                <th scope="col" class="border border-5">Quantity</th>
                                                <th scope="col" class="border border-5">Satuan</th>
                                                <th scope="col" class="border border-5">Harga</th>
                                                <th scope="col" class="border border-5">Sub Total Harga</th>
                                                <th scope="col" class="border border-5">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 align-self-end">
                                <div class="row">
                                    <div class="col-md-8">

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total</label>
                                            <input type="text" class="form-control" name="price_total"
                                                form="thisform" id="price_total" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a class="btn btn-warning mr-1 text-light" onclick="filterlist()">List</a>
                                {{-- <a class="btn btn-warning mr-1 text-light" href="/tsuratjalanlist" onclick="filterlist()">List</a> --}}
                                <button class="btn btn-primary mr-1" id="confirm" type="submit"
                                    formaction="{{ route('tsuratjalanpost') }}">Save</button>
                                {{-- @if ($tpos_save == 'Y')
                            <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('transpospost') }}">Submit</button>
                        @elseif($tpos_save == 'N' || $tpos_save == null)
                            <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('transpospost') }}" disabled>Submit</button>
                        @endif --}}
                                {{-- <button class="btn btn-secondary" type="reset">Reset</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    {{-- MODAL LIST --}}
    <div class="modal" tabindex="-1" id="modal-list-part">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">FILTER LIST</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tsuratjalanlist') }}" method="GET">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Counter List</label>
                            <select class="form-control" name="counter_filter" id="counter_filter">
                                {{-- @if ($latest_counter != null)
                            <option selected>{{ $latest_counter->counter }}</option>
                        @endif --}}
                                @foreach ($counters as $counter)
                                    <option>{{ $counter->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary mr-1" type="submit" id="confirm_modal_filter"
                            onclick="submitFormFilter();">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('botscripts')
    <script type="text/javascript">
        // MODAL TRIGGER
        function filterlist() {
            $('#modal-list-part').modal({
                backdrop: 'static',
                keyboard: true,
                show: true,
            });
        }

        function submitFormFilter() {
            // alert('Form has been submitted');
            $('#confirm_modal_filter').submit()
        }
        $(document).ready(function() {
            rowCount = $('#number_counter').val();
            var counter = Number($('#number_counter').val());
            //CSRF TOKEN
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function() {
                $("#jenis").select2({});
                // $("#counter_filter").select2({});

                $('#counter_filter').select2({
                    dropdownParent: $('#modal-list-part')
                });
                $("#kode").select2({
                    placeholder: 'Select Kode',
                    ajax: {
                        url: "{{ route('getmitemv2') }}",
                        type: "post",
                        dataType: "json",
                        delay: 250,
                        data: function(params) {
                            return {
                                _token: CSRF_TOKEN,
                                search: params.term, //search term
                            };
                        },
                        processResults: function(response) {
                            console.log(response)
                            return {
                                results: response,
                            };
                        },
                        cache: true,
                    }
                });

                // ===== SCANNER DETECTION =====
                var scannerLastKeyTime = 0;
                var scannerThreshold = 50;
                var isScannerInput = false;
                var scannerBuffer = '';
                var scannerBufferTimer = null;

                // === GLOBAL SCANNER: tangkap input dari mana saja di halaman ===
                var globalScannerBuffer = '';
                var globalScannerLastKeyTime = 0;
                var globalScannerTimer = null;
                var globalIsScannerInput = false;

                document.addEventListener('keydown', function(e) {
                    var activeEl = document.activeElement;
                    var isInSelect2Search = activeEl && activeEl.classList.contains(
                        'select2-search__field');

                    // --- Intercept Enter di dalam Select2 search field ---
                    if (e.key === 'Enter' && isInSelect2Search) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        if (isScannerInput && scannerBuffer.length > 0) {
                            var searchTerm = scannerBuffer;
                            scannerBuffer = '';
                            isScannerInput = false;
                            scannerLastKeyTime = 0;
                            clearTimeout(scannerBufferTimer);
                            doScannerSearch(searchTerm);
                        }
                        return;
                    }

                    // --- Global scanner: tangkap jika fokus BUKAN di input/textarea/select ---
                    var tag = activeEl ? activeEl.tagName : '';
                    var isTypingField = (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT');

                    if (!isTypingField) {
                        var now = Date.now();
                        var timeDiff = now - globalScannerLastKeyTime;

                        if (e.key === 'Enter') {
                            if (globalIsScannerInput && globalScannerBuffer.length > 0) {
                                e.preventDefault();
                                var searchTerm = globalScannerBuffer;
                                globalScannerBuffer = '';
                                globalIsScannerInput = false;
                                globalScannerLastKeyTime = 0;
                                clearTimeout(globalScannerTimer);
                                doScannerSearch(searchTerm);
                            }
                            globalScannerBuffer = '';
                            return;
                        }

                        if (e.key.length === 1) {
                            if (globalScannerLastKeyTime !== 0 && timeDiff < scannerThreshold) {
                                globalIsScannerInput = true;
                            } else if (timeDiff >= scannerThreshold) {
                                globalIsScannerInput = false;
                                globalScannerBuffer = '';
                            }
                            globalScannerLastKeyTime = now;
                            globalScannerBuffer += e.key;

                            clearTimeout(globalScannerTimer);
                            globalScannerTimer = setTimeout(function() {
                                globalScannerBuffer = '';
                                globalIsScannerInput = false;
                            }, 300);
                        }
                    }
                }, true); // capture phase

                // Fungsi terpusat search & auto-select via AJAX
                function doScannerSearch(searchTerm) {
                    $.ajax({
                        url: "{{ route('getmitemv2') }}",
                        type: "post",
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: searchTerm
                        },
                        success: function(response) {
                            if (response && response.length > 0) {
                                var firstItem = response[0];
                                var option = new Option(firstItem.text, firstItem.id, true,
                                    true);
                                $('#kode').append(option).trigger('change');
                                $('#kode').trigger({
                                    type: 'select2:select',
                                    params: {
                                        data: firstItem
                                    }
                                });
                                $('#kode').select2('close');
                            } else {
                                swal('WARNING', 'Kode tidak ditemukan!', 'warning');
                            }
                        }
                    });
                }

                // Auto-focus search field saat Select2 #kode dibuka
                $('#kode').on('select2:open', function() {
                    var searchField = document.querySelector(
                        '.select2-container--open .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    } else {
                        setTimeout(function() {
                            var el = document.querySelector(
                                '.select2-container--open .select2-search__field');
                            if (el) el.focus();
                        }, 50);
                    }
                });

                // Buffer untuk Select2 search field (saat dropdown sudah terbuka)
                $(document).on('keydown', '.select2-search__field', function(e) {
                    var now = Date.now();
                    var timeDiff = now - scannerLastKeyTime;

                    if (e.key !== 'Enter') {
                        if (scannerLastKeyTime !== 0 && timeDiff < scannerThreshold) {
                            isScannerInput = true;
                        } else if (timeDiff >= scannerThreshold) {
                            isScannerInput = false;
                            scannerBuffer = '';
                        }
                        scannerLastKeyTime = now;
                        if (e.key.length === 1) {
                            scannerBuffer += e.key;
                        }
                        clearTimeout(scannerBufferTimer);
                        scannerBufferTimer = setTimeout(function() {
                            scannerBuffer = '';
                            isScannerInput = false;
                        }, 300);
                    }
                });
                // ===== END SCANNER DETECTION =====

                $("#kode").on('select2:select', function(e) {
                    var kode = $(this).val();
                    show_loading()
                    $.ajax({
                        url: '{{ route('getmitem') }}',
                        method: 'post',
                        data: {
                            'kode': kode
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response) {
                            // console.log(kode);
                            console.log(response);
                            for (i = 0; i < response.length; i++) {
                                if (response[i].code == kode) {
                                    $("#nama_item").val(response[i].name)
                                    hrg = Number(response[i].hrgjual);
                                    $("#satuan").val(response[i].satuan);
                                    $("#warna").val(response[i].warna);
                                    subtotal = Number(hrg).toFixed(2) * $('#quantity')
                                        .val()
                                    $("#subtot").val(thousands_separators(subtotal
                                        .toFixed(2)));
                                    $("#hrgjual").val(thousands_separators(hrg.toFixed(
                                        2)));
                                }
                            }
                            hide_loading()
                        }
                    });

                    // Cek stock item di counter_from yang dipilih
                    var counter_from_val = $('#counter_from').val();
                    if (kode && counter_from_val) {
                        $.ajax({
                            url: '{{ route('tbonjualgetitemstock') }}',
                            method: 'post',
                            data: {
                                'kode': kode,
                                'counter': counter_from_val
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function(res) {
                                var stock = parseInt(res.stock) || 0;
                                var label = $('#stock_label');
                                label.show();
                                label.removeClass(
                                    'text-danger text-warning text-muted font-weight-bold'
                                );
                                if (stock < 10) {
                                    label.addClass('text-danger font-weight-bold');
                                    label.html(
                                        '<i class="fas fa-exclamation-circle"></i> Stock: ' +
                                        stock + ' (Stok Menipis!)');
                                } else if (stock <= 20) {
                                    label.addClass('text-warning font-weight-bold');
                                    label.html(
                                        '<i class="fas fa-exclamation-triangle"></i> Stock: ' +
                                        stock + ' (Stok Terbatas)');
                                } else {
                                    label.addClass('text-muted');
                                    label.html(
                                        '<i class="fas fa-check-circle"></i> Stock: ' +
                                        stock);
                                }
                            }
                        });
                    } else {
                        $('#stock_label').hide().text('');
                    }
                });

                // Update stock label ketika counter_from berubah
                $('#counter_from').on('change', function() {
                    var kode = $('#kode').val();
                    var counter_from_val = $(this).val();
                    if (kode && counter_from_val) {
                        $.ajax({
                            url: '{{ route('tbonjualgetitemstock') }}',
                            method: 'post',
                            data: {
                                'kode': kode,
                                'counter': counter_from_val
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function(res) {
                                var stock = parseInt(res.stock) || 0;
                                var label = $('#stock_label');
                                label.show();
                                label.removeClass(
                                    'text-danger text-warning text-muted font-weight-bold'
                                );
                                if (stock < 10) {
                                    label.addClass('text-danger font-weight-bold');
                                    label.html(
                                        '<i class="fas fa-exclamation-circle"></i> Stock: ' +
                                        stock + ' (Stok Menipis!)');
                                } else if (stock <= 20) {
                                    label.addClass('text-warning font-weight-bold');
                                    label.html(
                                        '<i class="fas fa-exclamation-triangle"></i> Stock: ' +
                                        stock + ' (Stok Terbatas)');
                                } else {
                                    label.addClass('text-muted');
                                    label.html(
                                        '<i class="fas fa-check-circle"></i> Stock: ' +
                                        stock);
                                }
                            }
                        });
                    } else {
                        $('#stock_label').hide().text('');
                    }
                });

                var nosob = $(this).val();
                show_loading()
                console.log(nosob);
                $.ajax({
                    url: '{{ route('getnosobd') }}',
                    method: 'post',
                    data: {
                        'nosob': nosob
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        if ($('#number_counter').val() == 0) {
                            console.log('masuk');
                            console.log(response);
                            number_counter = Number($('#number_counter').val());
                            for (i = 0; i < response.length; i++) {
                                if (response[i].no_sob == nosob) {
                                    // if(number_counter == 0){
                                    //     number_counter++;
                                    // }

                                    subtotparse = thousands_separators(Number(
                                        response[i].subtotal).toFixed(2));

                                    if ($("#price_total").val() == 0 || $(
                                            "#price_total").val() == '') {
                                        $("#price_total").val(subtotparse);
                                        number_counter++;
                                        counter++;
                                        console.log(number_counter);
                                    } else if ($("#price_total").val() >= 0 || $(
                                            "#price_total").val() != '') {
                                        old_grandtot = $('#price_total').val();
                                        counter++;
                                        if (/\D/g.test(old_grandtot)) {
                                            // Filter comma
                                            old_grandtot = old_grandtot.replace(
                                                /\,/g, "");
                                            old_grandtot = Number(Math.trunc(
                                                old_grandtot))
                                        }

                                        if (/\D/g.test(subtotparse)) {
                                            // Filter comma
                                            subtotparse = subtotparse.replace(/\,/g,
                                                "");
                                            subtotparse = Number(Math.trunc(
                                                subtotparse))
                                        }

                                        sum = subtotparse + old_grandtot;

                                        new_grandtot = thousands_separators(Number(
                                            sum).toFixed(2));
                                        $("#price_total").val(new_grandtot);
                                        console.log(number_counter);
                                        // number_counter++;
                                    }
                                    // number_new = $('#number_counter').val();
                                    tablerow = "<tr row_id=" + number_counter +
                                        "><th style='readonly:true;' class='border border-5'>" +
                                        number_counter +
                                        "</th><td class='border border-5' style='display:none;'><input style='width:120px;' readonly form='thisform' class='numberclass form-control' type='text' value='" +
                                        counter +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" +
                                        response[i].code +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='" +
                                        response[i].name +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" +
                                        response[i].warna +
                                        "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' value='" +
                                        parseInt(response[i].qty) + "' id='qty_d_" +
                                        counter +
                                        "'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='" +
                                        response[i].satuan +
                                        "' name='satuan_d[]'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' readonly class='row_hrgjual hrgjualclass form-control' name='hrgjual_d[]' value='" +
                                        thousands_separators(Number(response[i]
                                            .hrgjual).toFixed(2)) +
                                        "' id='hrgjual_d_" + number_counter +
                                        "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' readonly class='subtotclass form-control' name='subtot_d[]' id='subtot_d_" +
                                        number_counter + "' value='" +
                                        thousands_separators(Number(response[i]
                                            .subtotal).toFixed(2)) +
                                        "'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" +
                                        no + "'></td></tr>";
                                    $("#datatable tbody").append(tablerow);
                                    number_counter++;
                                    number_new = number_counter;
                                    $('#number_counter').val(number_new);

                                }
                            }
                            // var x = document.getElementById("card_items");
                            // if (x.style.display === "none") {
                            //     x.style.display = "block";
                            // } else {
                            //     x.style.display = "none";
                            // }
                        } else if ($('#number_counter').val() >= 0) {
                            console.log('masuk222');

                            $('#number_counter').val(0)
                            $('#price_total').val(0)
                            $("#datatable tbody").empty();


                            number_counter = Number($('#number_counter').val());
                            for (i = 0; i < response.length; i++) {
                                if (response[i].no_sob == nosob) {
                                    // if(number_counter == 0){
                                    //     number_counter++;
                                    // }

                                    old_grandtot = $('#price_total').val();

                                    if (/\D/g.test(old_grandtot)) {
                                        // Filter comma
                                        old_grandtot = old_grandtot.replace(/\,/g,
                                            "");
                                        old_grandtot = Number(Math.trunc(
                                            old_grandtot))
                                    }

                                    subtot = thousands_separators(Number(response[i]
                                        .subtotal).toFixed(2))

                                    console.log(subtot)
                                    if (/\D/g.test(subtot)) {
                                        // Filter comma
                                        subtot = subtot.replace(/\,/g, "");
                                        subtot = Number(Math.trunc(subtot))
                                    }

                                    sum = parseFloat(subtot) + parseFloat(
                                        old_grandtot);

                                    new_grandtot = thousands_separators(Number(sum)
                                        .toFixed(2));

                                    $("#price_total").val(new_grandtot);
                                    number_counter++

                                    counter++;
                                    // number_new = $('#number_counter').val();

                                    tablerow = "<tr row_id=" + number_counter +
                                        "><th style='readonly:true;' class='border border-5'>" +
                                        number_counter +
                                        "</th><td class='border border-5' style='display:none;'><input style='width:120px;' readonly form='thisform' class='numberclass form-control' type='text' value='" +
                                        counter +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" +
                                        response[i].code +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='" +
                                        response[i].name +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" +
                                        response[i].warna +
                                        "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' value='" +
                                        parseInt(response[i].qty) + "' id='qty_d_" +
                                        counter +
                                        "'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='" +
                                        response[i].satuan +
                                        "' name='satuan_d[]'></td><td class='border border-5'><input readonly type='text' style='width:100px;' form='thisform' class='row_hrgjual hrgjualclass form-control' name='hrgjual_d[]' value='" +
                                        thousands_separators(Number(response[i]
                                            .hrgjual).toFixed(2)) +
                                        "' id='hrgjual_d_" + number_counter +
                                        "'></td><td class='border border-5'><input readonly type='text' style='width:100px;' form='thisform' class='subtotclass form-control' name='subtot_d[]' id='subtot_d_" +
                                        number_counter + "' value='" +
                                        thousands_separators(Number(response[i]
                                            .subtotal).toFixed(2)) +
                                        "'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" +
                                        no + "'></td></tr>";
                                    $("#datatable tbody").append(tablerow);
                                    $('#number_counter').val(number_counter);
                                }
                            }
                            number_counter++;
                            $('#number_counter').val(number_counter);

                            var x = document.getElementById("card_items");
                            if (x.style.display === "none") {
                                x.style.display = "block";
                            }
                        }
                        $.ajax({
                            url: '{{ route('getcounter') }}',
                            method: 'post',
                            data: {
                                'nosob': nosob
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                    .attr('content')
                            },
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                show_loading()
                                for (i = 0; i < response.length; i++) {
                                    if (response[i].no == nosob) {
                                        // $("#counter").val(response[i].counter);
                                        // select = document.getElementById("counter");
                                        // select.appendChild(response[i].counter);
                                        $("#counter").select2();
                                        $("#counter").val(response[i]
                                            .counter).trigger(
                                            "change");
                                        // $("#counter").val(response[i].counter).attr('selected','selected');
                                    }
                                }
                                hide_loading()
                            }
                        });
                        // hide_loading()
                    }
                });
            });

            $("#nosob").on('select2:select', function(e) {
                var nosob = $(this).val();
                show_loading()
                console.log(nosob);

                // Fungsi untuk load stock label setiap row di tabel berdasarkan counter_from
                function loadAllStockLabels() {
                    var counter_from_val = $('#counter_from').val();
                    if (!counter_from_val) return;

                    $('#datatable tbody tr').each(function() {
                        var $row = $(this);
                        var kode = $row.find('.kodeclass').val();
                        var $qtycell = $row.find('td').eq(
                        4); // kolom qty (index 4, setelah No, hidden, Kode, Nama, Warna)
                        var rowId = $row.attr('row_id');

                        if (!kode) return;

                        // Hapus label lama kalau ada
                        $qtycell.find('.stock-label-row').remove();

                        $.ajax({
                            url: '{{ route('tbonjualgetitemstock') }}',
                            method: 'post',
                            data: {
                                'kode': kode,
                                'counter': counter_from_val,
                                '_token': CSRF_TOKEN
                            },
                            dataType: 'json',
                            success: function(res) {
                                var stock = parseInt(res.stock) || 0;
                                var labelClass = 'text-muted';
                                var icon = 'fa-check-circle';
                                var text = 'Stok: ' + stock;

                                if (stock < 10) {
                                    labelClass = 'text-danger font-weight-bold';
                                    icon = 'fa-exclamation-circle';
                                    text = 'Stok: ' + stock + ' (Menipis!)';
                                } else if (stock <= 20) {
                                    labelClass = 'text-warning font-weight-bold';
                                    icon = 'fa-exclamation-triangle';
                                    text = 'Stok: ' + stock + ' (Terbatas)';
                                }

                                $qtycell.css({
                                    'padding-bottom': '4px'
                                });
                                $qtycell.find('.row_qty').css({
                                    'margin-bottom': '4px'
                                });
                                $qtycell.append(
                                    '<small class="stock-label-row d-block ' +
                                    labelClass +
                                    '" style="margin-top:4px; line-height:1.4; white-space:nowrap;">' +
                                    '<i class="fas ' + icon + '"></i> ' + text +
                                    '</small>'
                                );
                            }
                        });
                    });
                }
                $.ajax({
                    url: '{{ route('getnosobd') }}',
                    method: 'post',
                    data: {
                        'nosob': nosob
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        if ($('#number_counter').val() == 0) {
                            console.log('masuk');
                            console.log(response);
                            number_counter = Number($('#number_counter').val());
                            for (i = 0; i < response.length; i++) {
                                if (response[i].no_sob == nosob) {
                                    // if(number_counter == 0){
                                    //     number_counter++;
                                    // }

                                    subtotparse = thousands_separators(Number(
                                        response[i].subtotal).toFixed(2));

                                    if ($("#price_total").val() == 0 || $(
                                            "#price_total").val() == '') {
                                        $("#price_total").val(subtotparse);
                                        number_counter++;
                                        counter++;
                                        console.log(number_counter);
                                    } else if ($("#price_total").val() >= 0 || $(
                                            "#price_total").val() != '') {
                                        old_grandtot = $('#price_total').val();
                                        counter++;
                                        if (/\D/g.test(old_grandtot)) {
                                            // Filter comma
                                            old_grandtot = old_grandtot.replace(
                                                /\,/g, "");
                                            old_grandtot = Number(Math.trunc(
                                                old_grandtot))
                                        }

                                        if (/\D/g.test(subtotparse)) {
                                            // Filter comma
                                            subtotparse = subtotparse.replace(/\,/g,
                                                "");
                                            subtotparse = Number(Math.trunc(
                                                subtotparse))
                                        }

                                        sum = subtotparse + old_grandtot;

                                        new_grandtot = thousands_separators(Number(
                                            sum).toFixed(2));
                                        $("#price_total").val(new_grandtot);
                                        console.log(number_counter);
                                        // number_counter++;
                                    }
                                    // number_new = $('#number_counter').val();
                                    tablerow = "<tr row_id=" + number_counter +
                                        "><th style='readonly:true;' class='border border-5'>" +
                                        number_counter +
                                        "</th><td class='border border-5' style='display:none;'><input style='width:120px;' readonly form='thisform' class='numberclass form-control' type='text' value='" +
                                        counter +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" +
                                        response[i].code +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='" +
                                        response[i].name +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" +
                                        response[i].warna +
                                        "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' value='" +
                                        parseInt(response[i].qty) + "' id='qty_d_" +
                                        counter +
                                        "'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='" +
                                        response[i].satuan +
                                        "' name='satuan_d[]'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' readonly class='row_hrgjual hrgjualclass form-control' name='hrgjual_d[]' value='" +
                                        thousands_separators(Number(response[i]
                                            .hrgjual).toFixed(2)) +
                                        "' id='hrgjual_d_" + number_counter +
                                        "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' readonly class='subtotclass form-control' name='subtot_d[]' id='subtot_d_" +
                                        number_counter + "' value='" +
                                        thousands_separators(Number(response[i]
                                            .subtotal).toFixed(2)) +
                                        "'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" +
                                        no + "'></td></tr>";
                                    $("#datatable tbody").append(tablerow);
                                    number_counter++;
                                    number_new = number_counter;
                                    $('#number_counter').val(number_new);

                                }
                            }
                            loadAllStockLabels();
                            // var x = document.getElementById("card_items");
                            // if (x.style.display === "none") {
                            //     x.style.display = "block";
                            // } else {
                            //     x.style.display = "none";
                            // }
                        } else if ($('#number_counter').val() >= 0) {
                            console.log('masuk222');

                            $('#number_counter').val(0)
                            $('#price_total').val(0)
                            $("#datatable tbody").empty();


                            number_counter = Number($('#number_counter').val());
                            for (i = 0; i < response.length; i++) {
                                if (response[i].no_sob == nosob) {
                                    // if(number_counter == 0){
                                    //     number_counter++;
                                    // }

                                    old_grandtot = $('#price_total').val();

                                    if (/\D/g.test(old_grandtot)) {
                                        // Filter comma
                                        old_grandtot = old_grandtot.replace(/\,/g,
                                            "");
                                        old_grandtot = Number(Math.trunc(
                                            old_grandtot))
                                    }

                                    subtot = thousands_separators(Number(response[i]
                                        .subtotal).toFixed(2))

                                    console.log(subtot)
                                    if (/\D/g.test(subtot)) {
                                        // Filter comma
                                        subtot = subtot.replace(/\,/g, "");
                                        subtot = Number(Math.trunc(subtot))
                                    }

                                    sum = parseFloat(subtot) + parseFloat(
                                        old_grandtot);

                                    new_grandtot = thousands_separators(Number(sum)
                                        .toFixed(2));

                                    $("#price_total").val(new_grandtot);
                                    number_counter++

                                    counter++;
                                    // number_new = $('#number_counter').val();

                                    tablerow = "<tr row_id=" + number_counter +
                                        "><th style='readonly:true;' class='border border-5'>" +
                                        number_counter +
                                        "</th><td class='border border-5' style='display:none;'><input style='width:120px;' readonly form='thisform' class='numberclass form-control' type='text' value='" +
                                        counter +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" +
                                        response[i].code +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='" +
                                        response[i].name +
                                        "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" +
                                        response[i].warna +
                                        "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' value='" +
                                        parseInt(response[i].qty) + "' id='qty_d_" +
                                        counter +
                                        "'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='" +
                                        response[i].satuan +
                                        "' name='satuan_d[]'></td><td class='border border-5'><input readonly type='text' style='width:100px;' form='thisform' class='row_hrgjual hrgjualclass form-control' name='hrgjual_d[]' value='" +
                                        thousands_separators(Number(response[i]
                                            .hrgjual).toFixed(2)) +
                                        "' id='hrgjual_d_" + number_counter +
                                        "'></td><td class='border border-5'><input readonly type='text' style='width:100px;' form='thisform' class='subtotclass form-control' name='subtot_d[]' id='subtot_d_" +
                                        number_counter + "' value='" +
                                        thousands_separators(Number(response[i]
                                            .subtotal).toFixed(2)) +
                                        "'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" +
                                        no + "'></td></tr>";
                                    $("#datatable tbody").append(tablerow);
                                    $('#number_counter').val(number_counter);
                                }
                            }
                            number_counter++;
                            $('#number_counter').val(number_counter);

                            loadAllStockLabels();
                            var x = document.getElementById("card_items");
                            if (x.style.display === "none") {
                                x.style.display = "block";
                            }
                        }
                        $.ajax({
                            url: '{{ route('getcounter') }}',
                            method: 'post',
                            data: {
                                'nosob': nosob
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                    .attr('content')
                            },
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                show_loading()
                                for (i = 0; i < response.length; i++) {
                                    if (response[i].no == nosob) {
                                        // $("#counter").val(response[i].counter);
                                        // select = document.getElementById("counter");
                                        // select.appendChild(response[i].counter);
                                        $("#counter").select2();
                                        $("#counter").val(response[i]
                                            .counter).trigger(
                                            "change");
                                        // $("#counter").val(response[i].counter).attr('selected','selected');
                                    }
                                }
                                hide_loading()
                            }
                        });
                        // hide_loading()
                    }
                });
            });

            // var counter = Number($('#number_counter').val());
            $(document).on("click", "#addItem", function(e) {
                e.preventDefault();
                if ($('#quantity').val() == 0) {
                    alert('Quantity tidak boleh 0');
                    return false;
                }

                kode = $("#select2-kode-container").text();
                kode_id = $("#kode").val();
                nama_item = $("#nama_item").val();
                warna = $("#warna").val();
                hrgjual = $("#hrgjual").val();
                quantity = $("#quantity").val();
                satuan = $("#satuan").val();
                subtot = $("#subtot").val();
                rowCount = $('#number_counter').val();
                counter = rowCount;

                //ADD DUPLICATE ITEM 
                var table = document.getElementById('datatable');
                for (var i = 1; i < table.rows.length; i++) {
                    exist_code_row = table.rows[i].cells[2].getElementsByTagName('input')[0]
                        .value;
                    console.log("isi input :" + exist_code_row);
                    if (exist_code_row == kode_id) {
                        price_total_old = $('#price_total').val();
                        if (/\D/g.test(price_total_old)) {
                            // Filter comma
                            price_total_old = price_total_old.replace(/\,/g, "");
                            price_total_old = Number(Math.trunc(price_total_old))
                        }

                        var this_row_qty_val = table.rows[i].cells[5].getElementsByTagName(
                            'input')[0].value;
                        old_qty = this_row_qty_val
                        new_total_qty = Number(quantity) + Number(this_row_qty_val)
                        table.rows[i].cells[5].getElementsByTagName('input')[0].value =
                            new_total_qty;
                        this_hrg_row = table.rows[i].cells[7].getElementsByTagName('input')[0]
                            .value;
                        if (/\D/g.test(this_hrg_row)) {
                            // Filter comma
                            this_hrg_row = this_hrg_row.replace(/\,/g, "");
                            this_hrg_row = Number(Math.trunc(this_hrg_row))
                        }
                        old_subtot = Number(this_hrg_row) * Number(old_qty)
                        normalize_price_total = Number(price_total_old) - Number(old_subtot)
                        $('#price_total').val(normalize_price_total);
                        new_pricetot = $('#price_total').val();
                        new_subtot = Number(new_total_qty) * Number(this_hrg_row);
                        final_pricetot = Number(new_pricetot) + Number(new_subtot);
                        console.log("final_pricetot : " + final_pricetot)
                        $('#price_total').val(thousands_separators(final_pricetot.toFixed(2)));
                        // table.rows[i].cells[7].getElementsByTagName('input')[0].value = thousands_separators(new_subtot.toFixed(2));
                        table.rows[i].cells[8].getElementsByTagName('input')[0].value =
                            thousands_separators(new_subtot.toFixed(2));
                        // alert('ada kode sama');
                        $("#kode").prop('selectedIndex', 0).trigger('change');
                        $("#nama_item").val('');
                        $("#warna").val('');
                        $("#hrgjual").val(0);
                        $("#satuan").val('');
                        $("#quantity").val(0);
                        $("#merk").val('');
                        $("#subtot").val('');
                        $("#note").val('');
                        return false
                    }
                }

                subtotparse = subtot.replaceAll(",", "");

                if (counter > 1) {
                    if (/\D/g.test(hrgjual)) {
                        // Filter comma
                        hrgjual = hrgjual.replace(/\,/g, "");
                        hrgjual = Number(Math.trunc(hrgjual))
                    }
                    sum = hrgjual * quantity;

                    $("#subtot").val(thousands_separators(sum.toFixed(2)));

                    total_old = $('#price_total').val();
                    console.log("total old : " + total_old);
                    if (/\D/g.test(total_old)) {
                        // Filter comma
                        total_old = total_old.replace(/\,/g, "");
                        total_old = Number(Math.trunc(total_old))
                    }

                    total = sum + total_old

                    // rowCount++;
                    // console.log(rowCount);
                    // $('#number_counter').val(rowCount);
                    $("#price_total").val(thousands_separators(Number(total).toFixed(2)));

                } else {
                    if (/\D/g.test(hrgjual)) {
                        // Filter comma
                        hrgjual = hrgjual.replace(/\,/g, "");
                        hrgjual = Number(Math.trunc(hrgjual))
                    }
                    sum = hrgjual * quantity;

                    $("#subtot").val(thousands_separators(sum.toFixed(2)));

                    total_old = $('#price_total').val();
                    console.log("total old : " + total_old);
                    if (/\D/g.test(total_old)) {
                        // Filter comma
                        total_old = total_old.replace(/\,/g, "");
                        total_old = Number(Math.trunc(total_old))
                    }
                    total = sum + total_old
                    rowCount++;

                    $("#price_total").val(thousands_separators(Number(total).toFixed(2)));
                }

                tablerow = "<tr row_id=" + rowCount +
                    "><th style='readonly:true;' class='border border-5'>" + rowCount +
                    "</th><td class='border border-5' style='display:none;'><input style='width:120px;' readonly form='thisform' class='numberclass form-control' type='text' value='" +
                    rowCount +
                    "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" +
                    kode_id +
                    "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='" +
                    nama_item +
                    "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" +
                    warna +
                    "'></td><td class='border border-5'><input style='width:120px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' type='text' value='" +
                    quantity + "' id='qty_d_" + counter +
                    "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='satuanclass form-control' name='satuan_d[]' type='text' value='" +
                    satuan +
                    "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='row_hrgjual hrgjualclass form-control' name='hrgjual_d[]' type='text' value='" +
                    hrgjual + "' id='hrgjual_d_" + rowCount +
                    "'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='subtotclass form-control' value='" +
                    subtot + "' name='subtot_d[]' id='subtot_d_" + rowCount +
                    "'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" +
                    no + "'></td></tr>";

                $("#datatable tbody").append(tablerow);

                rowCount++;
                console.log(rowCount);
                $('#number_counter').val(rowCount);

                $("#kode").prop('selectedIndex', 0).trigger('change');
                $("#nama_item").val('');
                $("#warna").val('');
                $("#hrgjual").val(0);
                $("#satuan").val('');
                $("#quantity").val(0);
                $("#merk").val('');
                $("#subtot").val('');
                $("#note").val('');
            });

            $(document).on("click", ".delete", function(e) {
                e.preventDefault();
                var r = confirm("Delete Transaksi ?");
                if (r == true) {
                    // counter_id = $(this).closest('tr').text();
                    // counter_id = $('td').find('.numberclass').val();
                    counter_id = $(this).closest('tr').find('.numberclass').val();
                    // console.log(counter_id);
                    subtot = $("#subtot_d_" + counter_id).val().replaceAll(",", "");

                    if (/\D/g.test(subtot)) {
                        // Filter comma
                        subtot = subtot.replace(/\,/g, "");
                        subtot = Number(Math.trunc(subtot))
                    }

                    old_grandtot = $("#price_total").val();

                    if (/\D/g.test(old_grandtot)) {
                        // Filter comma
                        old_grandtot = old_grandtot.replace(/\,/g, "");
                        old_grandtot = Number(Math.trunc(old_grandtot))
                    }


                    sum = Number(old_grandtot) - Number(subtot);
                    console.log(sum);

                    // rowCount = $('#number_counter').val();

                    // rowCount--;
                    // $('#number_counter').val(rowCount);
                    $("#price_total").val(thousands_separators(sum.toFixed(2)));
                    $(this).closest('tr').remove();

                    var table = document.getElementById('datatable');
                    for (var i = 1; i < table.rows.length; i++) {
                        var firstCol = table.rows[i].cells[0];
                        firstCol.innerText = i;
                    }
                    counter--;
                } else {
                    return false;
                }
            });

            $(document).on("change", "#disc", function(e) {
                if ($('#disc').val() == '') {
                    $('#disc').val(0);
                }
            });

            $(document).on("change", "#tax", function(e) {
                if ($('#tax').val() == '') {
                    $('#tax').val(0);
                }
            });

            $(document).on("change", "#quantity", function(e) {
                if ($('#quantity').val() == '') {
                    $('#quantity').val(0);
                }
                hrg = $('#hrgjual').val();
                if (/\D/g.test(hrg)) {
                    // Filter comma
                    hrg = hrg.replace(/\,/g, "");
                    hrg = Number(Math.trunc(hrg))
                }
                console.log(hrg);
                var qty = this.value
                var total = parseInt(hrg) * parseInt(qty);
                $("#subtot").val(thousands_separators(total.toFixed(2)));
            });

            $(document).on("change", "#hrgjual", function(e) {
                if ($('#hrgjual').val() == '') {
                    $('#hrgjual').val(0);
                }
                $(this).val(thousands_separators($(this).val()));
                hrgparse = $('#hrgjual').val();
                if (/\D/g.test(hrgparse)) {
                    // Filter comma
                    hrgparse = hrgparse.replace(/\,/g, "");
                    hrgparse = Number(Math.trunc(hrgparse))
                }
                var hrg = Number(hrgparse).toFixed(2);
                var qty = Number($("#quantity").val()).toFixed(2);
                var total = Number(hrg) * Number(qty);
                console.log(total);

                $("#subtot").val(thousands_separators(total.toFixed(2)));
            });

            $(document).on("click", "#hrgjual", function(e) {
                if (/\D/g.test(this.value)) {
                    // Filter comma
                    this.value = this.value.replace(/\,/g, "");
                    this.value = Number(Math.trunc(this.value))
                }
            });
        });
        // VALIDATE TRIGGER
        $("#quantity").keyup(function(e) {
            if (/\D/g.test(this.value)) {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $("#hrgsatuan").keyup(function(e) {
            if (/\D/g.test(this.value)) {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $("#kurs").keyup(function(e) {
            if (/\D/g.test(this.value)) {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $("#disc").keyup(function(e) {
            if (/\D/g.test(this.value)) {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
            if (this.value >= 99) {
                this.value = 99;
            }
        });
        $("#tax").keyup(function(e) {
            if (/\D/g.test(this.value)) {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
            if (this.value >= 99) {
                this.value = 99;
            }
        });

        $(document).on("click", "#confirm", function(e) {
            // Validate ifnull
            no = $("#no").val();
            counter = $("#counter").val();
            code_cust = $("#code_cust").prop('selectedIndex');
            // nosob = $("#nosob").prop('selectedIndex');
            jenis = $("#jenis").prop('selectedIndex');
            if (no == "") {
                swal('WARNING', 'No Tidak boleh kosong!', 'warning');
                return false;
            } else if (code_cust == 0) {
                swal('WARNING', 'Please select Code Cust', 'warning');
                return false;
            }
            show_loading()
            // $('#confirm').prop('disabled', true).text('Processing...');

            // else if (nosob == 0){
            //     swal('WARNING', 'Please select Nomer SOB', 'warning');
            //     return false;
            // }
            // else if (jenis == 0){
            //     swal('WARNING', 'Please select Jenis', 'warning');
            //     return false;
            // }
        });

        $(document).on('focusout', '.row_qty', function(event) {
            event.preventDefault();

            console.log("focus out");
            var tbl_row = $(this).closest('tr');
            var row_id = tbl_row.attr('row_id');

            subtot = $('#subtot_d_' + row_id).val();
            console.log("subtot : " + subtot);
            if (/\D/g.test(subtot)) {
                // Filter comma
                subtot = subtot.replace(/\,/g, "");
                subtot = Number(Math.trunc(subtot))
            }

            total = $('#price_total').val();
            console.log("total : " + total);
            if (/\D/g.test(total)) {
                // Filter comma
                total = total.replace(/\,/g, "");
                total = Number(Math.trunc(total))
            }

            total_old = total - subtot;

            qty = $(this).val();

            hrg = $('#hrgjual_d_' + row_id).val();
            if (/\D/g.test(hrg)) {
                // Filter comma
                hrg = hrg.replace(/\,/g, "");
                hrg = Number(Math.trunc(hrg))
            }

            sum = hrg * qty;
            $('#subtot_d_' + row_id).val(thousands_separators(sum.toFixed(2)));

            total_new = total_old + sum;

            $('#price_total').val(thousands_separators(total_new.toFixed(2)));
        });

        // })
    </script>
@endsection
