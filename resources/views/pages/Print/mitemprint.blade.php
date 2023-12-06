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
  </style>
</head>
</html>
<body>
  <div class="container" style="padding-bottom: 17px;">
    <h5 class="split-para" style="margin: 0px auto; font-size: 6px; text-align:left; padding-bottom: 1px;" id="text_code">{{ $mitem->name_lbl }} <span><h5 style="margin: 0px auto; font-size: 6px; float:right;">{{ $mitem->warna }}</h5></span></h5>
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($mitem->code , 'C128') }}" alt="barcode" width="100" height="20" id="bgimg"/>
    <h5 class="split-para" style="margin: 0px auto; font-size: 8px; text-align:left; margin-top: -5px" id="text_code">{{ $mitem->code }} <span><h5 style="margin: 0px auto; font-size: 8px; float:right;">RP. {{ number_format($mitem->hrgjual, 2, '.', ',') }},-</h5></span></h5>
  </div>
  <div class="container" style="padding-bottom: 0px">
      <h5 class="split-para" style="margin: 0px auto; font-size: 6px; text-align:left; padding-bottom: 1px;" id="text_code">{{ $mitem->name_lbl }} <span><h5 style="margin: 0px auto; font-size: 6px; float:right;">{{ $mitem->warna }}</h5></span></h5>
      <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($mitem->code , 'C128') }}" alt="barcode" width="100" height="20" id="bgimg"/>
      <h5 class="split-para" style="margin: 0px auto; font-size: 8px; text-align:left; margin-top: -5px" id="text_code">{{ $mitem->code }} <span><h5 style="margin: 0px auto; font-size: 8px; float:right;">RP. {{ number_format($mitem->hrgjual, 2, '.', ',') }},-</h5></span></h5>
  </div>
</body>