<?php

namespace App\Imports;

use App\Models\Mitem;
use App\Services\StockCounterService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class MitemsImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            // Normalisasi kode memakai aturan yang sama dengan seluruh aplikasi.
            // Dulu semua spasi dibuang, sementara controller transaksi memotong
            // di spasi pertama, jadi kedua sisi tidak pernah cocok.
            $code = StockCounterService::normalizeCode($row['code'] ?? null);
            if($code === ''){
                continue;
            }
            $availcode = Mitem::where('code', '=', $code)->first();
            // dd($row);
            if($availcode == null){
                $mitem = Mitem::create([
                    'code' => $code,
                    'name' => $row['name'],
                    'warna' => $row['warna'],
                    'kategori' => $row['kategori'],
                    'hrgjual' => $row['hrgjual'],
                    'size' => $row['size'],
                    'satuan' => $row['satuan'],
                    'material' => $row['material'],
                    'gross' => $row['gross'],
                    'nett' => $row['nett'],
                    'spcprice' => $row['spcprice'],
                    'name_lbl' => $row['name_lbl'],
                ]);
                // Nilai di-bind. Nama item yang mengandung apostrof dulu membuat
                // query ini syntax error dan seeding counter gagal diam-diam.
                DB::insert(
                    "INSERT INTO mitems_counters (code_mitem, name_mitem, code_mcounters, name_mcounters, stock)
                     SELECT ?, ?, code, name, 0 FROM mcounters",
                    [$code, $row['name']]
                );
            }
        }
        // return $mitem;
    }
}

// class MitemsImport implements ToModel,withHeadingRow
// {
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     public function model(array $row)
//     {
//         $mitem = new Mitem([
//             //
//             "code" => $row['code'],
//             "name" => $row['name'],
//             "warna" => $row['warna'],
//             "kategori" => $row['kategori'],
//             "hrgjual" => $row['hrgjual'],
//             "size" => $row['size'],
//             "satuan" => $row['satuan'],
//             "material" => $row['material'],
//             "gross" => $row['gross'],
//             "stock" => $row['stock'],
//             "nett" => $row['nett'],
//             "spcprice" => $row['spcprice'],
//         ]);       

//         return $mitem;
//     }
// }
