<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tsj_d extends Model
{
    use HasFactory;

    protected $fillable = [
        'idh',
        'no_sj',
        'code',
        'name',
        'warna',
        'qty',
        'satuan',
        'hrgjual',
        'subtotal',
    ];
}
