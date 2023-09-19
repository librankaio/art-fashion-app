<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportOmsetPecounter extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Report.romsetcounter',[
            'counters' => $counters,
        ]);
    }

    public function post(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');

        $results = DB::table('vomsetpercounter')->whereBetween('tgl', [$dtfr, $dtto])->where('counter','=',$counter)->paginate(100);
        $totqty = DB::select('SELECT sum(qty) as totalqty FROM vomsetpercounter where counter = ?', [$counter]);
        $grandtot = DB::select('SELECT sum(subtotal) as grandtotal FROM vomsetpercounter where counter = ?', [$counter]);
        $counters = Mcounter::select('id','code','name')->get();
        // dd($results);

        return view('pages.Report.romsetcounter', [
            'results' => $results,
            'counters' => $counters,
            'totqty' => $totqty,
            'grandtot' => $grandtot,
        ]);
    }
}
