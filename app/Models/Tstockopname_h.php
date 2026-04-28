<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tstockopname_h extends Model
{
    use HasFactory;

    protected $table = 'tstockopname_h';

    protected $fillable = [
        'notrans',
        'tanggal',
        'counter',
        'note',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(Tstockopname_d::class, 'idh');
    }
}