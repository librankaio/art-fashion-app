<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiAF extends Model
{
    use HasFactory;

    protected $table='mutasiaf';
    protected $fillable = [
        'code_mitem',
        'code_mcounters',
        'qty',
        'notrans',
        'tgl',
        'doctype',
        'jenis',
        'action',
        'user',
    ];
}
