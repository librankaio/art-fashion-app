
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <style>
    @page {
    margin-top: 0px;
    }
    body {
        /* font-family: 'Roboto';font-size: 16px; */
        font-family: 'Roboto', sans-serif;
    }
    h1,h2,h3,h4,h5,h6 {
      font-family: 'Roboto', sans-serif;
      margin-top: 0;
      margin-bottom: 0;
    }
    td{
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size:15px
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
            @if($treturh->counter == "HEAD OFFICE ARTFASHION" || $treturh->counter == "HEAD OFFICE CHERRY")
                <h1 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 6px;">RETUR PENJUALAN</h1>
            @else
                <h1 style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 6px;">SURAT JALAN</h1>
            @endif
        </center>
        <div class="row pt-4">
            <div class="col-6">
            </div>
            <div class="col-6 d-flex justify-content-end align-items-end">
                <table id="mytable" border="1px">
                    <thead>
                        <tr>
                            <td class="p-2" style="width: 200px; word-wrap: break-word; font-size:13px;">From : {{ $treturh->counter }}<br></td>
                        </tr>
                        {{-- <tr>
                            <td class="p-2" style="width: 200px; word-wrap: break-word; font-size:13px;">To : {{ $tsjh->counter }}<br> </td>
                        </tr>   --}}
                        <tr>
                            <td class="p-2" style="width: 200px; word-wrap: break-word; font-size:13px;">Alamat : {{ $address->alamat }}<br> </td>
                        </tr>  
                    </thead>
                </table>
            </div>
        </div>
        <h5>No Retur : {{ $treturh->no }} </h5>
        <h5>Tanggal Retur : {{ date("Y-m-d", strtotime($treturh->tgl)) }} </h5>
        <center>              
            <table id="mytable" border="0.5px" style="border:solid;">
                <thead>
                    <tr>
                        <td align="center" style="width: 105px; word-wrap: break-word;">No</td>
                        <td align="center" style="width: 250px; word-wrap: break-word;">Kode</td>
                        <td align="center" style="width: 140px; word-wrap: break-word;">Nama Item</td>
                        <td align="center" style="width: 105px; word-wrap: break-word;">Warna</td>
                        <td align="center" style="width: 60px; word-wrap: break-word;">Quantity</td>
                        <td align="center" style="width: 105px; word-wrap: break-word;">Satuan</td>
                        {{-- <td align="center" style="width: 105px; word-wrap: break-word;">Harga</td>
                        <td align="center" style="width: 105px; word-wrap: break-word;">Subtotal</td> --}}
                    </tr>  
                </thead>
                <tbody>
                    @php $counter = 0; @endphp
                    @php $qty_sum = 0; @endphp
                    @for($i = 0; $i < sizeof($treturds); $i++) @php $counter++; @endphp <tr>
                        <td align="center" style="width: 105px; word-wrap: break-word;">{{ $counter }}</td>
                        <td align="center" style="width: 250px; word-wrap: break-word;">{{ $treturds[$i]->code }}</td>
                        <td align="center" style="width: 140px; word-wrap: break-word;">{{ $treturds[$i]->name }}</td>
                        <td align="center" style="width: 105px; word-wrap: break-word;">{{ $treturds[$i]->warna }}</td>
                        <td align="center" style="width: 60px; word-wrap: break-word;">{{ number_format($treturds[$i]->qty, 0, '.', '') }}</td>
                        <td align="center" style="width: 105px; word-wrap: break-word;">{{ $treturds[$i]->satuan }}</td>
                        {{-- <td align="center" style="width: 105px; word-wrap: break-word;">{{ number_format($treturds[$i]->hrgjual, 0, '.', ',') }}</td>
                        <td align="center" style="width: 105px; word-wrap: break-word;">{{ number_format($treturds[$i]->subtotal, 0, '.', ',') }}</td> --}}
                        </tr>
                        @if($qty_sum == 0)
                            @php $qty_sum = $qty_sum + number_format($treturds[$i]->qty, 0, '.', '')@endphp
                        @else
                            @php $qty_sum = $qty_sum + number_format($treturds[$i]->qty, 0, '.', '')@endphp
                        @endif 
                    @endfor
                </tbody>  
                <td align="center" colspan="5">Total Quantity</td>
                <td align="center">{{ $qty_sum }}</td>
                {{-- <td align="center" colspan="2"></td> --}}
                {{-- <td align="center" colspan="2">Grand Total : {{ number_format($treturh->grdtotal, 0, '.', ',') }}</td> --}}
            </table>
        </center>
        <center>
            <table>
                <thead>
                    <tr>
                        <td align="center" style="width: 200px; word-wrap: break-word;">Penerima</td>
                        <td align="center" style="width: 200px; word-wrap: break-word;">Pengirim</td>
                        <td align="center" style="width: 200px; word-wrap: break-word;">Pemeriksa</td>
                        <td align="center" style="width: 200px; word-wrap: break-word;">Hormat Kami</td>
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