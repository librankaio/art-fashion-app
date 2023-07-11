<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tjurnalvouchh extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "tjurnalvouchhs";
    
    protected $fillable = [
        'no',
        'tdt',
        'mata_uang',
        'keterangan',
        'cabang',
        'kurs',
        'total_debit',
        'total_credit',
        'balance',
    ];
}
