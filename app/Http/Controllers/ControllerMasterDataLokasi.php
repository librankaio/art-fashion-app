<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerMasterDataLokasi extends Controller
{
    public function index()
    {
        $datas = Mcounter::select('id','code','name','alamat')->get();
        return view('pages.Master.mdatalokasi',[
            'datas' => $datas,
        ]);
    }

    public function post(Request $request){
        $availcode = Mcounter::where('code', '=', $request->code)->first();

        if($availcode != null){
            return redirect()->back()->with('error', 'Kode sudah terdaftar');
        }else{
            Mcounter::create([
                'code' => $request->code,
                'name' => $request->name,
                'alamat' => $request->alamat,
            ]);
            DB::select( DB::raw("insert into mitems_counters (code_mitem, name_mitem, code_mcounters, name_mcounters, stock)
            select code, name, '$request->code', $request->name, 0 FROM mitems"));
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function getedit(Mcounter $mcounter){
        return view('pages.Master.mdatalokasiedit',[ 'mcounter' => $mcounter]);
    }

    public function update(Mcounter $mcounter){
        Mcounter::where('id', '=', $mcounter->id)->update([
            'code' => request('code'),
            'name' => request('name'),
            'alamat' => request('alamat'),
        ]);

        return redirect()->route('mlokasi');
    }

    public function delete(Mcounter $mcounter){
        // dd($mcounter);
        if($mcounter->code == 'HO' || $mcounter->code == 'HO2'){
            return redirect()->back()->with('error', 'HO / HO2 Tidak dapat dihapus!');
        }
        Mcounter::find($mcounter->id)->delete();
        return redirect()->route('mlokasi');
    }

}
