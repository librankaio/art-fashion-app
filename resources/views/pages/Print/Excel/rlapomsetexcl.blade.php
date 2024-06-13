<?php  
  $filename = "Laporan_Omset_PerItem.xls";
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");
  setlocale(LC_ALL,"US");
  //Setup localization
?>
<html>

<head>

    <title>LAPORAN OMSET PER-ITEM</title>
</head>

<body class="idr" onload="window.print()">
    <div style="margin-left: 0%; margin-right: 0%;">
        <h5>LAPORAN OMSET PER-ITEM<br>
            {{ $counter }}<br>
    <?php
    if ($dtfr == NULL AND $dtto == NULL) {
    }else{
        $dtfr = strtotime($dtfr);
        $dtto = strtotime($dtto);
    ?>
            PERIODE {{ date('d/m/Y',$dtfr) }} S.D {{ date('d/m/Y',$dtto) }}
        </h5>
        <?php } ?>

        <center>
            <table id="mytable" border="1px" cellspacing="0">
                <tr>
                    <th scope="col" class="border border-5" style="text-align: center;">No</th>
                    <th scope="col" class="border border-5" style="text-align: center;">No Transaksi</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Tanggal</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Kode</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Nama Item</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Quantity</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Discount (%)</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Discount</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Subtotal Sebelum Discount</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Subtotal</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Jenis Pembayaran</th>
                </tr>
                
                @if(count($results) > 0)
                    @php $counter = 0 @endphp
                    @php $total_qty = 0; @endphp
                    @php $total_subtotal = 0; @endphp
                    @php $total = 0; @endphp
                    @php $notrans = ""; @endphp
                    @foreach ($results as $key => $item)
                        @php $counter++ @endphp
                        @php $total_item = (float) $item->subtotal @endphp
                        @php $subtotal = $total + $total_item   @endphp
                        <tr>
                            @if( $item->no == $notrans )
                                <th scope="row" class="border border-5">{{ $counter }}</th>
                                <td class="border border-5" style="text-align: center;"></td>
                                <td class="border border-5" style="text-align: center;">{{ date("Y-m-d", strtotime($item->tgl)) }}</td>
                                <td class="border border-5" style="text-align: center;">{{ $item->CODE }}</td>
                                <td class="border border-5" style="text-align: center;">{{ $item->name }}</td>
                                <td class="border border-5" style="text-align: center;">{{ $item->qty }}</td>
                                <td class="border border-5" style="text-align: center;">{{ number_format($item->diskon, 0, '.', '') }}</td>
                                <td class="border border-5" style="text-align: center;">{{ number_format($item->disctot, 0, '.', ',') }}</td>
                                <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotalbef, 0, '.', ',') }}</td>
                                <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotal, 0, '.', ',') }}</td>
                                <td class="border border-5" style="text-align: center;">{{ $item->payment_mthd }}</td>
                            @else
                                <th scope="row" class="border border-5">{{ $counter }}</th>
                                <td class="border border-5" style="text-align: center;">{{ $item->no }}</td>
                                <td class="border border-5" style="text-align: center;">{{ date("Y-m-d", strtotime($item->tgl)) }}</td>
                                <td class="border border-5" style="text-align: center;">{{ $item->CODE }}</td>
                                <td class="border border-5" style="text-align: center;">{{ $item->name }}</td>
                                <td class="border border-5" style="text-align: center;">{{ $item->qty }}</td>
                                <td class="border border-5" style="text-align: center;">{{ number_format($item->diskon, 0, '.', '') }}</td>
                                <td class="border border-5" style="text-align: center;">{{ number_format($item->disctot, 0, '.', ',') }}</td>
                                <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotalbef, 0, '.', ',') }}</td>
                                <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotal, 0, '.', ',') }}</td>
                                <td class="border border-5" style="text-align: center;">{{ $item->payment_mthd }}</td>
                            @endif   
                        </tr>
                        @php $tot_sblmdisc = $item->no; @endphp
                        @php $notrans = $item->no; @endphp
                        @if($total_qty == 0)
                            @php $total_qty = $total_qty + $item->qty @endphp
                        @else
                            @php $total_qty = $total_qty + $item->qty @endphp
                        @endif
                        @if($total_subtotal == 0)
                            @php $total_subtotal = $total_subtotal + $item->subtotal @endphp
                        @else
                            @php $total_subtotal = $total_subtotal + $item->subtotal @endphp
                        @endif
                        @endforeach
                        
                        <td align="center" colspan="5">Total Quantity</td>   
                        <td align="center" colspan="1">{{ $total_qty }}</td>
                        <td align="center" colspan="2">Grand Total Sebelum Disc</td>
                        @php $old_sumtot_sblmdisc = 0; @endphp
                        @php $old_sumtot_sblmdisc_2 = 0; @endphp
                        @php $tot_sblmdisc = 0; @endphp
                        @foreach($results as $data => $item)
                        @if($tot_sblmdisc == 0)
                            @php $tot_sblmdisc = number_format($item->subtotalbef, 0, '.', '') @endphp
                        @else
                            @if ($old_sumtot_sblmdisc == 0)
                                @php $old_sumtot_sblmdisc = $tot_sblmdisc + number_format($item->subtotalbef, 0, '.', '') @endphp
                            @else
                                @php $old_sumtot_sblmdisc_2 = $old_sumtot_sblmdisc + number_format($item->subtotalbef, 0, '.', '') @endphp
                                @php $old_sumtot_sblmdisc = $old_sumtot_sblmdisc_2 @endphp
                            @endif
                        @endif
                        @endforeach
                        <td align="center" colspan="1">{{ number_format($old_sumtot_sblmdisc, 0, '.', ',') }}</td>
                        <td align="center" colspan="1">{{ number_format($total_subtotal, 0, '.', ',') }}</td>
                @elseif(count($results) == 0)
                    <td colspan="13" class="border-2">
                        <label for="noresult" class="form-label">NO DATA RESULTS...</label>
                    </td>
                @endif
            </table>
        </center>
    </div>
</body>

</html>

<style type="text/css" media="print">
    @page {
        size: landscape;
        margin: 0px auto;
    }
</style>

<style type="text/css" media="print">
    @page {
        margin: 0px auto;
    }
</style>