<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitem extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'name_lbl',
        'warna',
        'kategori',
        'hrgjual',
        'size',
        'satuan',
        'material',
        'gross',
        'stock',
        'nett',
        'spcprice',
    ];
}
