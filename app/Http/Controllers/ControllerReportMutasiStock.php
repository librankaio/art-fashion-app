<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportMutasiStock extends Controller
{
    public function index()
    {
        $mitems = Mitem::select('code','name')->get();
        return view('pages.Report.rmutasistock',[
            'mitems' => $mitems,
        ]);
    }

    public function post(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $artikel = $request->input('artikel');

        $results = DB::table('vmutasistock')->whereBetween('tgl', [$dtfr, $dtto])->where('code','=',$artikel)->get();
        $totqty = DB::select('SELECT sum(qty) as totalqty FROM vmutasistock where code = ?', [$artikel]);
        $mitems = Mitem::select('code','name')->get();

        return view('pages.Report.rmutasistock', [
            'results' => $results,
            'mitems' => $mitems,
            'totqty' => $totqty,
        ]);
    }
}
