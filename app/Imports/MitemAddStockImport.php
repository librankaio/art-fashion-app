<?php

namespace App\Imports;

use App\Models\MitemCounterUpload;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MitemAddStockImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row) 
        {
            // $availcode = MitemCounterUpload::where('code', '=', $row['code'])->first();
            // if($availcode == null){
                // $date = \Carbon\Carbon::parse($row['tgl'])->toDateString();
                // $row['tgl'] = Date::excelToDateTimeObject($row['tgl'])->format('Y-m-d');
                $date = intval($row['tgl']);
                $date_format = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
                // $date = new DateTime($row['tgl']);
                // dd($date_format);
                // dd($date->format('d-m-Y'));
                $mitem_counter_upload = MitemCounterUpload::create([  
                    'tgl' => $date_format,
                    'code_mitem' => $row['code_mitem'],
                    'name_mitem' => $row['name_mitem'],
                    'code_mcounter' => $row['code_mcounter'],
                    'name_mcounter' => $row['name_mcounter'],
                    'qty' => $row['qty'],
                ]);
            // }
            $qty = $row['qty'];
            $code_mitem = $row['code_mitem'];
            $code_mcounter = $row['code_mcounter'];
            // DB::select("select stock from mitems_counter where code_mitem = '$code_mitem' and code_mcounters = '$code_mcounter' liimit 1");
            DB::update( DB::raw("update mitems_counters set stock = stock + $qty where code_mitem = '$code_mitem' and code_mcounters = '$code_mcounter'"));
        } 
        return $mitem_counter_upload;
    }
}
