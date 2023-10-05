<?php

namespace App\Imports;

use App\Models\Mitem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MitemsImport implements ToModel,withHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $mitem = new Mitem([
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
            "stock" => $row['stock'],
            "nett" => $row['nett'],
            "spcprice" => $row['spcprice'],
        ]);       

        return $mitem;
    }
}
