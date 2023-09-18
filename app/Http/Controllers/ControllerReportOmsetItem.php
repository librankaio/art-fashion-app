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
        $datefrForm = Carbon::createFromFormat('d/m/Y', $dtfr)->format('Y-m-d');
        $datetoForm = Carbon::createFromFormat('d/m/Y', $dtto)->format('Y-m-d');

        $results = DB::table('vomsetperitem')->whereBetween('tgl', [$datefrForm, $datetoForm])->paginate(10);
        dd($results);
        return view('pages.Report.rlapomset', [
            'results' => $results
        ]);
    }
}
