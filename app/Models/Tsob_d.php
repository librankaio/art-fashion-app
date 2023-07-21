<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tsob_d extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_sob',
        'code',
        'name',
        'qty',
        'satuan',
        'hrgjual',
        'subtotal',
    ];
}
