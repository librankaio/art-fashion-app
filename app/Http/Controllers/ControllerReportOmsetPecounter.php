<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerReportOmsetPecounter extends Controller
{
    public function index()
    {
        return view('pages.Report.romsetcounter');
    }
}
