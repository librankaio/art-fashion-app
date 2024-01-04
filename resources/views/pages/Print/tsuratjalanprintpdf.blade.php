
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style>
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
    hr{
        border-top: 1px solid;
    }
    .split-para span { 
      /* display:block; float:right; padding-right:7px; padding-top:2px; */
      display:block; float:right; padding-right:7px; padding-top:0px;
    }
  </style>
</head>
</html>
{{-- <link rel="stylesheet" href="{{ url('/bootstrap/css/bootstrap.min.css') }}"> --}}
<body style="font-family: Open Sans;">
    <div style="margin-left: 0%; margin-right: 0%;">
        <h5 class="split-para" style="margin: 0px auto; text-align:left; padding-bottom: 1px;" id="text_code"><span><h5 style="margin: 0px auto; float:right; font-size:15px">Art Fashion Jewelry <br>Telp.(021) 6403172 / 6401336<br>Fax. 021.6401336</h5></span></h5>
        {{-- <img src="/public/assets/img/artfashion_logo2.png" alt="logo" width="200"> --}}
        <img src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(base_path('public/assets/img/artfashion_logo2.png'))); ?>" width="200">
        {{-- <h5>Art Fashion Jewelry <br>Telp.(021) 6403172 / 6401336<br>Fax. 021.6401336</h5> --}}
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
                            <td class="p-2" style="width: 200px; word-wrap: break-word; font-size:13px;">From : {{ $tsjh->counter_from }}<br></td>
                        </tr>
                        <tr>
                            <td class="p-2" style="width: 200px; word-wrap: break-word; font-size:13px;">To : {{ $tsjh->counter }}<br> </td>
                        </tr>  
                        <tr>
                            <td class="p-2" style="width: 200px; word-wrap: break-word; font-size:13px;">Alamat : {{ $address->alamat }}<br> </td>
                        </tr>  
                    </thead>
                </table>
            </div>
        </div>
        <h5>No Surat Jalan : {{ $tsjh->no }} </h5>
        <h5>Tanggal Surat Jalan : {{ date("Y-m-d", strtotime($tsjh->tgl)) }} </h5>
        <center>              
            <table id="mytable" border="0.5px" style="border:solid;">
                <thead>
                    <tr>
                        <td align="center" style="width: 40px; word-wrap: break-word;">No</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">Kode</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">Nama Item</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">Warna</td>
                        <td align="center" style="width: 40px; word-wrap: break-word;">Quantity</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">Satuan</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">Harga</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">Subtotal</td>
                    </tr>  
                </thead>
                <tbody>
                    @php $counter = 0; @endphp
                    @php $qty_sum = 0; @endphp
                    @for($i = 0; $i < sizeof($tsjds); $i++) @php $counter++; @endphp <tr>
                        <td align="center" style="width: 40px; word-wrap: break-word;">{{ $counter }}</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">{{ $tsjds[$i]->code }}</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">{{ $tsjds[$i]->name }}</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">{{ $tsjds[$i]->warna }}</td>
                        <td align="center" style="width: 40px; word-wrap: break-word;">{{ number_format($tsjds[$i]->qty, 0, '.', '') }}</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">{{ $tsjds[$i]->satuan }}</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">{{ number_format($tsjds[$i]->hrgjual, 0, '.', ',') }}</td>
                        <td align="center" style="width: 80px; word-wrap: break-word;">{{ number_format($tsjds[$i]->subtotal, 0, '.', ',') }}</td>
                        </tr>
                        @if($qty_sum == 0)
                            @php $qty_sum = $qty_sum + number_format($tsjds[$i]->qty, 0, '.', '')@endphp
                        @else
                            @php $qty_sum = $qty_sum + number_format($tsjds[$i]->qty, 0, '.', '')@endphp
                        @endif 
                    @endfor
                </tbody>  
                <td align="center" colspan="4">Total Quantity</td>
                <td align="center">{{ $qty_sum }}</td>
                <td align="center" colspan="2"></td>
                <td align="center" colspan="2">Grand Total : {{ number_format($tsjh->grdtotal, 0, '.', ',') }}</td>
            </table>
        </center>
        <center>
            <table>
                <thead>
                    <tr>
                        <td align="center" style="width: 170px; word-wrap: break-word;">Penerima</td>
                        <td align="center" style="width: 170px; word-wrap: break-word;">Pengirim</td>
                        <td align="center" style="width: 170px; word-wrap: break-word;">Pemeriksa</td>
                        <td align="center" style="width: 170px; word-wrap: break-word;">Hormat Kami</td>
                    </tr>                    
                </thead>
                <br>
                <br>
                <tbody>
                    <tr>
                        <td align="center" style="width: 150px; word-wrap: break-word;"><hr></td>
                        <td align="center" style="width: 150px; word-wrap: break-word;"><hr></td>
                        <td align="center" style="width: 150px; word-wrap: break-word;"><hr></td>
                        <td align="center" style="width: 150px; word-wrap: break-word;"><hr></td>
                    </tr>
                </tbody>
            </table>
        </center>
    </div>
</body>