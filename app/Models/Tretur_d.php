<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tretur_d extends Model
{
    use HasFactory;

    protected $fillable = [
        'idh',
        'no_retur',
        'code',
        'warna',
        'name',
        'qty',
        'satuan',
    ];
}
