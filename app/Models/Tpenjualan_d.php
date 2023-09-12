<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpenjualan_d extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'idh',
        'no_penjualan',
        'code',
        'name',
        'warna',
        'qty',
        'satuan',
        'hrgjual',
        'diskon',
        'subtotal',
        'disctot',
        'note',
    ];
}
