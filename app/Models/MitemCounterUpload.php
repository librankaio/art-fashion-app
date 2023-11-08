<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitemCounterUpload extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'tgl',
        'code_mitem',
        'name_mitem',
        'code_mcounter',
        'name_mcounter',
        'qty',
    ];
}
