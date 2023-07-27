<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tadj_h extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'tgl',
        'note',
        'user',
    ];
}
