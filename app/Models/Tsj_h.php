<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tsj_h extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'tgl',
        'counter',
        'jenis',
        'no_sob',
        'note',
        'grdtotal',
        'user',
    ];
}
