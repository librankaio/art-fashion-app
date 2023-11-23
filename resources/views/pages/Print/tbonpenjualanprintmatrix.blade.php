<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style>
    @page {
      /* size: 76mm 296mm; */
      margin: 8px;
      break-inside: avoid;
      /* margin-top: 5px auto; */
    }
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
    .container{
      position: static;
      margin-left: 7px;
    }
    .split-para{ 
      display:block;
      /* margin:10px; */
      margin:0px;
    }
    /* .split-para span { 
      display:block; float:right ;width:50%; margin-left:10px; margin-right: 20px;
    } */
    .split-para span { 
      /* display:block; float:right; padding-right:7px; padding-top:2px; */
      display:block; float:right; padding-right:7px; padding-top:0px;
    }
    body {
        /* font-family: 'Roboto';font-size: 16px; */
        font-family: 'Open Sans', sans-serif;        
    }
    h1,h2,h3,h4,h5,h6 {
        font-family: 'Open Sans', sans-serif;
    }
    h1{
        font-size: 20px;
        word-wrap: break-word;
        white-space: normal;
        margin-top: 0;
        margin-bottom: 0;
    }
    h5{
        font-size: 15px;
    }
    h3{
        font-size: 17px;
    }
    p  
    { 
      word-wrap: break-word
    } 
  </style>
</head>
</html>
<body style="page-break-inside: avoid;">
  <center style="padding-top: 3px">
      <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('/assets/img/cherry.jpg')))}}" alt="barcode" width="200" id="bgimg"/>
      <h1 id="text_code">{{ strtoupper($tpenjualanh->counter) }}</h1>
      {{-- <h5 style="margin-bottom: 0;">{{ $address->alamat }}</h5> --}}
      <h5 style="margin-bottom: 0;">{{ $tpenjualanh->no }}</h5>
  </center>
  <hr style="border-style: dashed; size: 1px;">
  {{-- <div class="timezone" hidden>{{ date_default_timezone_set('Asia/Jakarta') }}</div> --}}
  <h5 class="split-para" style="margin: 0px auto; text-align:left;">Pelanggan : {{ $tpenjualanh->counter }}</h5>
  <h5 class="split-para" style="margin: 0px auto; text-align:left;">TRANSAKSI : {{ date("Y-m-d", strtotime($tpenjualanh->tgl)) }}</h5>
  <h5 class="split-para" style="margin: 0px auto; text-align:left;">KARYAWAN : {{ session('name') }}</h5>
  <hr style="border-style: dashed; size: 1px;">
  @php $counter = 0; @endphp
  @php $subtot = 0; @endphp
  @php $qty = 0; @endphp
  @php $disc = 0; @endphp
  @php $final_disc = 0; @endphp
  @for($i = 0; $i < sizeof($tpenjualands); $i++) @php $counter++; @endphp
  @php $counter++; @endphp
     <h5 style="margin: 0px auto; text-align:left;">{{ $tpenjualands[$i]->code." ".$tpenjualands[$i]->name}}</h5>
        @if($tpenjualands[$i]->diskon == 0 || $tpenjualands[$i]->diskon == '')
            @php $total_qty = $qty +  number_format($tpenjualands[$i]->qty, 0, '.', '') @endphp
            @php $qty = $total_qty @endphp
            @php $total_subtot = $subtot +  $tpenjualands[$i]->subtotal @endphp
            @php $subtot = $total_subtot @endphp
            <h5 class="split-para" style="margin: 0px auto; text-align:left;">{{ number_format($tpenjualands[$i]->qty, 0, '.', '')." Pcs x Rp.". number_format($tpenjualands[$i]->hrgjual)}} <span><h5 style="margin: 0px auto; float:right;">{{ number_format($tpenjualands[$i]->subtotal) }}</h5></span></h5>
        @else
            @php $total_qty = $qty +  number_format($tpenjualands[$i]->qty, 0, '.', '') @endphp
            @php $qty = $total_qty @endphp
            @php $total_subtot = $subtot +  $tpenjualands[$i]->subtotal @endphp
            @php $subtot = $total_subtot @endphp
            <h5 class="split-para" style="margin: 0px auto; text-align:left;">{{ number_format($tpenjualands[$i]->qty, 0, '.', '')." Pcs x Rp.". number_format($tpenjualands[$i]->hrgjual)}} <span><h5 style="margin: 0px auto; float:right;">{{ number_format($tpenjualands[$i]->subtotal) }}</h5></span></h5>
            @php $total_disc = ($tpenjualands[$i]->subtotal * $tpenjualands[$i]->diskon)/100 @endphp
            @php $final_disc = $disc + $total_disc @endphp
            @php $disc = $total_disc @endphp
            <h5 class="split-para" style="margin: 0px auto; text-align:left;">Diskon {{ number_format($tpenjualands[$i]->diskon, 0, '.', '') }}%<span><h5 style="margin: 0px auto; float:right; padding-left:10px">{{ number_format($total_disc) }}</h5></span></h5>
        @endif
  @endfor
  <hr style="border-style: dashed; size: 1px;">
  <h5 class="split-para" style="margin: 0px auto; text-align:left;">Total Barang : <span><h5 style="margin: 0px auto; float:right;">{{ $total_qty }}</h5></span></h5>
  <hr style="border-style: dashed; size: 1px;">
  <h5 class="split-para" style="margin: 0px auto; text-align:left;">Diskon : <span><h5 style="margin: 0px auto; float:right;">{{ number_format($final_disc) }}</h5></span></h5>
  <hr style="border-style: dashed; size: 1px;">
  <h5 class="split-para" style="margin: 0px auto; text-align:left;">-<span><h5 style="margin: 0px auto; float:right;">TOTAL : RP.{{ number_format($tpenjualanh->grdtotal) }}</h5></span></h5>
  @if ($tpenjualanh->payment_mthd_2 != null)
    <h5 class="split-para" style="margin: 0px auto; text-align:left;"><span><h5 style="margin: 0px auto; float:right;">PEMBAYARAN SPLIT PAYMENT</h5></span></h5>
    <h5 class="split-para" style="margin: 0px auto; text-align:left;"><span><h3 style="margin: 0px auto; float:right;">TOTAL : RP.{{ number_format($tpenjualanh->grdtotal) }}</h3></span></h5>
    <h5 class="split-para" style="margin: 0px auto; text-align:left;"><span><h5 style="margin: 0px auto; float:right;">METODE PEMBAYARAN 1 : {{ $tpenjualanh->payment_mthd }}</h5></span></h5>
    <h5 class="split-para" style="margin: 0px auto; text-align:left;"><span><h5 style="margin: 0px auto; float:right;">BAYAR PAYMENT 1 : RP.{{ number_format($tpenjualanh->totbayar) }}</h5></span></h5>
    <h5 class="split-para" style="margin: 0px auto; text-align:left;"><span><h5 style="margin: 0px auto; float:right;">METODE PEMBAYARAN 2 : {{ $tpenjualanh->payment_mthd_2 }}</h5></span></h5>
    <h5 class="split-para" style="margin: 0px auto; text-align:left;"><span><h5 style="margin: 0px auto; float:right;">BAYAR PAYMENT 2 : RP.{{ number_format($tpenjualanh->totbayar_2) }}</h5></span></h5>
    <h5 class="split-para" style="margin: 0px auto; text-align:left;"><span><h5 style="margin: 0px auto; float:right;">KEMBALI : RP.{{ number_format($tpenjualanh->totkembali) }}</h5></span></h5>
  @else
    {{-- <h5 class="split-para" style="margin: 0px auto; text-align:left;"> <span><h3 style="margin: 0px auto; float:right;">TOTAL : RP.{{ number_format($tpenjualanh->grdtotal) }}</h3></span></h5> --}}
    @if(session('privilage') != 'ADM')
    <h5 class="split-para" style="margin: 0px auto; text-align:left;"><span><h5 style="margin: 0px auto; float:right;">METODE PEMBAYARAN : {{ $tpenjualanh->payment_mthd }}</h5></span></h5>
    @endif
    @if(session('privilage') != 'ADM')
    <h5 class="split-para" style="margin: 0px auto; text-align:left;"><span><h5 style="margin: 0px auto; float:right;">BAYAR PAYMENT : RP.{{ number_format($tpenjualanh->totbayar) }}</h5></span></h5>
    @endif
    @if(session('privilage') != 'ADM')
    <h5 class="split-para" style="margin: 0px auto; text-align:left;"><span><h5 style="margin: 0px auto; float:right;">KEMBALI : RP.{{ number_format($tpenjualanh->totkembali) }}</h5></span></h5>
    @endif
  @endif
  <hr style="border-style: dashed; size: 1px;">
  <center style="margin: 0px auto"><h5 style="margin: 0px auto">** Terima Kasih **</h5></center>
  {{-- <h5 class="split-para" style="margin: 0px auto; text-align:left;">** Terima Kasih **<span><h5 style="margin: 0px auto; float:right;"></h5></span></h5> --}}
  <hr style="border-style: dashed; size: 1px;">
  <h5 class="split-para" style="margin: 0px auto; text-align:left;">Instagram : atfashion.official<span><h5 style="margin: 0px auto; float:right;"></h5></span></h5>
  <h5 class="split-para" style="margin: 0px auto; text-align:left;">Facebook : officialbrandartfashion<span><h5 style="margin: 0px auto; float:right;"></h5></span></h5>
</body>