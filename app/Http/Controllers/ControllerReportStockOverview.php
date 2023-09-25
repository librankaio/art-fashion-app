<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportStockOverview extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Report.rstockoverview',[
            'counters' => $counters
        ]);
    }

    public function post(Request $request)
    {
        // dd($request->all());
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        // $datefrForm = Carbon::createFromFormat('d/m/Y', $dtfr)->format('Y-m-d');
        // $datetoForm = Carbon::createFromFormat('d/m/Y', $dtto)->format('Y-m-d');
        $counter = $request->input('counter');

        // $results = DB::table('vomsetpercounter')->whereBetween('tgl', [$dtfr, $dtto])->paginate(100);
        $results = DB::select('CALL prStockOverview (?,?,?)', [$dtfr, $dtto,$counter]);
        // $totqty = DB::select('SELECT sum(qty) as totalqty FROM vomsetpercounter');
        // $grandtot = DB::select('SELECT sum(subtotal) as grandtotal FROM vomsetpercounter');
        $counters = Mcounter::select('id','code','name')->get();
        // dd($results);

        return view('pages.Report.rstockoverview', [
            'results' => $results,
            'counters' => $counters,
            // 'totqty' => $totqty,
            // 'grandtot' => $grandtot,
        ]);
    }
}
