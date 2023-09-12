<?php

namespace App\Http\Controllers;

use App\Models\Mjenispayment;
use Illuminate\Http\Request;

class ControllerMasterJenisPayment extends Controller
{
    public function index()
    {
        $datas = Mjenispayment::select('id','code','name')->get();
        return view('pages.Master.mjenispayment',[
            'datas' => $datas,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        $availcode = Mjenispayment::where('code', '=', $request->kode)->first();

        if($availcode != null){
            return redirect()->back()->with('error', 'Kode sudah terdaftar');
        }else{
            Mjenispayment::create([
                'code' => $request->kode,
                'name' => $request->nama,
            ]);
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function getedit(Mjenispayment $mjenispayment){
        return view('pages.Master.mjenispaymentedit',[ 'mjenispayment' => $mjenispayment]);
    }

    public function update(Mjenispayment $mjenispayment){
        Mjenispayment::where('id', '=', $mjenispayment->id)->update([
            'code' => request('kode'),
            'name' => request('nama'),
        ]);

        return redirect()->route('mjenispayment');
    }

    public function delete(Mjenispayment $mjenispayment){
        Mjenispayment::where('id', '=', $mjenispayment->id)->delete();
        return redirect()->route('mjenispayment');
    }
}
