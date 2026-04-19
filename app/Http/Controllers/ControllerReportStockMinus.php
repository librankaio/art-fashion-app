<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportStockMinus extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Report.rlapstockminus',[
            'counters' => $counters,
        ]);
    }

    public function post(Request $request)
    {
        $counter = $request->input('counter');
        $search = $request->input('search');

        $query = DB::table('mitems_counters')
            ->select('code_mitem', 'name_mitem', 'name_mcounters', 'stock')
            ->where('name_mcounters','=',$counter)
            ->where('stock','<',0);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('code_mitem', 'like', '%'.$search.'%')
                  ->orWhere('name_mitem', 'like', '%'.$search.'%');
            });
        }

        $results = $query->paginate(50);

        $results->appends(request()->query());

        $total_qty_query = DB::table('mitems_counters')
            ->where('name_mcounters','=',$counter)
            ->where('stock','<',0);

        if ($search) {
            $total_qty_query->where(function($q) use ($search) {
                $q->where('code_mitem', 'like', '%'.$search.'%')
                  ->orWhere('name_mitem', 'like', '%'.$search.'%');
            });
        }

        $total_qty = $total_qty_query->sum('stock');

        $counters = Mcounter::select('id','code','name')->get();

        return view('pages.Report.rlapstockminus', [
            'results' => $results,
            'counters' => $counters,
            'total_qty' => $total_qty,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $counter = $request->input('counter');
        $search = $request->input('search');

        $query = DB::table('mitems_counters')
            ->select('code_mitem', 'name_mitem', 'name_mcounters', 'stock')
            ->where('name_mcounters','=',$counter)
            ->where('stock','<',0);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('code_mitem', 'like', '%'.$search.'%')
                  ->orWhere('name_mitem', 'like', '%'.$search.'%');
            });
        }

        $results = $query->get();

        return view('pages.Print.Excel.rlapstockminusexcl', compact('results','counter'));
    }
}