<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerLaporanOverviewTrans extends Controller
{
    public function index()
    {
        $privilage = session('privilage');
        if ($privilage == 'ADM') {
            $counters = Mcounter::select('id', 'code', 'name')->get();
        } else {
            $counters = Mcounter::select('id', 'code', 'name')->where('name', '=', session('counter'))->get();
        }

        return view('pages.Report.rtranspercounter', [
            'counters' => $counters,
        ]);
    }

    public function search(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');

        $privilage = session('privilage');
        if ($privilage == 'ADM') {
            $counters = Mcounter::select('id', 'code', 'name')->get();
        } else {
            $counters = Mcounter::select('id', 'code', 'name')->where('name', '=', session('counter'))->get();
        }

        if ($counter == 'SEMUA' || $counter == '') {
            $results = DB::table('vtransactions')
                ->whereBetween('tgl', [$dtfr, $dtto])
                ->get();
        } else {
            $results = DB::table('vtransactions')
                ->whereBetween('tgl', [$dtfr, $dtto])
                ->where('counter', '=', $counter)
                ->get();
        }

        return view('pages.Report.rtranspercounter', [
            'results' => $results,
            'counters' => $counters,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');

        if ($counter == 'SEMUA' || $counter == '') {
            $results = DB::table('vtransactions')
                ->whereBetween('tgl', [$dtfr, $dtto])
                ->get();
        } else {
            $results = DB::table('vtransactions')
                ->whereBetween('tgl', [$dtfr, $dtto])
                ->where('counter', '=', $counter)
                ->get();
        }

        return view('pages.Print.Excel.rtranspercounterexcl', compact('results', 'counter', 'dtfr', 'dtto'));
    }
}