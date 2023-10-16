<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>Print - Bon Penjualan</title>
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
                <div class="col-5 pl-4 py-0">
                    <center>
                        <img src="{{ asset('../assets/img/cherry.jpg') }}" alt="logo" width="200">
                        <h1>{{ strtoupper($tpenjualanh->counter) }}</h1>
                        <h5>{{ $address->alamat }}</h5>
                        <h5 style="margin: 0em;">{{ $tpenjualanh->no }}</h5>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px; margin: 0em;" />
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="timezone" hidden>{{ date_default_timezone_set('Asia/Jakarta') }}</div>
                    {{-- <div class="timezone" hidden>{{ setlocale (LC_TIME, 'id_ID'); }}</div> --}}
                    <h5>Pelanggan : {{ $tpenjualanh->counter }}</h5>
                    <h5>TRANSAKSI : {{ date("Y-m-d", strtotime($tpenjualanh->tgl)) }}</h5>
                    <h5>KARYAWAN : {{ session('name') }}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px; margin: 0em;" />
                </div>
            </div>
             @php $counter = 0; @endphp
             @php $subtot = 0; @endphp
             @php $qty = 0; @endphp
             @php $disc = 0; @endphp
             @php $final_disc = 0; @endphp
             @for($i = 0; $i < sizeof($tpenjualands); $i++) @php $counter++; @endphp <tr>
                            <div class="row">
                                <div class="col-5">
                                    <h5>{{ $tpenjualands[$i]->code." ".$tpenjualands[$i]->name}}</h5>
                                    @if($tpenjualands[$i]->diskon == 0 || $tpenjualands[$i]->diskon == '')
                                        <div class="row">
                                            <div class="col-6">
                                                @php $total_qty = $qty +  number_format($tpenjualands[$i]->qty, 0, '.', '') @endphp
                                                @php $qty = $total_qty @endphp
                                                <h5>{{ number_format($tpenjualands[$i]->qty, 0, '.', '')." Pcs x Rp.". number_format($tpenjualands[$i]->hrgjual)}}</h5>
                                            </div>                                            
                                            <div class="col-6 d-flex justify-content-end align-items-end">
                                                @php $total_subtot = $subtot +  $tpenjualands[$i]->subtotal @endphp
                                                @php $subtot = $total_subtot @endphp
                                                <h5>{{ number_format($tpenjualands[$i]->subtotal) }}</h5>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-6">
                                                @php $total_qty = $qty +  number_format($tpenjualands[$i]->qty, 0, '.', '') @endphp
                                                @php $qty = $total_qty @endphp
                                                <h5>{{ number_format($tpenjualands[$i]->qty, 0, '.', '')." Pcs x Rp.". number_format($tpenjualands[$i]->hrgjual)}}</h5>
                                            </div>                                            
                                            <div class="col-6 d-flex justify-content-end align-items-end">
                                                @php $total_subtot = $subtot +  $tpenjualands[$i]->subtotal @endphp
                                                @php $subtot = $total_subtot @endphp
                                                <h5>{{ number_format($tpenjualands[$i]->subtotal) }}</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                @php $total_disc = ($tpenjualands[$i]->subtotal * $tpenjualands[$i]->diskon)/100 @endphp
                                                @php $final_disc = $disc + $total_disc @endphp
                                                @php $disc = $total_disc @endphp
                                                <h5>Diskon {{ number_format($tpenjualands[$i]->diskon, 0, '.', '') }}%</h5>
                                            </div>
                                            <div class="col-6 d-flex justify-content-end align-items-end">
                                                <h5>{{ number_format($total_disc) }}</h5>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endfor
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px; margin: 0em;" />
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-6 d-flex">
                            <h5>Total Barang : </h5>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-end">
                            <h5>{{ $total_qty }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px; margin: 0em;" />
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-6 d-flex">
                            <h5>Subtotal :</h5>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-end">
                            <h5>{{ number_format($total_subtot) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-6 d-flex">
                            <h5>Diskon :</h5>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-end">
                            <h5>{{ number_format($final_disc) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px; margin: 0em;" />
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    @if ($tpenjualanh->payment_mthd_2 != null)
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h5>PEMBAYARAN SPLIT PAYMENT</h5>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-6 d-flex justify-content-end align-items-end">
                            </div> --}}
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h3 style="font-weight: bold;">TOTAL : RP.{{ number_format($tpenjualanh->grdtotal) }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h5>METODE PEMBAYARAN 1 : {{ $tpenjualanh->payment_mthd }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h5>BAYAR PAYMENT 1 : RP.{{ number_format($tpenjualanh->totbayar) }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h5>METODE PEMBAYARAN 2 : {{ $tpenjualanh->payment_mthd_2 }}</h5>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h5>BAYAR PAYMENT 2 : RP.{{ number_format($tpenjualanh->totbayar_2) }}</h5>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h5>KEMBALI : RP.{{ number_format($tpenjualanh->totkembali) }}</h5>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h3 style="font-weight: bold;">TOTAL : RP.{{ number_format($tpenjualanh->grdtotal) }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h5>METODE PEMBAYARAN : {{ $tpenjualanh->payment_mthd }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h5>BAYAR PAYMENT : RP.{{ number_format($tpenjualanh->totbayar) }}</h5>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end align-items-end">
                                <h5>KEMBALI : RP.{{ number_format($tpenjualanh->totkembali) }}</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px; margin: 0em;" />
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-6 d-flex justify-content-end align-items-end">
                            <h5>Tunai : </h5>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-end">
                            <h5>15,000.00</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-6 d-flex justify-content-end align-items-end">
                            <h5>Kembali : </h5>
                        </div>
                        <div class="col-6 d-flex justify-content-end align-items-end">
                            <h5>0</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px;" />
                </div>
            </div> --}}
            <div class="row">
                <div class="col-5 pl-4">
                    <center>
                        <h5>** Terima Kasih **</h5>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <hr style="border-top: dotted 0.3px; margin: 0em;" />
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-12">
                            <h5>Instagram : atfashion.official</h5>
                            <h5>Facebook : officialbrandartfashion</h5>
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


