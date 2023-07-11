<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mmatauang extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $table = "mmatauangs";

    protected $fillable = [
        'code',
        'name',
    ];
}
