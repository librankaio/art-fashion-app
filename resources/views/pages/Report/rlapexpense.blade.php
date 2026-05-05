@extends('layouts.main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan Expense</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Report</a></div>
                <div class="breadcrumb-item"><a class="text-muted">Laporan Expense</a></div>
            </div>
        </div>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Dari</label>
                                            <input type="date" class="form-control" name="dtfr"
                                                value="@php if(request('dtfr')==NULL){ echo date('Y-m-d');} else{ echo $_GET['dtfr']; } @endphp">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>s/d</label>
                                            <input type="date" class="form-control" name="dtto"
                                                value="@php if(request('dtto')==NULL){ echo date('Y-m-d');} else{ echo $_GET['dtto']; } @endphp">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Counter</label>
                                            <select class="form-control select2" name="counter" id="counter">
                                                @if (request('counter') == null)
                                                    <option selected>SEMUA</option>
                                                @else
                                                    <option selected>@php echo $_GET['counter']; @endphp</option>
                                                @endif
                                                <option>SEMUA</option>
                                                @foreach ($counters as $data => $counter)
                                                    <option>{{ $counter->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button class="btn btn-primary mr-1" id="confirm" type="submit"
                                                formaction="/rlapexpensesearch" onclick="show_loading()">View</button>
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
                                                <th scope="col" class="border border-5" style="text-align: center;">No
                                                </th>
                                                <th scope="col" class="border border-5" style="text-align: center;">
                                                    Counter</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">
                                                    Tanggal</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">
                                                    Deskripsi</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">
                                                    Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($results)
                                                @php $no = 0 @endphp
                                                @foreach ($results as $item)
                                                    @php $no++ @endphp
                                                    <tr>
                                                        <th scope="row" class="border border-5" style="text-align: center;">
                                                            {{ $no }}</th>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ isset($item->counter) ? $item->counter : '-' }}
                                                        </td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ isset($item->expense_date) ? date('Y-m-d', strtotime($item->expense_date)) : '-' }}
                                                        </td>
                                                        <td class="border border-5">
                                                            {{ isset($item->note) ? $item->note : '-' }}
                                                        </td>
                                                        <td class="border border-5" style="text-align: right;">
                                                            {{ isset($item->total) ? number_format($item->total, 0, ',', '.') : '0' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @isset($grandTotal)
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <div
                                                style="
                                                display: flex;
                                                align-items: center;
                                                gap: 0;
                                                border-radius: 12px;
                                                overflow: hidden;
                                                /* box-shadow: 0 2px 8px rgba(0,0,0,0.10); */
                                            ">
                                                <div
                                                    style="
                                                    padding: 10px 24px;
                                                    background-color: #f8f9fa;
                                                    font-weight: 600;
                                                    font-size: 0.95rem;
                                                    color: #495057;
                                                    border: 1px solid #dee2e6;
                                                    border-right: none;
                                                    border-radius: 12px 0 0 12px;
                                                ">
                                                    Grand Total</div>
                                                <div
                                                    style="
                                                    padding: 10px 28px;
                                                    background-color: #fff3cd;
                                                    font-weight: 700;
                                                    font-size: 0.95rem;
                                                    color: #856404;
                                                    border: 1px solid #dee2e6;
                                                    border-left: none;
                                                    border-radius: 0 12px 12px 0;
                                                ">
                                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endisset
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

            $('.select2').select2({});

            var table = $('#datatable').DataTable({
                "bInfo": false,
                "drawCallback": function(settings) {
                    updateGrandTotalVisible(this.api());
                }
            });

            function updateGrandTotalVisible(api) {
                var total = 0;
                api.rows({
                    search: 'applied'
                }).every(function() {
                    var data = this.data();
                    var nominalRaw = $(data[4]).text().trim().replace(/\./g, '').replace(',', '.');
                    var val = parseFloat(nominalRaw);
                    if (!isNaN(val)) {
                        total += val;
                    }
                });

                var formatted = total.toLocaleString('id-ID', {
                    minimumFractionDigits: 0
                });
                $('#grand-total-display').text('Rp ' + formatted);
            }
        });
    </script>
@endsection
