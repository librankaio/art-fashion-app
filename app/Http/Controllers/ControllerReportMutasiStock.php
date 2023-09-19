<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportMutasiStock extends Controller
{
    public function index()
    {
        return view('pages.Report.rmutasistock');
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

        return view('pages.Report.rmutasistock', [
            'results' => $results,
            'counters' => $counters,
            'totqty' => $totqty,
            'grandtot' => $grandtot,
        ]);
    }
}
