<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>Print - Barcode</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:wght@700&display=swap" rel="stylesheet"> --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;900&family=Open+Sans&family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="idr" onload="window.print()">
    <div style="margin-left: 0%; margin-right: 0%; margin-top: 0%;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <center>
                    <p style="margin: 0px auto; font-size: 10px;">{{$mitem->name}}</p>
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($mitem->code, 'C128') }}" alt="barcode" width="158" height="25"/> <br>
                    {{-- {{$mitem->code ." ".date("mY")}}<br> --}}
                    <div class="row">
                        <div class="col-6" style="height: 14;">
                            <p style="font-size: 14px;">{{ $mitem->code }}</p>
                        </div>
                        <div class="col-6 pl-5" style="height: 14">
                            <p style="font-weight: normal; font-size: 9px;" class="text-right">
                                {{date("mY")}}
                            </p>
                        </div>
                    </div>
                    {{-- <div class="row" style="padding: 0 !important;
                    margin: 0 !important;">
                        <p class="p" style="margin: 0px auto; font-size: 11px;">Rp. {{ number_format( $mitem->hrgjual, 2, '.', ',')}}</p>
                    </div> --}}
                    Rp. {{ number_format( $mitem->hrgjual, 2, '.', ',')}} <br>
                    </center>
                </div>
            </div>
        </div>
        
    </div>
    <br>
</body>
</html>

<style type="text/css" media="print">
  @page { size: landscape; margin: 0px auto; }
  body {
  font-weight: bold;
  font-size: 14px;
  }
  p {
    font-size: 10px;
  }
</style>


