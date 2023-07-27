<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpenerimaan_h extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'no_sj',
        'counter',
        'tgl',
        'note',
        'jenis',
        'grdtotal',
        'user',
    ];
}
