<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mnamacabang extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "mnamacbgs";

    protected $fillable = [
        'code',
        'name',
        'address',
    ];
}
