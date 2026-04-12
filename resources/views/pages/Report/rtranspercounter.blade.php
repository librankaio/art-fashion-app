@extends('layouts.main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan Overview Trans</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Report</a></div>
                <div class="breadcrumb-item"><a class="text-muted">Laporan Overview Trans</a></div>
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
                                                formaction="/rtranspercountersearch" onclick="show_loading()">View</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row pb-3">
                                    <div class="col-6"></div>
                                    {{-- <div class="col-6 d-flex justify-content-end">
                                        <button type="submit" formaction="rtranspercounterexcl" formtarget="_blank"
                                            class="btn btn-success"><i class="far fa-file-excel"></i><span> Export
                                                Excel</span></button>
                                    </div> --}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="border border-5" style="text-align: center;">No
                                                </th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Jenis
                                                    Transaksi</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Nomor
                                                    Transaksi</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">
                                                    Counter</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">
                                                    Tanggal</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Kode
                                                    Barang</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Nama
                                                    Barang</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">
                                                    Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($results)
                                                @php $counter = 0 @endphp
                                                @foreach ($results as $data => $item)
                                                    @php $counter++ @endphp
                                                    <tr>
                                                        <th scope="row" class="border border-5">{{ $counter }}</th>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ isset($item->trans) ? $item->trans : '-' }}
                                                        </td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ isset($item->no) ? $item->no : '-' }}</td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ isset($item->counter) ? $item->counter : '-' }}</td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ isset($item->tgl) ? date('Y-m-d', strtotime($item->tgl)) : '-' }}
                                                        </td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ isset($item->code) ? $item->code : '-' }}</td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ isset($item->name) ? $item->name : '-' }}</td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ isset($item->qty) ? number_format($item->qty) : '0' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
            });

            $('#datatable').DataTable({
                "bInfo": false,
            });
        })
    </script>
@endsection
