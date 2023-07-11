<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tpembelianh extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "tpembelianhs";

    protected $fillable = [
        'no',
        'tdt',
        'cabang',
        'supplier',
        'mata_uang',
        'nolain',
        'subtotal',
        'kurs',
        'disc',
        'tax',
        'grdtotal',
        'note',
    ];
}
