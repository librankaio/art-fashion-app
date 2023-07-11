<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerReportStockOverview extends Controller
{
    public function index()
    {
        return view('pages.Report.rstockoverview');
    }
}
