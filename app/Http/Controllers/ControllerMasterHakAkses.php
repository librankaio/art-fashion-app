<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerMasterHakAkses extends Controller
{
    public function index()
    {
        return view('pages.Master.mdatahakses');
    }
}
