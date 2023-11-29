
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
    body {
        font-family: 'Open Sans', sans-serif;
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
@foreach($items as $item)
  @for($i = 0; $i < $item->qty; $i++)
  <div class="container" style="padding-bottom: 7px;">
    {{-- <h5 style="margin: 0px auto; font-size: 8px;" id="title">{{ $item->name." - ".$item->warna }}</h5> --}}
    <h5 class="split-para" style="margin: 0px auto; font-size: 6px; text-align:left; padding-bottom: 1px;" id="text_code">{{ $item->name_lbl }} <span><h5 style="margin: 0px auto; font-size: 6px; float:right;">{{ $item->warna }}</h5></span></h5>
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->code , 'C128') }}" alt="barcode" width="100" height="20" id="bgimg"/>
    <h5 class="split-para" style="margin: 0px auto; font-size: 6px; text-align:left; margin-top: -5px" id="text_code">{{ $item->code }} <span><h5 style="margin: 0px auto; font-size: 6px; float:right;">{{date("mY")}}</h5></span></h5>
    <h1 style="margin: 0px auto; text-align: center; font-size: 7px; margin-top:-5px;">RP. {{ number_format($item->hrgjual, 2, '.', ',') }},-</h1>
  </div>
  <div class="container" style="padding-bottom: 0px">
  {{-- <div class="container" style="padding-bottom: 7px;"> --}}
    {{-- <h5 style="margin: 0px auto; font-size: 8px;" id="title">{{ $item->name." - ".$item->warna}}</h5> --}}
    <h5 class="split-para" style="margin: 0px auto; font-size: 6px; text-align:left; padding-bottom: 1px;" id="text_code">{{ $item->name_lbl }} <span><h5 style="margin: 0px auto; font-size: 6px; float:right;">{{ $item->warna }}</h5></span></h5>
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->code , 'C128') }}" alt="barcode" width="100" height="20" id="bgimg"/>
    <h5 class="split-para" style="margin: 0px auto; font-size: 6px; text-align:left; margin-top: -5px" id="text_code">{{ $item->code }} <span><h5 style="margin: 0px auto; font-size: 6px; float:right;">{{date("mY")}}</h5></span></h5>
    <h1 style="margin: 0px auto; text-align: center; font-size: 7px;">RP. {{ number_format($item->hrgjual, 2, '.', ',') }},-</h1>
  </div>
  <div class="page_break"></div> 
  @endfor
@endforeach
</body>