<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\Tpenerimaan_d;
use App\Models\Tpenerimaan_h;
use App\Models\Tsj_d;
use App\Models\Tsj_h;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransPenerimaanBrg extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        $mitems = Mitem::select('id','code','name')->get();
        $notsjs = Tsj_h::select('id','no','tgl','counter',)->get();
        $notrans = DB::select("select fgetcode('tpenerimaan') as codetrans");
        return view('pages.Transaksi.tpenerimaanbrg',[
            'counters' => $counters,
            'mitems' => $mitems,
            'notsjs' => $notsjs,
            'notrans' => $notrans,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());

        $checkexist = Tpenerimaan_h::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tpenerimaan_h::create([
                'no' => $request->no,
                'no_sj' => $request->nosj,
                'counter' => $request->counter,
                'tgl' => $request->dt,
                'note' => $request->note,
                'jenis' => $request->jenis,
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
            ]);
            $idh_loop = Tpenerimaan_h::select('id')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }
    
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tpenerimaan_d::create([
                    'idh' => $idh,
                    'no_penerimaan' => $request->no,
                    'code' => $request->kode_d[$i],
                    'name' => $request->nama_item_d[$i],
                    'warna' => $request->warna_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'satuan' => $request->satuan_d[$i],
                    'hrgjual' => (float) str_replace(',', '', $request->hrgjual_d[$i]),
                    'keterangan' => $request->satuan_d[$i],
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
            $mitems = Mitem::select('id','code','name','warna','satuan','hrgjual')->get();
        }else{
            $mitems = Mitem::select('id','code','name','warna','satuan','hrgjual')->where('code','=',$kode)->get();
        }
        return json_encode($mitems);
    }

    public function  getnosj(Request $request){
        $nosj = $request->nosj;
        if($nosj == ''){
            $items = Tsj_d::select('id','idh','no_sj','code','name','warna','qty','satuan','hrgjual','subtotal',)->get();
        }else{
            $items = Tsj_d::select('id','idh','no_sj','code','name','warna','qty','satuan','hrgjual','subtotal',)->where('no_sj','=',$nosj)->get();
        }
        return json_encode($items);
    }

    public function list(){
        $tpenerimaanhs = Tpenerimaan_h::select('id','no','no_sj','counter','tgl','note','jenis','grdtotal','user',)->orderBy('created_at', 'asc')->get();
        $tpenerimaands = Tpenerimaan_d::select('id','idh','no_penerimaan','code','name','qty','satuan','hrgjual','keterangan','subtotal',)->get();
        return view('pages.Transaksi.tpenerimaanbrglist',[
            'tpenerimaanhs' => $tpenerimaanhs,
            'tpenerimaands' => $tpenerimaands
        ]);
    }

    public function getedit(Tpenerimaan_h $tpenerimaanh){
        $counters = Mcounter::select('id','code','name')->get();
        $mitems = Mitem::select('id','code','name')->get();
        $tpenerimaands = Tpenerimaan_d::select('id','idh','no_penerimaan','code','name','warna','qty','satuan','hrgjual','keterangan','subtotal',)->where('idh','=',$tpenerimaanh->id)->get();
        return view('pages.Transaksi.tpenerimaanbrgedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'tpenerimaanh' => $tpenerimaanh,
            'tpenerimaands' => $tpenerimaands,
        ]);
    }

    public function update(Tpenerimaan_h $tpenerimaanh){
        // dd(request()->all());
        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_penerimaanh = request('no');
        }
        DB::delete('delete from tsob_ds where no_sob = ?', [$no_penerimaanh] );
        Tpenerimaan_h::where('id', '=', $tpenerimaanh->id)->update([
            'no' => request('no'),
            'no_sj' => request('nosj'),
            'counter' => request('counter'),
            'tgl' => request('dt'),
            'note' => request('note'),
            'jenis' => request('jenis'),
            'grdtotal' => (float) str_replace(',', '', request('price_total')) 
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            Tpenerimaan_d::create([
                'idh' => $tpenerimaanh->id,
                'no_penerimaan' => request('no'),
                'code' =>  request('kode_d')[$i],
                'name' =>  request('namaitem_d')[$i],
                'warna' =>  request('warna_d')[$i],
                'qty' =>  request('quantity_d')[$i],
                'satuan' => request('satuan_d')[$i],
                'hrgjual' => (float) str_replace(',', '', request('hrgjual_d')[$i]),
                'keterangan' => request('satuan_d')[$i],
                'subtotal' => (float) str_replace(',', '', request('subtot_d')[$i]),
            ]);
            $count++;
        }
        
        if($count == $countrows){
            return redirect()->route('tpenerimaanbrglist');
        }
    }

    public function delete(Tpenerimaan_h $tpenerimaanh){
        Tpenerimaan_h::find($tpenerimaanh->id)->delete();
        Tpenerimaan_d::find($tpenerimaanh->id)->where('idh','=',$tpenerimaanh->id)->get();

        return redirect()->route('tpenerimaanbrglist');
    }
}
