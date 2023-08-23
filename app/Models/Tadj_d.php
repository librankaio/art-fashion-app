<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tadj_d extends Model
{
    use HasFactory;

    protected $fillable = [
        'idh',
        'no_adj',
        'code',
        'name',
        'warna',
        'qty',
        'satuan',
    ];
}
