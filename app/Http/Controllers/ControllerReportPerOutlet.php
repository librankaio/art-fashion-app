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

        $results = DB::select('CALL vpendapatanoutlet (?,?,?)', [$dtfr, $dtto,$counter]);

        // dd($results);
        return view('pages.Print.rlapomseroutlet', compact('results','counter','dtfr', 'dtto',));
    }
}
