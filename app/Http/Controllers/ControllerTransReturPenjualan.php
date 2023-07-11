<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerTransReturPenjualan extends Controller
{
    public function index()
    {
        return view('pages.Transaksi.treturpenjualan');
    }
}
