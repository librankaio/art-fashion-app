<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tpenerimaanh extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "tpenerimaanhs";

    protected $fillable = [
        'no',
        'no_tpembelian',
        'tdt',
        'cabang',
        'supplier',
        'mata_uang',
        'nolain',
        'kurs',
        'subtotal',
        'disc',
        'tax',
        'grdtotal',
        'note',
    ];
}
