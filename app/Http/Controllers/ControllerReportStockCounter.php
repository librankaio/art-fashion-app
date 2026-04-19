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
        $search = $request->input('search');

        $query = DB::table('vstockpercounter');

        if ($counter) {
            $query->where('name_mcounters','=',$counter);
        }

        if ($kode_item != ''){
            $query->where('code_mitem','=',strtok($kode_item, " "));
        }

        if ($search) {
            $query->where('code_mitem', 'like', '%'.$search.'%');
        }

        $results = $query->paginate(50);

        $total_stock_query = DB::table('vstockpercounter');

        if ($counter) {
            $total_stock_query->where('name_mcounters','=',$counter);
        }

        if ($kode_item != ''){
            $total_stock_query->where('code_mitem','=',strtok($kode_item, " "));
        }

        if ($search) {
            $total_stock_query->where('code_mitem', 'like', '%'.$search.'%');
        }

        $total_stock = $total_stock_query->sum('stock');

        $results->appends(request()->query());

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
        $kode_item = $request->input('kode');
        $search = $request->input('search');

        $query = DB::table('vstockpercounter');

        if ($counter) {
            $query->where('name_mcounters','=',$counter);
        }

        if ($kode_item != ''){
            $query->where('code_mitem','=',strtok($kode_item, " "));
        }

        if ($search) {
            $query->where('code_mitem', 'like', '%'.$search.'%');
        }

        $results = $query->get();

        // dd($results);
        return view('pages.Print.Excel.rlapstockpercounterexcl', compact('results','counter'));
    }
}
