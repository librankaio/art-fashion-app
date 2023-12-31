<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpembelian_d extends Model
{
    use HasFactory;

    protected $fillable = [
        'idh',
        'no_pembelian',
        'code',
        'name',
        'warna',
        'qty',
        'satuan',
        'hrgbeli',
        'hrgjual',
        'subtotal',
    ];
}
