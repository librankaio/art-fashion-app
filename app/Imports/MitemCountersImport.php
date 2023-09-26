<?php

namespace App\Imports;

use App\Models\MitemCounters;
use Maatwebsite\Excel\Concerns\ToModel;

class MitemCountersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // return new MitemCounters([
        //     //
        // ]);
        $mitem = new MitemCounters([
            //
            "code" => $row['code'],
            "name" => $row['name'],
            "warna" => $row['warna'],
            "kategori" => $row['kategori'],
            "hrgjual" => $row['hrgjual'],
            "size" => $row['size'],
            "satuan" => $row['satuan'],
            "material" => $row['material'],
            "gross" => $row['gross'],
            "nett" => $row['nett'],
            "spcprice" => $row['spcprice'],
        ]);

        return $mitem;
    }
}
