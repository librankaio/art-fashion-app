<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerTransPembelianBarang extends Controller
{
    public function index()
    {
        return view('pages.Transaksi.tpembelianbarang');
    }
}
