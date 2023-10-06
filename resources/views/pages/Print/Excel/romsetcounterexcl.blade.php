<?php  
  $filename = "Laporan_Omset_PerCounter.xls";
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");
  setlocale(LC_ALL,"US");
  //Setup localization
?>
<html>

<head>

    <title>LAPORAN OMSET PER-Counter</title>
</head>

<body class="idr" onload="window.print()">
    <div style="margin-left: 0%; margin-right: 0%;">
        <h5>LAPORAN OMSET PER-Counter<br>
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
                    <th scope="col" class="border border-5" style="text-align: center;">Nama Counter</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Total Quantity</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Total Nominal</th>
                </tr>
                
                @if(count($results) > 0)
                    @php $counter = 0 @endphp
                    @php $total_subtotal = 0; @endphp
                    @php $total_qty = 0; @endphp
                    @foreach ($results as $key => $item)
                    @php $counter++ @endphp
                    <tr>
                        <th scope="row" class="border border-5">{{ $counter }}</th>
                        <td class="border border-5" style="text-align: center;">{{ $item->counter }}</td>
                        <td class="border border-5" style="text-align: center;">{{ $item->qty }}</td>
                        <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotal, 2, '.', ',') }}</td>
                    </tr>
                    @if($total_subtotal == 0)
                        @php $total_subtotal = $total_subtotal + $item->subtotal @endphp
                    @else
                        @php $total_subtotal = $total_subtotal + $item->subtotal @endphp
                    @endif
                    @if($total_qty == 0)
                        @php $total_qty = $total_qty + $item->qty @endphp
                    @else
                        @php $total_qty = $total_qty + $item->qty @endphp
                    @endif
                    @endforeach
                    <td align="center" colspan="2"></td>
                    <td align="center" colspan="1">{{ $total_qty }}</td>
                    <td align="center" colspan="1">{{ number_format($total_subtotal, 2, '.', ',') }}</td>
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