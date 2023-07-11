<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerTransSuratJalan extends Controller
{
    public function index()
    {
        return view('pages.Transaksi.tsuratjalan');
    }
}
