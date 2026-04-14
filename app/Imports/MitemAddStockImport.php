<?php

namespace App\Imports;

use App\Models\Mitem;
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
        // foreach ($rows as $row) 
        // {
        //     // $availcode = MitemCounterUpload::where('code', '=', $row['code'])->first();
        //     // if($availcode == null){
        //         // $date = \Carbon\Carbon::parse($row['tgl'])->toDateString();
        //         // $row['tgl'] = Date::excelToDateTimeObject($row['tgl'])->format('Y-m-d');
        //         $date = intval($row['tgl']);
        //         $date_format = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
        //         // $date = new DateTime($row['tgl']);
        //         // dd($date_format);
        //         // dd($date->format('d-m-Y'));
        //         $existing_code = Mitem::where('code','=','')->first();
        //         $mitem_counter_upload = MitemCounterUpload::create([  
        //             'tgl' => $date_format,
        //             'code_mitem' => $row['code_mitem'],
        //             'name_mitem' => $row['name_mitem'],
        //             'code_mcounter' => $row['code_mcounter'],
        //             'name_mcounter' => $row['name_mcounter'],
        //             'qty' => $row['qty'],
        //         ]);
        //     // }
        //     $qty = $row['qty'];
        //     $code_mitem = trim($row['code_mitem']);
        //     $code_mcounter = trim($row['code_mcounter']);
        //     // DB::select("select stock from mitems_counter where code_mitem = '$code_mitem' and code_mcounters = '$code_mcounter' liimit 1");
        //     DB::update( DB::raw("update mitems_counters set stock = stock + $qty where code_mitem = '$code_mitem' and code_mcounters = '$code_mcounter'"));
        // } 
        // return $mitem_counter_upload;
        $mitem_counter_upload = null;
        foreach ($rows as $row) 
        {
            // Bersihkan code_mitem: hilangkan spasi dan special character
            $code_mitem = preg_replace('/[^A-Za-z0-9]/', '', $row['code_mitem']);
            $code_mcounter = trim($row['code_mcounter']);
            $qty = (float)$row['qty'];

            // Format tanggal dari Excel
            $date = intval($row['tgl']);
            $date_format = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');

            // Cek apakah code_mitem sudah ada di tabel mitems
            $existing_code = Mitem::where('code', $code_mitem)->first();

            // Jika TIDAK ada di mitems → baru create
            if (!$existing_code) {
                $mitem_counter_upload = MitemCounterUpload::create([
                    'tgl'           => $date_format,
                    'code_mitem'    => $code_mitem,
                    'name_mitem'    => $row['name_mitem'],
                    'code_mcounter' => $code_mcounter,
                    'name_mcounter' => $row['name_mcounter'],
                    'qty'           => $qty,
                ]);
            }

            // Update stock mitems_counters
            DB::update(DB::raw("
                UPDATE mitems_counters 
                SET stock = stock + $qty 
                WHERE code_mitem = '$code_mitem' 
                AND code_mcounters = '$code_mcounter'
            "));
        }

        // return true;
        return $mitem_counter_upload;
    }
}
