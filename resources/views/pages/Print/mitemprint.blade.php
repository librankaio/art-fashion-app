<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>Print - Barcode</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="idr" onload="window.print()">

<div style="margin-left: 0%; margin-right: 0%;">
    {{-- <div class="upright">
        <div class="container-fluid">
            <div class="row">
                <div class="col-1">
                    test
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <center>
                {{$mitem->name}}<br>
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($mitem->code, 'C128') }}" alt="barcode" width="110"/> <br>
                {{$mitem->code}} <br>
                Rp. {{ number_format( $mitem->hrgjual, 2, '.', ',')}} <br>
                </center>
            </div>
        </div>
    </div>
    
</div>
</body>
</html>

<style type="text/css" media="print">
  @page { size: landscape; margin: 0px auto; }
  body {
  font-size: 9px;
  }
</style>


