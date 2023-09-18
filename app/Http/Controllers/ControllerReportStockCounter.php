<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerReportStockCounter extends Controller
{
    public function index()
    {
        return view('pages.Report.rlapstockpercounter');
    }
}
