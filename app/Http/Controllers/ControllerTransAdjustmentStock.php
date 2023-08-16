<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\Tadj_d;
use App\Models\Tadj_h;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransAdjustmentStock extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        $mitems = Mitem::select('id','code','name')->get();
        $notrans = DB::select("select fgetcode('tadj') as codetrans");
        return view('pages.Transaksi.tadjustmentstock',[
            'counters' => $counters,
            'mitems' => $mitems,
            'notrans' => $notrans,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());

        $checkexist = Tadj_h::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tadj_h::create([
                'no' => $request->no,
                'tgl' => $request->dt,
                'counter' => $request->counter,
                'jenis' => $request->jenis,
                'note' => $request->note,
            ]);
            $idh_loop = Tadj_h::select('id')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }
    
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tadj_d::create([
                    'idh' => $idh,
                    'no_adj' => $request->no,
                    'code' => $request->kode_d[$i],
                    'name' => $request->nama_item_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'satuan' => $request->satuan_d[$i],
                ]);
                $count++;
            }
            if($count == $countrows){
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function list(){
        $tadjhs = Tadj_h::select('id','no','tgl','note',)->orderBy('created_at', 'asc')->get();
        $tadjds = Tadj_d::select('id','idh','no_adj','code','name','qty','satuan')->get();
        return view('pages.Transaksi.tadjustmentstocklist',[
            'tadjhs' => $tadjhs,
            'tadjds' => $tadjds
        ]);
    }

    public function getedit(Tadj_h $tadjh){
        $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        $mitems = Mitem::select('id','code','name')->get();
        $tadjs = Tadj_d::select('id','idh','no_adj','code','name','qty','satuan',)->where('idh','=',$tadjh->id)->get();
        return view('pages.Transaksi.tadjustmentstockedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'tadjh' => $tadjh,
            'tadjs' => $tadjs,
        ]);
    }

    public function update(Tadj_h $tadjh){
        // dd(request()->all());
        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_adj = request('no');
        }
        DB::delete('delete from tadj_ds where no_adj = ?', [$no_adj] );
        Tadj_h::where('id', '=', $tadjh->id)->update([
            'no' => request('no'),
            'tgl' => request('dt'),
            'counter' => request('counter'),
            'jenis' => request('jenis'),
            'note' => request('note'),
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            Tadj_d::create([
                'idh' => $tadjh->id,
                'no_adj' => request('no'),
                'code' =>  request('kode_d')[$i],
                'name' =>  request('nama_item_d')[$i],
                'qty' =>  request('quantity_d')[$i],
                'satuan' => request('satuan_d')[$i],
            ]);
            $count++;
        }
        
        if($count == $countrows){
            return redirect()->route('tadjlist');
        }
    }

    public function delete(Tadj_h $tadjh){
        Tadj_h::find($tadjh->id)->delete();
        Tadj_d::find($tadjh->id)->where('idh','=',$tadjh->id)->get();

        return redirect()->route('tadjlist');
    }
}
