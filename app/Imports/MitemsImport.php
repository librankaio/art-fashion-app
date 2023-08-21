<?php

namespace App\Imports;

use App\Models\Mitem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MitemsImport implements ToModel
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
            "code" => $row['first_name'],
            "name" => $row['last_name'],
            "warna" => $row['email'],
            "kategori" => $row['mobile_number'],
            "hrgjual" => 2, // User Type User
            "size" => 1,
            "satuan" => 1,
            "material" => 1,
            "gross" => 1,
            "nett" => 1,
            "spcprice" => 1,
        ]);

        return $mitem;
    }
}
