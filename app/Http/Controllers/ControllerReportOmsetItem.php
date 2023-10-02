<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportOmsetItem extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Report.rlapomset',[
            'counters' => $counters,
        ]);
    }

    public function post(Request $request)
    {
        // dd($request->all());

        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');

        // $results = DB::table('vomsetperitem')->whereBetween('tgl', [$dtfr, $dtto])->where('counter','=',$counter)->paginate(100);
        $results = DB::select('CALL vomsetperitem (?,?,?)', [$dtfr, $dtto, $counter]);
        $totqty = DB::select('SELECT sum(totalqty) as totalqty FROM vomsetperitem');
        $grandtot = DB::select('SELECT sum(subtotal) as grandtotal FROM vomsetperitem');
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Report.rlapomset', [
            'results' => $results,
            'counters' => $counters,
            'totqty' => $totqty,
            'grandtot' => $grandtot,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');

        $results = DB::select('CALL vomsetperitem (?,?,?)', [$dtfr, $dtto, $counter]);
        $totqty = DB::select('SELECT sum(totalqty) as totalqty FROM vomsetperitem');
        $grandtot = DB::select('SELECT sum(subtotal) as grandtotal FROM vomsetperitem');
        $counters = Mcounter::select('id','code','name')->get();

        // dd($results);
        return view('pages.Print.Excel.rlapomsetexcl', compact('results','counter','dtfr', 'dtto',));
    }
}
