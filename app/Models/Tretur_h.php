<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tretur_h extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'counter_from',
        'counter',
        'tgl',
        'note',
        'user',
    ];
}
