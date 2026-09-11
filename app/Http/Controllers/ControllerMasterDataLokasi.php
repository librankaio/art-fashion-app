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
                'initial' => $request->initial,
            ]);
            // Nilai di-bind, tidak lagi ditempel ke string SQL. Nama counter
            // yang mengandung apostrof (mis. "CITRUS D'MALL DEPOK") dulu
            // membuat query ini syntax error, sehingga seeding puluhan ribu
            // baris mitems_counters gagal diam-diam dan counter itu jadi bolong.
            DB::insert(
                "INSERT INTO mitems_counters (code_mitem, name_mitem, code_mcounters, name_mcounters, stock)
                 SELECT code, name, ?, ?, 0 FROM mitems",
                [$request->code, $request->name]
            );
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
            'initial' => request('initial'),
        ]);
        $code = request('code');
        $name = request('name');
        DB::update(
            "UPDATE mitems_counters SET code_mcounters = ?, name_mcounters = ? WHERE code_mcounters = ?",
            [$code, $name, $mcounter->code]
        );

        return redirect()->route('mlokasi')->with('success', 'Data berhasil di update');
    }

    public function delete(Mcounter $mcounter){
        if($mcounter->code == 'HO' || $mcounter->code == 'HO2'){
            return redirect()->back()->with('error', 'HO / HO2 Tidak dapat dihapus!');
        }
        Mcounter::where('id', $mcounter->id)->delete();
        DB::delete("DELETE FROM mitems_counters WHERE code_mcounters = ?", [$mcounter->code]);
        return redirect()->route('mlokasi')->with('success', 'Data berhasil di hapus');
    }

}
