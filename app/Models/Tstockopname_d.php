<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tstockopname_d extends Model
{
    use HasFactory;

    protected $table = 'tstockopname_d';

    protected $fillable = [
        'idh',
        'no_opname',
        'no',
        'kode_barang',
        'nama_barang',
        'stock',
        'harga',
        'hasil_opname',
        'adjustment',
    ];

    public function header()
    {
        return $this->belongsTo(Tstockopname_h::class, 'idh');
    }
}