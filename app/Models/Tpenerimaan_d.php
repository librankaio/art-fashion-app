<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpenerimaan_d extends Model
{
    use HasFactory;

    protected $fillable = [
        'idh',
        'no_penerimaan',
        'code',
        'name',
        'warna',
        'qty',
        'satuan',
        'hrgjual',
        'keterangan',
        'subtotal',
    ];
}
