<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerTransSOB extends Controller
{
    public function index()
    {
        return view('pages.Transaksi.tsob');
    }
}
