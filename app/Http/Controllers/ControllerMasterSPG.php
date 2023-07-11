<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerMasterSPG extends Controller
{
    public function index()
    {
        return view('pages.Master.mdataspg');
    }
}
