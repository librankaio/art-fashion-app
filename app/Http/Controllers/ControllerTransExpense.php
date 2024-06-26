<?php

namespace App\Http\Controllers;

use App\Models\Texpense_h;
use Illuminate\Http\Request;

class ControllerTransExpense extends Controller
{
    public function index()
    {
        // dd(session('counter'));
        $counter = session('counter');
        $datas = Texpense_h::select('id','tgl','note','total')->where('counter','=',$counter)->orderBy('created_at', 'desc')->get();
        return view('pages.Transaksi.texpense',[
            'datas' => $datas,
        ]);
    }

    public function post(Request $request){
        $counter = session('counter');
        Texpense_h::create([
            'tgl' => $request->dt,
            'note' => $request->note,
            'total' => (float) str_replace(',', '', $request->total),
            'counter' => $counter,
        ]);
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function getedit(Texpense_h $texpenseh){
        return view('pages.Transaksi.texpenseedit',[
            'texpenseh' => $texpenseh
        ]);
    }

    public function update(Texpense_h $texpenseh){
        $counter = session('counter');
        Texpense_h::where('id', '=', $texpenseh->id)->update([
            'tgl' => request('dt'),
            'note' => request('note'),
            'total' => (float) str_replace(',', '', request('total')),
            'counter' => $counter,
        ]);

        return redirect()->route('texpense')->with('success', 'Data berhasil ditambahkan');
    }

    public function delete(Texpense_h $texpenseh){
        Texpense_h::find($texpenseh->id)->delete();
        return redirect()->route('texpense')->with('success', 'Data berhasil dihapus');
    }
}
