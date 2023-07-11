<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Muom extends Model
{
    use SoftDeletes;
    // use HasFactory;

    protected $dates = ['deleted_at'];

    protected $table = "muoms";

    protected $fillable = [
        'code',
        'name',
    ];
}
