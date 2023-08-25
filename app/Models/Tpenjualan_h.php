<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpenjualan_h extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'tgl',
        'counter',
        'jenis_promosi',
        'note',
        'diskon',
        'payment_mthd',
        'noreff',
        'grdtotal',
        'user',
    ];
}
