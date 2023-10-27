<?php  
  $filename = "Data Item.xls";
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");
  setlocale(LC_ALL,"US");
  //Setup localization
?>
<html>

<head>

    <title>Data Item</title>
</head>

<body class="idr" onload="window.print()">
    <div style="margin-left: 0%; margin-right: 0%;">
        <h5>Data Item</h5>

        <center>
            <table id="mytable" border="1px" cellspacing="0">
                <tr>
                    <th scope="col" class="border border-5" style="text-align: center;">No</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Kode / Artikel</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Nama</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Warna</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Kategori</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Price (Rp.)</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Size</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Satuan</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Material</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Harga Gross</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Harga Nett</th>
                    <th scope="col" class="border border-5" style="text-align: center;">Special Price</th>
                </tr>
                
                @if(count($results) > 0)
                    @php $counter = 0 @endphp
                    @foreach ($results as $key => $item)
                        @php $counter++ @endphp
                        <tr>
                            <th scope="row" class="border border-5">{{ $counter }}</th>
                            <td class="border border-5" style="text-align: center;">{{ $item->code }}</td>
                            <td class="border border-5" style="text-align: center;">{{ $item->name }}</td>
                            <td class="border border-5" style="text-align: center;">{{ $item->warna }}</td>
                            <td class="border border-5" style="text-align: center;">{{ $item->kategori }}</td>
                            <td class="border border-5" style="text-align: center;">{{ number_format($item->hrgjual, 2, '.', ',') }}</td>
                            <td class="border border-5" style="text-align: center;">{{ $item->size }}</td>
                            <td class="border border-5" style="text-align: center;">{{ $item->satuan }}</td>
                            <td class="border border-5" style="text-align: center;">{{ $item->material }}</td>
                            <td class="border border-5" style="text-align: center;">{{ number_format($item->gross, 2, '.', ',') }}</td>
                            <td class="border border-5" style="text-align: center;">{{ number_format($item->nett, 2, '.', ',') }}</td>
                            <td class="border border-5" style="text-align: center;">{{ number_format($item->spcprice, 2, '.', ',') }}</td>
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