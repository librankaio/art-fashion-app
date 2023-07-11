<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerMasterDataLokasi extends Controller
{
    public function index()
    {
        return view('pages.Master.mdatalokasi');
    }
}
