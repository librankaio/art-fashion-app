<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerLaporanExpense extends Controller
{
    public function index()
    {
        $privilage = session('privilage');
        if ($privilage == 'ADM') {
            $counters = Mcounter::select('id', 'code', 'name')->get();
        } else {
            $counters = Mcounter::select('id', 'code', 'name')->where('name', '=', session('counter'))->get();
        }

        return view('pages.Report.rlapexpense', [
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
            $results = DB::table('vwexpense')
                ->whereBetween('expense_date', [$dtfr, $dtto])
                ->get();
        } else {
            $results = DB::table('vwexpense')
                ->whereBetween('expense_date', [$dtfr, $dtto])
                ->where('counter', '=', $counter)
                ->get();
        }

        $grandTotal = $results->sum('total');

        return view('pages.Report.rlapexpense', [
            'results'    => $results,
            'grandTotal' => $grandTotal,
            'counters'   => $counters,
        ]);
    }
}
