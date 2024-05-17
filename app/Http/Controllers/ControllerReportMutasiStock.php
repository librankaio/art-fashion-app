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
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Report.rmutasistock',[
            'mitems' => $mitems,
            'counters' => $counters,
        ]);
    }

    public function post(Request $request)
    {
        // dd($request->all());
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $artikel = $request->input('artikel');
        $counter = $request->input('counter');

        $results = DB::select('CALL rptstockdetail (?,?,?,?)', [$artikel, $dtfr, $dtto, $counter]);
        // $results = DB::table('vmutasistock')->whereBetween('tgl', [$dtfr, $dtto])->where('code','=',$artikel)->get();
        $totqty = DB::select('SELECT sum(qty) as totalqty FROM vmutasistock where code = ?', [$artikel]);
        $mitems = Mitem::select('code','name')->get();
        $counters = Mcounter::select('id','code','name')->get();

        dd($results);
        return view('pages.Report.rmutasistock', [
            'results' => $results,
            'mitems' => $mitems,
            'totqty' => $totqty,
            'counters' => $counters,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $artikel = $request->input('artikel');

        $results = DB::table('vmutasistock')->whereBetween('tgl', [$dtfr, $dtto])->where('code','=',$artikel)->get();
        $totqty = DB::select('SELECT sum(qty) as totalqty FROM vmutasistock where code = ?', [$artikel]);
        $mitems = Mitem::select('code','name')->get();

        return view('pages.Print.Excel.rmutasistockexcl', compact('results','dtfr','dtto','artikel','totqty'));
    }
}
