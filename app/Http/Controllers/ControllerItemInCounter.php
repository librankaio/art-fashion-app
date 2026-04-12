<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerItemInCounter extends Controller
{
    public function index()
    {
        return view('pages.Report.ritemincounter');
    }

    public function search(Request $request)
    {
        $kode_item = $request->input('kode');
        
        if ($kode_item == '' || $kode_item == null) {
            $results = [];
        } else {
            $results = DB::table('vstockpercounter')
                ->where('code_mitem', '=', strtok($kode_item, " "))
                ->get();
        }

        return view('pages.Report.ritemincounter', [
            'results' => $results,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $kode_item = $request->input('kode');

        $results = DB::table('vstockpercounter')
            ->where('code_mitem', '=', strtok($kode_item, " "))
            ->get();

        return view('pages.Print.Excel.ritemincounterexcl', compact('results', 'kode_item'));
    }
}