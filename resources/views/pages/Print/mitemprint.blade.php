<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>Print - Barcode</title>
</head>
<body class="idr" onload="window.print()">

<div style="margin-left: 0%; margin-right: 0%;">
    {{$mitem->name}} <br>
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($mitem->code, 'C128') }}" alt="barcode" /> <br>
    {{$mitem->code}} <br>
    Rp. {{ number_format( $mitem->hrgjual, 2, '.', ',')}} <br>


{{-- <h2>Journal Voucher</h2>
<h5>NO Voucher : {{$name}} <br>
TANGGAL : <br>
KETERANGAN : <br> 
MATA UANG : </h5>
<center>
<table id="mytable" border="1px" cellspacing="0">
    <tr>
        <td align="center" style="width: 150px; word-wrap: break-word;">No</td>
        <td align="center" style="width: 150px; word-wrap: break-word;">Kode</td>
        <td align="center" style="width: 150px; word-wrap: break-word;">Nama</td>
        <td align="center" style="width: 150px; word-wrap: break-word;">Debit</td>
        <td align="center" style="width: 150px; word-wrap: break-word;">Credit</td>
        <td align="center" style="width: 150px; word-wrap: break-word;">Memo/Catatan</td>
    </tr>                      
    
    <td align="center" colspan="3">Total Debit : {!! DNS1D::getBarcodeHtml("xvz241241",'C128') !!}
    BR - {{ $name }}
    </td>
    <td align="center" colspan="3">Total Credit : <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG('xvz241241', 'C128') }}" alt="barcode" />
    BR - {{ $name }}
    </td>
    <td align="center" colspan="3">Grand Balance : </td>
    </table>
</center>
<br><br>
<p> --}}
	{{-- <footer><a href="http://www.swifect.com">~ Swifect Custom Application ~</a></footer> --}}
</div>
</body>
</html>

<style type="text/css" media="print">
  @page { size: landscape; margin: 0px auto; }
</style>


