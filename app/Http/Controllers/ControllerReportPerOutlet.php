<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportPerOutlet extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Report.rlapperoutlet',[
            'counters' => $counters,
        ]);
    }

    public function post(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');

        $results = DB::select('CALL vpendapatanoutlet (?,?,?)', [$dtfr, $dtto,$counter]);
        $counters = Mcounter::select('id','code','name')->get();

        return view('pages.Report.rlapperoutlet', [
            'results' => $results,
            'counters' => $counters,
        ]);
    }

    public function print(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');
        $payment_mthd = $request->input('payment_mthd');

        $results = DB::select('CALL vomsetperitem (?,?,?,?)', [$dtfr, $dtto, $counter, $payment_mthd]);
        $totqty = DB::select('SELECT sum(totalqty) as totalqty FROM vomsetperitem');
        $grandtot = DB::select('SELECT sum(subtotal) as grandtotal FROM vomsetperitem');
        $counters = Mcounter::select('id','code','name')->get();

        // dd($results);
        return view('pages.Print.Excel.rlapomsetexcl', compact('results','counter','dtfr', 'dtto',));
    }
}
