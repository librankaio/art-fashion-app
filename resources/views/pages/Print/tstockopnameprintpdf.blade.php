<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        @page {
            margin-top: 10px;
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Roboto', sans-serif;
            margin-top: 0;
            margin-bottom: 0;
        }

        td {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            font-size: 13px;
        }

        hr {
            border-top: 1px solid;
        }

        .split-para span {
            display: block;
            float: right;
            padding-right: 7px;
            padding-top: 0px;
        }
    </style>
</head>

</html>

<body style="font-family: 'Roboto', sans-serif;">
    <div style="margin-left: 0%; margin-right: 0%;">
        <h5 class="split-para" style="margin: 0px auto; text-align:left; padding-bottom: 1px;" id="text_code">
            <span>
                <h5 style="margin: 0px auto; float:right; font-size:13px;">Art Fashion Jewelry <br>Telp.(021) 6403172 /
                    6401336<br>Fax. 021.6401336</h5>
            </span>
        </h5>
        <img src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(base_path('public/assets/img/artfashion_logo2.png'))); ?>" width="180">

        <center>
            <h1
                style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 6px; font-size:20px;">
                STOCK OPNAME</h1>
        </center>

        <table style="margin-top:10px; font-size:13px; font-weight:bold;">
            <tr>
                <td style="width:130px;">No Stock Opname</td>
                <td>: {{ $header->no }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ date('Y-m-d', strtotime($header->tanggal)) }}</td>
            </tr>
            <tr>
                <td>Counter</td>
                <td>: {{ $header->counter }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: {{ $header->status }}</td>
            </tr>
            @if ($header->note)
                <tr>
                    <td>Catatan</td>
                    <td>: {{ $header->note }}</td>
                </tr>
            @endif
        </table>

        <center>
            <table id="mytable" border="0.5px" style="border:solid; margin-top:10px; width:100%;">
                <thead>
                    <tr>
                        <td align="center" style="width: 30px;">No</td>
                        <td align="center" style="width: 90px;">Kode Barang</td>
                        <td align="center" style="width: 150px;">Nama Barang</td>
                        <td align="center" style="width: 70px;">Stock Sistem</td>
                        <td align="center" style="width: 90px;">Harga</td>
                        <td align="center" style="width: 70px;">Hasil Opname</td>
                        <td align="center" style="width: 70px;">Adjustment</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $d)
                        <tr>
                            <td align="center">{{ $loop->iteration }}</td>
                            <td align="center">{{ $d->kode_barang }}</td>
                            <td style="padding: 2px 4px;">{{ $d->nama_barang }}</td>
                            <td align="center">{{ number_format($d->stock, 0, '.', '') }}</td>
                            <td align="right" style="padding-right:4px;">{{ number_format($d->harga, 0, '.', ',') }}
                            </td>
                            <td align="center">{{ number_format($d->hasil_opname, 0, '.', '') }}</td>
                            <td align="center">{{ number_format($d->adjustment, 0, '.', '') }}</td>
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
            <table style="margin-top:40px;">
                <thead>
                    <tr>
                        <td align="center" style="width: 160px;">Pemeriksa</td>
                        <td align="center" style="width: 160px;">Mengetahui</td>
                        <td align="center" style="width: 160px;">Hormat Kami</td>
                    </tr>
                </thead>
                <br><br><br>
                <tbody>
                    <tr>
                        <td align="center" style="width: 140px;">
                            <hr>
                        </td>
                        <td align="center" style="width: 140px;">
                            <hr>
                        </td>
                        <td align="center" style="width: 140px;">
                            <hr>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
    </div>
</body>
