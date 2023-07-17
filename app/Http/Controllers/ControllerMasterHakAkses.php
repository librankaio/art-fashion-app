<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;

class ControllerMasterHakAkses extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Master.mdatahakses',[
            'counters' => $counters,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        // Mitem::create([
        //     'name' => $request->nama,
        //     'code' => $request->kode,
        //     'warna' => $request->warna,
        //     'kategori' => $request->kategori,
        //     'hrgjual' => (float) str_replace(',', '', $request->price),
        //     'size' => $request->size,
        //     'satuan' => $request->satuan,
        //     'material' => $request->material,
        //     'gross' => (float) str_replace(',', '', $request->price_gross),
        //     'nett' => (float) str_replace(',', '', $request->price_nett),
        //     'spcprice' => (float) str_replace(',', '', $request->price_special),
        // ]);
        // return redirect()->back();
    }
}
