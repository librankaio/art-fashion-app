<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerTransBonPenjualan extends Controller
{
    public function index()
    {
        return view('pages.Transaksi.tbonpenjualan');
    }
}
