<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tjurnalvouchd extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "tjurnalvouchds";
    
    protected $fillable = [
        'idh',
        'no_tjurnalvouchh',
        'kode',
        'nama',
        'debit',
        'credit',
        'memo',
    ];
}
