<?php

namespace App\Imports;

use App\Models\MitemCounters;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MitemCountersImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $mitem_counter = MitemCounters::where('code_mitem', $row['code'])
            ->where('code_mcounters', $row['kode_counter'])
            ->update([
                'stock' => $row['stock'],
            ]);
        }

        return $mitem_counter;
    }
}
