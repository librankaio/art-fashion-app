<?php

namespace App\Http\Controllers;

use App\Models\MsaldoAwal;
use Illuminate\Http\Request;

class ControllerMasterSaldoAwal extends Controller
{
    public function index()
    {
        $datas = MsaldoAwal::select('id','tgl','saldo','counter')->where('counter','=',session('counter'))->get();
        return view('pages.Master.msaldoawal',[
            'datas' => $datas,
        ]);
    }
    public function modal()
    {
        $datas = MsaldoAwal::select('id','tgl','saldo','counter')->get();
        return view('pages.Modal.modal_msaldoawal');
    }

    public function post(Request $request){
        // dd($request->all());
        MsaldoAwal::create([
            'tgl' => $request->dt,
            'saldo' => (float) str_replace(',', '', $request->saldo),
            'counter' => session('counter'),
        ]);
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function getedit(MsaldoAwal $msaldoAwal){
        return view('pages.Master.mdatawarnaedit',[ 'msaldoAwal' => $msaldoAwal]);
    }

    public function delete(MsaldoAwal $msaldoAwal){
        MsaldoAwal::find($msaldoAwal->id)->delete();
        return redirect()->route('msaldoawal');
    }
}
