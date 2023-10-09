<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>Print - Laporan Pendapatan Outlet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="idr" onload="window.print()">

    <section class="upright">
        <div >
            {{-- <div class="container pt-5">
                <div class="row">
                    <div class="col-6">
                        <h5>Art Fashion Jewelry <br>Telp. (62 - 21) 645 0910/11<br>Fax. (62 - 21) 684288</h5>
                    </div>
                    <div class="col-6 text-right">
                        <h5>Jakarta<br>{{ date("Y-m-d") }}<br>Pameran Paramita Depok<br>Jawa Barat</h5>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-5 pl-4">
                    <center>
                        <img src="{{ asset('../assets/img/cherry.jpg') }}" alt="logo" width="200">
                        <h1>Pendapatan Outlet</h1>
                        <h5>{{ $counter }}</h5>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px;" />
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="timezone" hidden>{{ date_default_timezone_set('Asia/Jakarta') }}</div>
                    <div class="timezone" hidden>{{ setlocale (LC_TIME, 'id_ID'); }}</div>
                    {{-- <h5>Pelanggan : {{ $tpenjualanh->counter }}</h5> --}}
                    <h5>TANGGAL CETAK : {{ strftime( "%A, %d %B %Y %H:%M", time()); }}</h5>
                    <h5>KARYAWAN : {{ session('name') }}</h5>
                    <h5>DARI TANGGAL : {{ date("Y-m-d", strtotime($dtfr)) }}</h5>
                    <h5>SAMPAI TANGGAL : {{ date("Y-m-d", strtotime($dtto)) }}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px;" />
                </div>
            </div>
             @for($i = 0; $i < sizeof($results); $i++) @php $counter++; @endphp 
             <tr>
                <div class="row">
                    <div class="col-5">
                        <h5>{{ $results[$i]->payment_mthd}}</h5>
                        <div class="row">
                            @php $total_trans = 0; @endphp
                            @if($total_trans == 0)
                                @php $total_trans = $total_trans + $results[$i]->jmltransaksi @endphp
                            @else
                                @php $total_trans = $total_trans + $results[$i]->jmltransaksi @endphp
                            @endif
                            @php $total_pendapatan = 0; @endphp
                            @if($total_trans == 0)
                                @php $total_pendapatan = $total_pendapatan + $results[$i]->total @endphp
                            @else
                                @php $total_pendapatan = $total_pendapatan + $results[$i]->total @endphp
                            @endif
                            <div class="col-6">
                                @php $total_qty = number_format($results[$i]->jmltransaksi, 0, '.', '') @endphp
                                @php $qty = $total_qty @endphp
                                <h5>{{ number_format($results[$i]->jmltransaksi, 0, '.', '')." x Penerimaan"}}</h5>
                            </div>  
                            <div class="col-6 d-flex justify-content-end align-items-end">
                                <h5>{{ 'Rp.'.number_format($results[$i]->total, 2, '.', '') }}</h5>
                            </div>  
                        </div>
                    </div>
                </div>
            </tr>
            @endfor
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px;" />
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-6">
                            <h5>Total Transaksi : </h5>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-end">
                            <h5>{{ $total_trans }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-6">
                            <h5>Total Pendapatan : </h5>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-end">
                            <h5>{{'Rp. '.number_format($total_pendapatan, 2, '.', '') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
    </section>

</body>
</html>

<style type="text/css" media="print">
    body {
        /* font-family: 'Roboto';font-size: 16px; */
        font-family: 'Open Sans', sans-serif;        
    }
    h1,h2,h3,h4,h5,h6 {
        font-family: 'Open Sans', sans-serif;
    }
    h1{
        font-size: 25px;
    }
    h5{
        font-size: 15px;
    }
    h3{
        font-size: 20px;
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