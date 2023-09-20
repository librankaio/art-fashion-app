<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitemCounters extends Model
{
    use HasFactory;

    protected $table='mitems_counters';

    protected $fillable = [
        'id',
        'code_mitem',
        'name_mitem',
        'code_mcounters',
        'name_mcounters',
        'stock',
        'datein',
    ];
}
