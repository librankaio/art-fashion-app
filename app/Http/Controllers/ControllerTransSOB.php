<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\Tsob_d;
use App\Models\Tsob_h;
use Illuminate\Http\Request;

class ControllerTransSOB extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        $mitems = Mitem::select('id','code','name')->get();
        return view('pages.Transaksi.tsob',[
            'counters' => $counters,
            'mitems' => $mitems,
        ]);
    }

    public function post(Request $request){
        dd($request->all());

        $checkexist = Tsob_h::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tsob_h::create([
                'no' => $request->no,
                'tgl' => $request->dt,
                'counter' => $request->counter,
                'note' => $request->note,
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
            ]);
            $idh_loop = Tsob_h::select('id')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }
    
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tsob_d::create([
                    'idh' => $idh,
                    'no_sob' => $request->no,
                    'code' => $request->kode_d[$i],
                    'name' => $request->namaitem_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'satuan' => $request->satuan_d[$i],
                    'htgjual' => (float) str_replace(',', '', $request->hrgjual_d[$i]),
                    'subtotal' => (float) str_replace(',', '', $request->subtot_d[$i]),
                ]);
                $count++;
            }
            if($count == $countrows){
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function  getmitem(Request $request){
        $kode = $request->kode;
        if($kode == ''){
            $mitems = Mitem::select('id','code','name','satuan','hrgjual')->get();
        }else{
            $mitems = Mitem::select('id','code','name','satuan','hrgjual')->where('code','=',$kode)->get();
        }
        return json_encode($mitems);
    }
}
