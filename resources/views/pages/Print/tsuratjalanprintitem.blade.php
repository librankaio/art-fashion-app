
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style>
    @page {
      size: 30mm 33mm;
      margin: 0px auto;
      /* margin-top: 5px auto; */
    }
    .container{
      position: static;
      margin-left: 7px;
    }
    .split-para{ 
      display:block;
      margin:10px;
    }
    /* .split-para span { 
      display:block; float:right ;width:50%; margin-left:10px; margin-right: 20px;
    } */
    .split-para span { 
      display:block; float:right; padding-right:7px; padding-top:2px;
    }
  </style>
</head>
</html>
<body>
@foreach($items as $item)
  @for($i = 0; $i < $item->qty; $i++)
  <div class="container" style="padding-bottom: 9px;">
    <h5 style="margin: 0px auto; font-size: 9px;" id="title">{{ $item->name }}</h5>
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->code , 'C128') }}" alt="barcode" width="100" height="20" id="bgimg"/> <br>
    <h1 class="split-para" style="margin: 0px auto; font-size: 9px; text-align:left;" id="text_code">{{ $item->code }} <span><h1 style="margin: 0px auto; font-size: 6px; float:right;">{{date("mY")}}</h1></span></h1>
    <h1 style="margin: 0px auto; text-align: center; font-size: 9px;">RP. {{ number_format($item->hrgjual, 2, '.', ',') }},-</h1>
  </div>
  <div class="container" style="padding-bottom: 6px;">
    <h5 style="margin: 0px auto; font-size: 9px;" id="title">{{ $item->name }}</h5>
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->code , 'C128') }}" alt="barcode" width="100" height="20" id="bgimg"/> <br>
    <h1 class="split-para" style="margin: 0px auto; font-size: 9px; text-align:left;" id="text_code">{{ $item->code }} <span><h1 style="margin: 0px auto; font-size: 6px; float:right;">{{date("mY")}}</h1></span></h1>
    <h1 style="margin: 0px auto; text-align: center; font-size: 9px;">RP. {{ number_format($item->hrgjual, 2, '.', ',') }},-</h1>
  </div>
  @endfor
@endforeach
</body>