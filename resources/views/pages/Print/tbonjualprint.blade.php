<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>Jurnal Voucher</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="idr" onload="window.print()">

    <section class="upright">
        <div style="margin-left: 0%; margin-right: 0%;">
            <div class="container pt-5">
                <div class="row">
                    <div class="col-6">
                        <h5>Art Fashion Jewelry <br>Telp. (62 - 21) 645 0910/11<br>Fax. (62 - 21) 684288</h5>
                    </div>
                    <div class="col-6 text-right">
                        <h5>Jakarta<br>{{ date("Y-m-d", strtotime($tpenjualanh->tgl)) }}<br>Pameran Paramita Depok<br>Jawa Barat</h5>
                    </div>
                </div>
            </div>
            <center>
                <h5>Surat Jalan</h5>
            </center>
            <div class="row">
                <div class="col-6">
                    <h5>No Faktur : {{ $tpenjualanh->no }} </h5>
                </div>
                <div class="col-6 text-right">
                </div>
            </div>
            <center>              
                <table id="mytable" border="1px">
                    <thead>
                        <tr>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">No</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">Kode</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">Nama Item</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">Quantity</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">Satuan</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">Harga</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">Subtotal</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">Keterangan</td>
                        </tr>  
                    </thead>
                    <tbody>
                        @php $counter = 0; @endphp
                        @for($i = 0; $i < sizeof($tpenjualands); $i++) @php $counter++; @endphp <tr>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">{{ $counter }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">{{ $tpenjualands[$i]->code }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">{{ $tpenjualands[$i]->name }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">{{ number_format($tpenjualands[$i]->qty, 0, '.', '') }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">{{ $tpenjualands[$i]->satuan }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">{{ number_format($tpenjualands[$i]->hrgjual, 2, '.', ',') }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">{{ number_format($tpenjualands[$i]->subtotal, 2, '.', ',') }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;" class="border-dotted">{{ $tpenjualands[$i]->keterangan }}</td>
                            </tr>
                        @endfor
                    </tbody>  
                    <td align="center" colspan="3">Total Debit :</td>
                    <td align="center" colspan="3">Total Credit :</td>
                    <td align="center" colspan="3">Grand Balance : {{ number_format($tpenjualanh->grdtotal, 2, '.', ',') }}</td>
                </table>
            </center>
            <center>
                <div class="container pt-5">
                    <div class="row">
                        <div class="col-3">
                            <h5>Penerima</h5>
                            <br>
                            <br>
                            <br>
                            <hr style="border-top: dotted 0.3px;" />
                        </div>
                        <div class="col-3">
                            <h5>Pengirim</h5>
                            <br>
                            <br>
                            <br>
                            <hr style="border-top: dotted 0.3px;" />
                        </div>
                        <div class="col-3">
                            <h5>Pengirim</h5>
                            <br>
                            <br>
                            <br>
                            <hr style="border-top: dotted 0.3px;" />
                        </div>
                        <div class="col-3">
                            <h5>Hormat Kami</h5>
                            <br>
                            <br>
                            <br>
                            <hr style="border-top: dotted 0.3px;" />
                        </div>
                    </div>
                </div>
            </center>
            <br><br>
            <p>
                <footer><a href="http://www.swifect.com">~ Swifect Custom Application ~</a></footer>
            </div>
    </section>

</body>
</html>

<style type="text/css" media="print">
    body {
        /* font-family: 'Roboto';font-size: 16px; */
        font-family: 'Open Sans', sans-serif;
    }
    h1,h2,h3,h4,h5,h6 {
        font-family: 'Open Sans', sans-serif;
    }
  /* @page { size: landscape; margin: 0px auto; } */
  @page {
  page-orientation: upright; 
  margin: 0px auto;
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

.border-dotted{
    border-style: dotted;
}
</style>


