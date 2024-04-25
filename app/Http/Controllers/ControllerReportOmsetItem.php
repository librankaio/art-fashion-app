<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mjenispayment;
use App\Models\Tpenjualan_h;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportOmsetItem extends Controller
{
    public function index()
    {
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        // $counters = Mcounter::select('id','code','name')->get();
        $payments = Mjenispayment::select('id','code','name')->get();
        $tpenjualans = Tpenjualan_h::select('id','no')->get();
        return view('pages.Report.rlapomset',[
            'counters' => $counters,
            'payments' => $payments,
            'tpenjualans' => $tpenjualans,
        ]);
    }

    public function post(Request $request)
    {
        // dd($request->all());

        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');
        $payment_mthd = $request->input('payment_mthd');

        // $results = DB::table('vomsetperitem')->whereBetween('tgl', [$dtfr, $dtto])->where('counter','=',$counter)->paginate(100);
        $results = DB::select('CALL vomsetperitem (?,?,?,?)', [$dtfr, $dtto, $counter, $payment_mthd]);
        // dd($results);
        // $totqty = DB::select('SELECT sum(totalqty) as totalqty FROM vomsetperitem');
        // $grandtot = DB::select('SELECT sum(subtotal) as grandtotal FROM vomsetperitem');
        // $counters = Mcounter::select('id','code','name')->get();
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        $payments = Mjenispayment::select('id','code','name')->get();
        $tpenjualans = Tpenjualan_h::select('id','no')->get();
        return view('pages.Report.rlapomset', [
            'results' => $results,
            'counters' => $counters,
            // 'totqty' => $totqty,
            // 'grandtot' => $grandtot,
            'payments' => $payments,
            'tpenjualans' => $tpenjualans,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');
        $payment_mthd = $request->input('payment_mthd');

        $results = DB::select('CALL vomsetperitem (?,?,?,?)', [$dtfr, $dtto, $counter, $payment_mthd]);
        // $totqty = DB::select('SELECT sum(totalqty) as totalqty FROM vomsetperitem');
        // $grandtot = DB::select('SELECT sum(subtotal) as grandtotal FROM vomsetperitem');
        $counters = Mcounter::select('id','code','name')->get();

        // dd($results);
        return view('pages.Print.Excel.rlapomsetexcl', compact('results','counter','dtfr', 'dtto',));
    }
}
