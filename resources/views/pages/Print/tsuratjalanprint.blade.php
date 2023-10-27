<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>Print - Surat Jalan</title>
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="idr" onload="window.print()" style="font-family: Open Sans;">

    <section class="upright">
        <div style="margin-left: 0%; margin-right: 0%;">
            <div class="container pt-5">
                <div class="row">
                    <div class="col-1">
                        <img src="{{ asset('../assets/img/artfashion_logo2.png') }}" alt="logo" width="200">
                    </div>                    
                    <div class="col-5" style="padding-left: 150px; padding-top: 30px">
                        <h5>Art Fashion Jewelry <br>Telp. (62 - 21) 645 0910/11<br>Fax. (62 - 21) 684288</h5>
                    </div>
                </div>
                <center>
                    <h1 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 6px;">SURAT JALAN</h1>
                </center>
                <div class="row pt-4">
                    <div class="col-6">
                    </div>
                    <div class="col-6 d-flex justify-content-end align-items-end">
                        <table id="mytable" border="1px">
                            <thead>
                                <tr>
                                    <td class="p-2" style="width: 300px; word-wrap: break-word;">From : {{ $tsjh->counter_from }}<br> </td>
                                </tr>
                                <tr>
                                    <td class="p-2" style="width: 300px; word-wrap: break-word;">To : {{ $tsjh->counter }}<br> </td>
                                </tr>  
                                <tr>
                                    <td class="p-2" style="width: 300px; word-wrap: break-word;">Alamat : {{ $address->alamat }}<br> </td>
                                </tr>  
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h5>No Surat Jalan : {{ $tsjh->no }} </h5>
                </div>
                <div class="col-6 text-right">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h5>Tanggal Surat Jalan : {{ date("Y-m-d", strtotime($tsjh->tgl)) }} </h5>
                </div>
                <div class="col-6 text-right">
                </div>
            </div>
            <center>              
                <table id="mytable" border="1px">
                    <thead>
                        <tr>
                            <td align="center" style="width: 150px; word-wrap: break-word;">No</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">Kode</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">Nama Item</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">Quantity</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">Satuan</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">Harga</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">Subtotal</td>
                        </tr>  
                    </thead>
                    <tbody>
                        @php $counter = 0; @endphp
                        @php $qty_sum = 0; @endphp
                        @for($i = 0; $i < sizeof($tsjds); $i++) @php $counter++; @endphp <tr>
                            <td align="center" style="width: 150px; word-wrap: break-word;">{{ $counter }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">{{ $tsjds[$i]->code }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">{{ $tsjds[$i]->name }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">{{ number_format($tsjds[$i]->qty, 0, '.', '') }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">{{ $tsjds[$i]->satuan }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">{{ number_format($tsjds[$i]->hrgjual, 0, '.', ',') }}</td>
                            <td align="center" style="width: 150px; word-wrap: break-word;">{{ number_format($tsjds[$i]->subtotal, 0, '.', ',') }}</td>
                            </tr>
                            @if($qty_sum == 0)
                                @php $qty_sum = $qty_sum + number_format($tsjds[$i]->qty, 0, '.', '')@endphp
                            @else
                                @php $qty_sum = $qty_sum + number_format($tsjds[$i]->qty, 0, '.', '')@endphp
                            @endif 
                        @endfor
                    </tbody>  
                    <td align="center" colspan="3">Total Quantity</td>
                    <td align="center">{{ $qty_sum }}</td>
                    <td align="center" colspan="2"></td>
                    <td align="center" colspan="2">Grand Total : {{ number_format($tsjh->grdtotal, 0, '.', ',') }}</td>
                </table>
            </center>
            <center>
                <div class="container pt-5">
                    <div class="row d-flex justify-content-center align-items-center">
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
                            <h5>Pemeriksa</h5>
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
            {{-- <center>
                <div class="container pt-5">
                    <div class="row">
                        <div class="col-3">
                            <h5>Jakarta, {{ date("d-m-Y") }}</h5>
                            <br>
                            <br>
                            <br>
                            <h5>{{ session('name'); }}</h5>
                            <hr style="border-top: dotted 0.3px;" />
                        </div>
                    </div>
                </div>
            </center> --}}
            </div>
    </section>

</body>
</html>

<style type="text/css" media="print">
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-Bold.ttf") }}) format("truetype");
        font-weight: 700;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-BoldItalic.ttf") }}) format("truetype");
        font-weight: 700;
        font-style: italic;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-ExtraBold.ttf") }}) format("truetype");
        font-weight: 800;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-ExtraBoldItalic.ttf") }}) format("truetype");
        font-weight: 800;
        font-style: italic;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-Light.ttf") }}) format("truetype");
        font-weight: 300;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-LightItalic.ttf") }}) format("truetype");
        font-weight: 300;
        font-style: italic;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-Medium.ttf") }}) format("truetype");
        font-weight: 500;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-MediumItalic.ttf") }}) format("truetype");
        font-weight: 500;
        font-style: italic;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-Regular.ttf") }}) format("truetype");
        font-weight: 400;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-SemiBold.ttf") }}) format("truetype");
        font-weight: 600;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-SemiBoldItalic.ttf") }}) format("truetype");
        font-weight: 600;
        font-style: italic;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path("fonts/static/OpenSans/OpenSans-Italic.ttf") }}) format("truetype");
        font-weight: 400;
        font-style: italic;
    }
    @page {
      size: 30mm 33mm;
      margin: -1px auto;
      /* margin-top: 5px auto; */
    }
    body {
        /* font-family: 'Roboto';font-size: 16px; */
        font-family: 'Open Sans', sans-serif;
    }
    h1,h2,h3,h4,h5,h6 {
        font-family: 'Open Sans', sans-serif;
    }
    td{
        font-family: 'Open Sans';
        font-weight: bold;
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


