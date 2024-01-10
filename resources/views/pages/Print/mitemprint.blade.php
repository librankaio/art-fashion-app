<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  {{-- <style>
    @page {
      size: 30mm 33mm;
      margin: -1px auto;
      /* margin-top: 5px auto; */
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
    h1,h2,h3,h4,h5,h6 {
      font-family: 'Roboto', sans-serif;
    }
    td{
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
    }
    p  
    { 
      word-wrap: break-word
    } 
  </style> --}}
  <style>
    @page {
      size: 30mm 33mm;
      margin: -1px auto;
      /* margin-top: 5px auto; */
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
    /* body {
        font-family: 'Open Sans';
    } */
    body {
        /* font-family: 'Roboto';font-size: 16px; */
        font-family: 'Roboto', sans-serif;
    }
    h1,h2,h3,h4,h5,h6 {
      font-family: 'Roboto', sans-serif;
    }
    td{
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
    }
    p  
    { 
      word-wrap: break-word
    } 
    .page_break { page-break-before: always; }
  </style>
</head>
</html>
<body>
  <div class="container" style="padding-bottom: 15px;">
    <h5 class="split-para" style="margin: 0px auto; font-size: 6px; text-align:left; padding-bottom: 1px;" id="text_code">{{ $mitem->name_lbl }} <span><h5 style="margin: 0px auto; font-size: 6px; float:right;">{{ $mitem->warna }}</h5></span></h5>
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($mitem->code , 'C128') }}" alt="barcode" width="100" height="20" id="bgimg"/>
    <h5 class="split-para" style="margin: 0px auto; font-size: 7px; text-align:left; margin-top: -5px" id="text_code">{{ $mitem->code }} <span><h5 style="margin: 0px auto; font-size: 7px; float:right; font-weight: bold;">RP. {{ number_format($mitem->hrgjual, 2, '.', ',') }},-</h5></span></h5>
  </div>
  <div class="container" style="padding-bottom: 0px">
    <h5 class="split-para" style="margin: 0px auto; font-size: 6px; text-align:left; padding-bottom: 1px;" id="text_code">{{ $mitem->name_lbl }} <span><h5 style="margin: 0px auto; font-size: 6px; float:right;">{{ $mitem->warna }}</h5></span></h5>
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($mitem->code , 'C128') }}" alt="barcode" width="100" height="20" id="bgimg"/>
    <h5 class="split-para" style="margin: 0px auto; font-size: 7px; text-align:left; margin-top: -5px" id="text_code">{{ $mitem->code }} <span><h5 style="margin: 0px auto; font-size: 7px; float:right; font-weight: bold;">RP. {{ number_format($mitem->hrgjual, 2, '.', ',') }},-</h5></span></h5>
  </div>
</body>