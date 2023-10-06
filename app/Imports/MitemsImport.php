<?php

namespace App\Imports;

use App\Models\Mitem;
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
            $mitem = Mitem::create([  
                'name' => $row['name'],
                'code' => $row['code'],
                'warna' => $row['warna'],
                'kategori' => $row['kategori'],
                'hrgjual' => $row['hrgjual'],
                'size' => $row['size'],
                'satuan' => $row['satuan'],
                'material' => $row['material'],
                'gross' => $row['gross'],
                'stock' => $row['stock'],
                'nett' => $row['nett'],
                'spcprice' => $row['spcprice'],
            ]);
            $code = $row['code'];
            $name = $row['name'];
            DB::insert( DB::raw("insert into mitems_counters (code_mitem, name_mitem, code_mcounters, name_mcounters, stock)
            select '$code', '$name', code, name, 0 FROM mcounters"));
        }

        return $mitem;
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
