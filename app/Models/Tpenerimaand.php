<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tpenerimaand extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "tpenerimaands";

    protected $fillable = [
        'idh',
        'no_tpenerimaanh',
        'code_mitem',
        'name_mitem',
        'qty',
        'code_muom',
        'price',
        'disc',
        'tax',
        'subtotal',
        'note',
    ];
}
