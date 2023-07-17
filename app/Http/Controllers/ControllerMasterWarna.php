<?php

namespace App\Http\Controllers;

use App\Models\Mwarna;
use App\Models\Warna;
use Illuminate\Http\Request;

class ControllerMasterWarna extends Controller
{
    public function index()
    {
        $datas = Mwarna::select('id','code','name')->get();
        return view('pages.Master.mdatawarna',[
            'datas' => $datas,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        Mwarna::create([
            'code' => $request->kode,
            'name' => $request->nama,
        ]);
        return redirect()->back();
    }

    public function getedit(Mwarna $mwarna){
        return view('pages.Master.mdatawarnaedit',[ 'mwarna' => $mwarna]);
    }

    public function update(Mwarna $mwarna){
        Mwarna::where('id', '=', $mwarna->id)->update([
            'code' => request('kode'),
            'name' => request('nama'),
        ]);

        return redirect()->route('mwarna');
    }

    public function delete(Mwarna $mwarna){
        Mwarna::find($mwarna->id)->delete();
        return redirect()->route('mwarna');
    }
}
