<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\Tsob_d;
use App\Models\Tsob_h;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransSOB extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        $mitems = Mitem::select('id','code','name')->orderBy('code', 'asc')->get();
        $notrans = DB::select("select fgetcode('tsob') as codetrans");
        return view('pages.Transaksi.tsob',[
            'counters' => $counters,
            'mitems' => $mitems,
            'notrans' => $notrans,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());

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
                    'subtotal' => (float) str_replace(',', '', $request->subtot_d[$i]),
                    'hrgjual' => (float) str_replace(',', '', $request->hrgjual_d[$i]),
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
            $mitems = Mitem::select('id','code','name','satuan','hrgjual')->orderBy('code', 'asc')->limit(20)->get();
        }else{
            $mitems = Mitem::select('id','code','name','satuan','hrgjual')->where('code','=',$kode)->limit(20)->get();
        }
        return json_encode($mitems);
    }

    public function list(){
        $tsobhs = Tsob_h::select('id','no','tgl','counter','note','grdtotal','user',)->orderBy('created_at', 'asc')->get();
        $tsobds = Tsob_d::select('id','idh','no_sob','code','name','qty','satuan','hrgjual','subtotal',)->get();
        return view('pages.Transaksi.tsoblist',[
            'tsobhs' => $tsobhs,
            'tsobds' => $tsobds
        ]);
    }

    public function getedit(Tsob_h $tsobh){
        $counters = Mcounter::select('id','code','name')->get();
        $mitems = Mitem::select('id','code','name')->get();
        $tsobds = Tsob_d::select('id','idh','no_sob','code','name','qty','satuan','hrgjual','subtotal',)->where('idh','=',$tsobh->id)->get();
        return view('pages.Transaksi.tsobedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'tsobh' => $tsobh,
            'tsobds' => $tsobds,
        ]);
    }

    public function update(Tsob_h $tsobh){
        // dd(request()->all());
        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_sobh = request('no');
        }
        DB::delete('delete from tsob_ds where no_sob = ?', [$no_sobh] );
        Tsob_h::where('id', '=', $tsobh->id)->update([
            'no' => request('no'),
            'tgl' => request('dt'),
            'counter' => request('counter'),
            'note' => request('note'),
            'grdtotal' =>  (float) str_replace(',', '', request('price_total'))
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            Tsob_d::create([
                'idh' => $tsobh->id,
                'no_sob' => request('no')[$i],
                'code' => request('kode_d')[$i],
                'name' => request('namaitem_d')[$i],
                'qty' => request('quantity_d')[$i],
                'satuan' => request('satuan_d')[$i],
                'hrgjual' => (float) str_replace(',', '', request('hrgjual_d')[$i]),
                'subtotal' => (float) str_replace(',', '', request('subtot_d')[$i])
            ]);
            $count++;
        }
        
        if($count == $countrows){
            return redirect()->route('tsoblist');
        }
    }

    public function delete(Tsob_h $tsobh){
        Tsob_h::find($tsobh->id)->delete();
        Tsob_d::find($tsobh->id)->where('idh','=',$tsobh->id)->get();
        return redirect()->route('tsoblist');
    }

    public function print(Tsob_h $tsobh){
        
        $tsobds = Tsob_d::find($tsobh->id)->where('idh','=',$tsobh->id)->get();
        
        // dd($tsobds);
        return view('pages.Print.tsobprint',[
            'tsobh' => $tsobh,
            'tsobds' => $tsobds
        ]);
    }
}
