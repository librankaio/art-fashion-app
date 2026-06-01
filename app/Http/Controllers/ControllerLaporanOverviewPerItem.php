<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerLaporanOverviewPerItem extends Controller
{
    public function index()
    {
        return view('pages.Report.roverviewperitem');
    }

    public function search(Request $request)
    {
        $dtfr     = $request->input('dtfr');
        $dtto     = $request->input('dtto');
        $kategori = $request->input('kategori');

        $query = DB::table('vtransactionitems as v')
            ->join('mitems as mi', 'v.code', '=', 'mi.code')
            ->select('v.*', 'mi.kategori')
            ->whereBetween('v.tgl', [$dtfr, $dtto]);

        if (!empty($kategori)) {
            $query->where('mi.kategori', 'like', '%' . $kategori . '%');
        }

        $results = $query->orderBy('v.tgl', 'desc')->get();

        return view('pages.Report.roverviewperitem', [
            'results'  => $results,
            'dtfr'     => $dtfr,
            'dtto'     => $dtto,
            'kategori' => $kategori,
        ]);
    }
}
