<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportStockCounter extends Controller
{
    public function index()
    {
        return view('pages.Report.rlapstockpercounter');
    }

    public function post(Request $request)
    {
        // dd($request->all());

        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');

        $results = DB::table('vomsetpercounter')->whereBetween('tgl', [$dtfr, $dtto])->where('counter','=',$counter)->paginate(100);
        $totqty = DB::select('SELECT sum(totalqty) as totalqty FROM vomsetpercounter where counter = ?', [$counter]);
        $grandtot = DB::select('SELECT sum(subtotal) as grandtotal FROM vomsetpercounter where counter = ?', [$counter]);
        $counters = Mcounter::select('id','code','name')->get();

        return view('pages.Report.rlapstockpercounter', [
            'results' => $results,
            'counters' => $counters,
            'totqty' => $totqty,
            'grandtot' => $grandtot,
        ]);
    }
}
