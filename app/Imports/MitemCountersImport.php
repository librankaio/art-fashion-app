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
        $mitem_counter = new MitemCounters([
            "code_mitem" => $row['code_mitem'],
            "name_mitem" => $row['name_mitem'],
            "code_mcounters" => $row['code_mcounters'],
            "name_mcounters" => $row['name_mcounters'],
            "stock" => $row['stock'],
            "datein" => $row['datein'],
        ]);

        return $mitem_counter;
    }
}
