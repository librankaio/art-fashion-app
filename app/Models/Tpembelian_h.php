<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpembelian_h extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'tgl',
        'supplier',
        'note',
        'grdtotal',
        'user',
    ];
}
