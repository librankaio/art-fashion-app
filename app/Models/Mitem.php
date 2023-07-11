<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mitem extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "mitems";
    
    protected $fillable = [
        'code',
        'name',
        'code_muom',
        'price',
        'price2',
        'code_mgrp',
        'code_mwhse',
        'img',
        'admin_id',
        'note',
    ];
}
