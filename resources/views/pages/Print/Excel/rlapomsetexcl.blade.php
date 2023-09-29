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
                    <th scope="col" class="border border-5" style="text-align: center;">Tanggal</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Kode</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Nama Item</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Quantity</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Subtotal</th>
                </tr>
                
                @if(count($results) > 0)
                    @php $counter = 0 @endphp
                    @foreach ($results as $key => $item)
                    @php $counter++ @endphp
                    <tr>
                        <th scope="row" class="border border-5">{{ $counter }}</th>
                        <td class="border border-5" style="text-align: center;">{{ date("Y-m-d", strtotime($item->tgl)) }}</td>
                        <td class="border border-5" style="text-align: center;">{{ $item->code }}</td>
                        <td class="border border-5" style="text-align: center;">{{ $item->name }}</td>
                        <td class="border border-5" style="text-align: center;">{{ $item->qty }}</td>
                        <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotal, 2, '.', ',') }}</td>
                    </tr>
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