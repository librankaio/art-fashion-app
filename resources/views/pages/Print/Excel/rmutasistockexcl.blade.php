<?php  
  $filename = "Laporan_Mutasi_Stock.xls";
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");
  setlocale(LC_ALL,"US");
  //Setup localization
?>
<html>

<head>

    <title>LAPORAN MUTASI STOCK</title>
</head>

<body class="idr" onload="window.print()">
    <div style="margin-left: 0%; margin-right: 0%;">
        <h5>LAPORAN MUTASI STOCK<br>
            Artikel : {{ $artikel }}<br>
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
                    <th scope="col" class="border border-5">Jenis Transaksi</th>
                    <th scope="col" class="border border-5">No Transaksi</th>
                    <th scope="col" class="border border-5">Tanggal</th>
                    <th scope="col" class="border border-5">Counter</th>
                    <th scope="col" class="border border-5">Quantity</th>
                </tr>
                
                @if(count($results) > 0)
                    @php $counter = 0 @endphp
                    @foreach ($results as $key => $item)
                    @php $counter++ @endphp
                    <tr>
                        <th scope="row" class="border border-5">{{ $item->JenisTransaksi }}</th>
                        <td class="border border-5" style="text-align: center;">{{ $item->no }}</td>
                        <td class="border border-5" style="text-align: center;">{{ date("Y-m-d", strtotime($item->tgl)) }}</td>
                        <td class="border border-5" style="text-align: center;">{{ $item->counter }}</td>
                        <td class="border border-5" style="text-align: center;">{{ number_format($item->qty) }}</td>
                    </tr>
                    @endforeach
                    <td align="center" colspan="3" class="border-dotted"></td>
                    <td align="center" class="border-dotted">Total Quantity</td>
                    @foreach($totqty as $itemqty)
                        <td align="center">{{ $itemqty->totalqty }}</td>
                    @endforeach
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