<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tbayaropsh extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "tbayaropshs";

    protected $fillable = [
        'no',
        'tdt',
        'cabang',
        'mata_uang',
        'jenis',
        'noref',
        'kurs',
        'total',
        'grdtotal',
        'akun_pembayaran',
    ];
}
