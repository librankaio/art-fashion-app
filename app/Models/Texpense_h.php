<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Texpense_h extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl',
        'note',
        'total',
    ];
}
