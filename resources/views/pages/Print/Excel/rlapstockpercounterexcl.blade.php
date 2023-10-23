<?php  
  $filename = "Laporan_Stock_PerCounter.xls";
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");
  setlocale(LC_ALL,"US");
  //Setup localization
?>
<html>

<head>

    <title>LAPORAN STOCK PER-COUNTER</title>
</head>

<body class="idr" onload="window.print()">
    <div style="margin-left: 0%; margin-right: 0%;">
        <h5>LAPORAN STOCK PER-COUNTER<br>
            {{ $counter }}<br>
        <center>
            <table id="mytable" border="1px" cellspacing="0">
                <tr>
                    <th scope="col" class="border border-5">No</th>
                    <th scope="col" class="border border-5">Kode Counter</th>
                    <th scope="col" class="border border-5">Nama Counter</th>
                    <th scope="col" class="border border-5">Code Item</th>
                    <th scope="col" class="border border-5">Nama Item</th>
                    <th scope="col" class="border border-5">Harga Jual</th>
                    <th scope="col" class="border border-5">Stock</th>
                </tr>
                
                @if(count($results) > 0)
                    @php $counter = 0 @endphp
                    @php $total_stock = 0; @endphp
                    @foreach ($results as $key => $item)
                    @php $counter++ @endphp
                    <tr>
                        <th scope="row" class="border border-5">{{ $counter }}</th>
                        <td class="border border-5" style="text-align: center;">{{ $item->code_mcounters }}</td>
                        <td class="border border-5" style="text-align: center;">{{ $item->name_mcounters }}</td>
                        <td class="border border-5" style="text-align: center;">{{ $item->code_mitem }}</td>
                        <td class="border border-5" style="text-align: center;">{{ $item->name_mitem }}</td>
                        <td class="border border-5" style="text-align: center;">{{ number_format($item->hrgjual, 2, '.', ',') }}</td>
                        <td class="border border-5" style="text-align: center;">{{ number_format($item->stock) }}</td>
                    </tr>
                    @if($total_stock == 0)
                        @php $total_stock = $total_stock + $item->stock @endphp
                    @else
                        @php $total_stock = $total_stock + $item->stock @endphp
                    @endif
                    @endforeach
                    <td align="center" colspan="5">Total Stock</td>
                    <td align="center" colspan="1">{{ $total_stock }}</td>    
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