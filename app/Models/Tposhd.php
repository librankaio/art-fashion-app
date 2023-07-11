<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tposhd extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "tposhds";

    protected $fillable = [
        'idh',
        'no_tposh',
        'code_mitem',
        'qty',
        'name_mitem',
        'code_muom',
        'price',
        'disc',
        'tax',
        'subtotal',
        'note',
    ];
}
