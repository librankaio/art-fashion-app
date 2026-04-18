<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportStockCounter extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Report.rlapstockpercounter',[
            'counters' => $counters,
        ]);
    }

    public function post(Request $request)
    {
        $counter = $request->input('counter');
        $kode_item = $request->input('kode');
        // dd(strtok($kode_item, " "));
        if ($kode_item == ''){
            $results = DB::table('vstockpercounter')->where('name_mcounters','=',$counter)->paginate(50);
            $total_stock = DB::table('vstockpercounter')
            ->where('name_mcounters','=',$counter)
            ->sum('stock'); // ganti 'stock' sesuai field kamu
        }else{
            $results = DB::table('vstockpercounter')->where('name_mcounters','=',$counter)->where('code_mitem','=',strtok($kode_item, " "))->paginate(50);
            $total_stock = DB::table('vstockpercounter')
            ->where('name_mcounters','=',$counter)
            ->where('code_mitem','=',strtok($kode_item, " "))
            ->sum('stock'); // ganti 'stock' sesuai field kamu
        }
        $counters = Mcounter::select('id','code','name')->get();

        return view('pages.Report.rlapstockpercounter', [
            'results' => $results,
            'counters' => $counters,
            'total_stock' => $total_stock,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $counter = $request->input('counter');

        $results = DB::table('vstockpercounter')->where('name_mcounters','=',$counter)->get();

        // dd($results);
        return view('pages.Print.Excel.rlapstockpercounterexcl', compact('results','counter'));
    }
}
