@extends('layouts.main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Lap Overview PerItem</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Report</a></div>
                <div class="breadcrumb-item"><a class="text-muted">Lap Overview PerItem</a></div>
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
                                                value="{{ request('dtfr') ?? date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>s/d</label>
                                            <input type="date" class="form-control" name="dtto"
                                                value="{{ request('dtto') ?? date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Kategori <small class="text-muted">(ketik untuk filter)</small></label>
                                            <input type="text" class="form-control" name="kategori"
                                                placeholder="Cari kategori..." value="{{ request('kategori') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button class="btn btn-primary mr-1" id="confirm" type="submit"
                                                formaction="/roverviewperitemsearch" onclick="show_loading()">View</button>
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
                                                    Kategori</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Qty
                                                </th>
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
                                                            {{ $item->trans ?? '-' }}
                                                        </td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->no ?? '-' }}
                                                        </td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->counter ?? '-' }}
                                                        </td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ isset($item->tgl) ? date('Y-m-d', strtotime($item->tgl)) : '-' }}
                                                        </td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->code ?? '-' }}
                                                        </td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->name ?? '-' }}
                                                        </td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->kategori ?? '-' }}
                                                        </td>
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
                            <div class="card-footer text-right"></div>
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
            $('#datatable').DataTable({
                "bInfo": false,
            });
        });
    </script>
@endsection
