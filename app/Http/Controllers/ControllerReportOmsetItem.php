<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerReportOmsetItem extends Controller
{
    public function index()
    {
        return view('pages.Report.rlapomset');
    }
}
