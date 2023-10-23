<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportPerOutlet extends Controller
{
    public function index()
    {
        // $counters = Mcounter::select('id','code','name')->get();
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        return view('pages.Report.rlapperoutlet',[
            'counters' => $counters,
        ]);
    }

    public function post(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');

        $results = DB::select('CALL vpendapatanoutlet (?,?,?)', [$dtfr, $dtto,$counter]);
        // $counters = Mcounter::select('id','code','name')->get(); 
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        $saldo_awals = DB::select('select saldo from sldawaltoko where tgl = ?', [$dtfr]);
        $biayas = DB::select('select sum(total) as total from texpense_hs where tgl BETWEEN ? AND ?', [$dtfr,$dtto]);       

        return view('pages.Report.rlapperoutlet', [
            'results' => $results,
            'counters' => $counters,            
        ]);
    }

    public function print(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');

        $results = DB::select('CALL vpendapatanoutlet (?,?,?)', [$dtfr, $dtto,$counter]);
        $saldo_awals = DB::select('select saldo from sldawaltoko where tgl = ?', [$dtfr]);
        $biayas = DB::select('select sum(total) as total from texpense_hs where tgl BETWEEN ? AND ?', [$dtfr,$dtto]);

        // dd($saldo_awals);
        return view('pages.Print.rlapomseroutlet', compact('results','counter','dtfr', 'dtto','saldo_awals', 'biayas'));
    }
}
