<?php
$filename = 'Laporan_Stock_Minus.xls';
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Content-Type: application/vnd.ms-excel');
setlocale(LC_ALL, 'US');
//Setup localization
?>
<html>

<head>

    <title>LAPORAN STOCK MINUS</title>
</head>

<body class="idr" onload="window.print()">
    <div style="margin-left: 0%; margin-right: 0%;">
        <h5>LAPORAN STOCK MINUS<br>
            {{ $counter }}<br>
            <center>
                <table id="mytable" border="1px" cellspacing="0">
                    <tr>
                        <th scope="col" class="border border-5">No</th>
                        <th scope="col" class="border border-5">Kode Artikel</th>
                        <th scope="col" class="border border-5">Nama Artikel</th>
                        <th scope="col" class="border border-5">Counter</th>
                        <th scope="col" class="border border-5">Qty</th>
                    </tr>

                    @if (count($results) > 0)
                        @php $counter = 0 @endphp
                        @php $total_qty = 0; @endphp
                        @foreach ($results as $key => $item)
                            @php $counter++ @endphp
                            <tr>
                                <th scope="row" class="border border-5">{{ $counter }}</th>
                                <td class="border border-5" style="text-align: center;">{{ $item->code_mitem }}</td>
                                <td class="border border-5" style="text-align: center;">{{ $item->name_mitem }}</td>
                                <td class="border border-5" style="text-align: center;">{{ $item->name_mcounters }}</td>
                                <td class="border border-5" style="text-align: center;">
                                    {{ number_format($item->stock) }}</td>
                            </tr>
                            @if ($total_qty == 0)
                                @php $total_qty = $total_qty + $item->stock @endphp
                            @else
                                @php $total_qty = $total_qty + $item->stock @endphp
                            @endif
                        @endforeach
                        <td align="center" colspan="4">Total Qty</td>
                        <td align="center" colspan="1">{{ $total_qty }}</td>
                    @elseif(count($results) == 0)
                        <td colspan="5" class="border-2">
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
