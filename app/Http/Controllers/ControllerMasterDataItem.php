<?php

namespace App\Http\Controllers;

use App\Models\Mitem;
use Illuminate\Http\Request;

class ControllerMasterDataItem extends Controller
{
    public function index()
    {
        $datas = Mitem::select('id','code','name','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice')->get();
        return view('pages.Master.mdataitem',[
            'datas' => $datas
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        Mitem::create([
            'name' => $request->nama,
            'code' => $request->kode,
            'warna' => $request->warna,
            'kategori' => $request->kategori,
            'hrgjual' => (float) str_replace(',', '', $request->price),
            'size' => $request->size,
            'satuan' => $request->satuan,
            'material' => $request->material,
            'gross' => (float) str_replace(',', '', $request->price_gross),
            'nett' => (float) str_replace(',', '', $request->price_nett),
            'spcprice' => (float) str_replace(',', '', $request->price_special),
        ]);
        return redirect()->back();
    }

    public function getedit(Mitem $mitem){
        return view('pages.Master.mdataitemedit',[ 'mitem' => $mitem]);
    }

    public function update(Mitem $mitem){
        Mitem::where('id', '=', $mitem->id)->update([
            'name' => request('nama'),
            'code' => request('kode'),
            'warna' => request('warna'),
            'kategori' => request('kategori'),
            'hrgjual' => (float) str_replace(',', '', request('price')),
            'size' => request('size'),
            'satuan' => request('satuan'),
            'material' => request('material'),
            'gross' => (float) str_replace(',', '', request('price_gross')),
            'nett' => (float) str_replace(',', '', request('price_nett')),
            'spcprice' => (float) str_replace(',', '', request('price_special')),
        ]);

        return redirect()->route('mitem');
    }

    public function delete(Mitem $mitem){
        Mitem::find($mitem->id)->delete();
        return redirect()->route('mitem');
    }
}
