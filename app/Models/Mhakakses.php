<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mhakakses extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'nik',
        'counter',
        'feature',
        'save',
        'open',
        'updt',
        'dlt',
        'print',
    ];
}
