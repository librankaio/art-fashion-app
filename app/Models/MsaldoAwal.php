<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsaldoAwal extends Model
{
    use HasFactory;

    protected $table='sldawaltoko';

    protected $fillable = [
        'tgl',
        'saldo',
        'counter',
    ];
}
