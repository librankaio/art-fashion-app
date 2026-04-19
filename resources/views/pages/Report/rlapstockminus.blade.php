@extends('layouts.main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan Stock Minus</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Report</a></div>
                <div class="breadcrumb-item"><a class="text-muted">Laporan Stock Minus</a></div>
            </div>
        </div>
        @php
            $tpos_save = session('tpos_save');
        @endphp
        <div class="section-body">
            <form action="" method="GET" id="thisform">
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
                                            <label>Counter</label>
                                            <select class="form-control select2" name="counter" id="counter">
                                                <option disabled @if (request('counter') == null) selected @endif>--Select
                                                    Counter--</option>
                                                @foreach ($counters as $data => $counter)
                                                    <option value="{{ $counter->name }}"
                                                        @if (request('counter') == $counter->name) selected @endif>
                                                        {{ $counter->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button class="btn btn-primary mr-1" id="confirm" type="submit"
                                                formaction="/rlapstockminussearch" onclick="show_loading()">View</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Laporan Stock Minus</h4>
                                <div class="card-header-action">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search"
                                            value="@php if(request()->input('search')==NULL){ echo "";} else{ echo $_GET['search']; } @endphp">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row pb-3">
                                    <div class="col-6"></div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <button type="submit" formaction="rlapstockminusexcl" formtarget="_blank"
                                            class="btn btn-success"><i class="far fa-file-excel"></i><span> Export
                                                Excel</span></button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="border border-5" style="text-align: center;">No
                                                </th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Kode
                                                    Artikel</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Nama
                                                    Artikel</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">
                                                    Counter
                                                </th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Qty
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($results)
                                                @php $counter = ($results->currentPage() - 1) * $results->perPage() @endphp
                                                @foreach ($results as $data => $item)
                                                    @php $counter++ @endphp
                                                    <tr>
                                                        <th scope="row" class="border border-5">{{ $counter }}</th>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->code_mitem }}</td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->name_mitem }}</td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->name_mcounters }}</td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ number_format($item->stock) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endisset
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
                                            <label>Total Qty</label>
                                            @if (isset($results))
                                                <input type="text" class="form-control" form="thisform"
                                                    value="{{ number_format($total_qty) }}" readonly>
                                            @else
                                                <input type="text" class="form-control" form="thisform" readonly>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7"></div>
                                    <div class="col-md-3" style="padding-left: 60px;">
                                        @isset($results)
                                            {{-- <div class="card-footer text-right"> --}}
                                            {{ $results->links() }}
                                            {{-- </div> --}}
                                        @endisset
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-12 col-md-6 col-lg-6 align-self-end">
                                <div class="row" style="padding-left: 100px;">
                                    @isset($results)
                                        <div class="card-footer text-right">
                                            {{ $results->links() }}
                                        </div>
                                    @endisset
                                </div>
                            </div> --}}
                            <div class="card-footer text-right">
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
            //CSRF TOKEN
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function() {
                $('.select2').select2({});

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

                $("#kode").on('select2:select', function(e) {
                    var kode = $(this).val();
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

                        }
                    });
                });
            });
            $(document).on("click", "#confirm", function(e) {
                // Validate ifnull
                no = $("#no").val();
                code_cust = $("#code_cust").prop('selectedIndex');
                if (no == "") {
                    swal('WARNING', 'No Tidak boleh kosong!', 'warning');
                    return false;
                } else if (code_cust == 0) {
                    swal('WARNING', 'Please select Code Cust', 'warning');
                    return false;
                }
            });

            // $('#datatable').DataTable({
            //     // "ordering":false,
            //     "bInfo": false,
            //     // "bPaginate": false,
            //     // "searching": false
            // });
        })
    </script>
@endsection
