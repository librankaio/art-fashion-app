<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Print - Stock Opname</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="idr" onload="window.print()" style="font-family: Open Sans; padding-right:50px; padding-left:50px;">

    <section class="upright">
        <div style="margin-left: 0%; margin-right: 0%;">
            <div class="container pt-5">
                <div class="row">
                    <div class="col-1">
                        <img src="{{ asset('../assets/img/artfashion_logo2.png') }}" alt="logo" width="200">
                    </div>
                    <div class="col-5" style="padding-left: 150px; padding-top: 30px">
                        <h5>Art Fashion Jewelry <br>Telp.(021) 6403172 / 6401336<br>Fax. 021.6401336</h5>
                    </div>
                </div>
                <center>
                    <h1 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 6px;">
                        STOCK OPNAME</h1>
                </center>
                <div class="row pt-2">
                    <div class="col-6">
                        <h5>No Stock Opname : {{ $header->no }}</h5>
                        <h5>Tanggal : {{ date('Y-m-d', strtotime($header->tanggal)) }}</h5>
                        <h5>Counter : {{ $header->counter }}</h5>
                        <h5>Status : {{ $header->status }}</h5>
                        @if ($header->note)
                            <h5>Catatan : {{ $header->note }}</h5>
                        @endif
                    </div>
                </div>
            </div>
            <center>
                <table id="mytable" border="1px">
                    <thead>
                        <tr>
                            <td align="center" style="width: 60px; word-wrap: break-word;">No</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">Kode Barang</td>
                            <td align="center" style="width: 200px; word-wrap: break-word;">Nama Barang</td>
                            <td align="center" style="width: 100px; word-wrap: break-word;">Stock Sistem</td>
                            <td align="center" style="width: 100px; word-wrap: break-word;">Harga</td>
                            <td align="center" style="width: 100px; word-wrap: break-word;">Hasil Opname</td>
                            <td align="center" style="width: 100px; word-wrap: break-word;">Adjustment</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $d)
                            <tr>
                                <td align="center" style="width: 60px; word-wrap: break-word;">{{ $loop->iteration }}
                                </td>
                                <td align="center" style="width: 150px; word-wrap: break-word;">{{ $d->kode_barang }}
                                </td>
                                <td style="width: 200px; word-wrap: break-word; padding: 2px 6px;">{{ $d->nama_barang }}
                                </td>
                                <td align="center" style="width: 100px; word-wrap: break-word;">
                                    {{ number_format($d->stock, 0, '.', '') }}</td>
                                <td align="right" style="width: 100px; word-wrap: break-word; padding-right:4px;">
                                    {{ number_format($d->harga, 0, '.', ',') }}</td>
                                <td align="center" style="width: 100px; word-wrap: break-word;">
                                    {{ number_format($d->hasil_opname, 0, '.', '') }}</td>
                                <td align="center" style="width: 100px; word-wrap: break-word;">
                                    {{ number_format($d->adjustment, 0, '.', '') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" align="center"><strong>Total Item</strong></td>
                            <td align="center"><strong>{{ $details->sum('stock') }}</strong></td>
                            <td></td>
                            <td align="center"><strong>{{ $details->sum('hasil_opname') }}</strong></td>
                            <td align="center"><strong>{{ $details->sum('adjustment') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </center>
            <center>
                <div class="container pt-5">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-3">
                            <h5>Pemeriksa</h5>
                            <br><br><br>
                            <hr style="border-top: dotted 0.3px;" />
                        </div>
                        <div class="col-3">
                            <h5>Mengetahui</h5>
                            <br><br><br>
                            <hr style="border-top: dotted 0.3px;" />
                        </div>
                        <div class="col-3">
                            <h5>Hormat Kami</h5>
                            <br><br><br>
                            <hr style="border-top: dotted 0.3px;" />
                        </div>
                    </div>
                </div>
            </center>
        </div>
    </section>

</body>

</html>

<style type="text/css" media="print">
    @page {
        size: 241.3mm 279.4mm;
        margin: -1px auto;
        margin-right: 5px auto;
    }

    body {
        font-family: 'Open Sans', sans-serif;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Open Sans', sans-serif;
    }

    td {
        font-family: 'Open Sans';
        font-weight: bold;
    }

    @page upright {
        size: portrait;
        page-orientation: upright;
    }

    @media print {
        .upright {
            page: upright;
        }
    }
</style>
