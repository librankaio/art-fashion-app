<?php

namespace App\Http\Controllers;

use App\Models\MsaldoAwal;
use Illuminate\Http\Request;

class ControllerMasterSaldoAwal extends Controller
{
    public function index()
    {
        $datas = MsaldoAwal::select('id','tgl','saldo','counter')->where('counter','=',session('counter'))->orderBy('created_at', 'desc')->get();
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
        $checkexist = MsaldoAwal::select('tgl','saldo')->where('tgl','=', $request->dt)->where('counter','=', session('counter'))->first();
        if($checkexist == null){
            MsaldoAwal::create([
                'tgl' => $request->dt,
                'saldo' => (float) str_replace(',', '', $request->saldo),
                'counter' => session('counter'),
            ]);
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
        return redirect()->back()->with('warning', 'Saldo hari ini sudah ada!');
    }

    public function getedit(MsaldoAwal $msaldoAwal){
        return view('pages.Master.mdatawarnaedit',[ 'msaldoAwal' => $msaldoAwal]);
    }

    public function delete(MsaldoAwal $msaldoAwal){
        MsaldoAwal::find($msaldoAwal->id)->delete();
        return redirect()->route('msaldoawal');
    }
}
