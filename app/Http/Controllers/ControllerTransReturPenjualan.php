<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\Tretur_d;
use App\Models\Tretur_h;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransReturPenjualan extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        $mitems = Mitem::select('id','code','name')->get();
        return view('pages.Transaksi.treturpenjualan',[
            'counters' => $counters,
            'mitems' => $mitems,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());

        $checkexist = Tretur_h::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tretur_h::create([
                'no' => $request->no,
                'counter' => $request->counter,
                'tgl' => $request->dt,
                'note' => $request->note,
            ]);
            $idh_loop = Tretur_h::select('id')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }
    
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tretur_d::create([
                    'idh' => $idh,
                    'no_retur' => $request->no,
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
        $treturhs = Tretur_h::select('id','no','counter','tgl','note',)->orderBy('created_at', 'asc')->get();
        $treturds = Tretur_d::select('id','idh','no_retur','code','name','qty','satuan',)->get();
        return view('pages.Transaksi.treturpenjualanlist',[
            'treturhs' => $treturhs,
            'treturds' => $treturds
        ]);
    }

    public function getedit(Tretur_h $treturh){
        $counters = Mcounter::select('id','code','name')->get();
        $mitems = Mitem::select('id','code','name')->get();
        $treturds = Tretur_d::select('id','idh','no_retur','code','name','qty','satuan',)->where('idh','=',$treturh->id)->get();
        return view('pages.Transaksi.treturpenjualanedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'treturh' => $treturh,
            'treturds' => $treturds,
        ]);
    }

    public function update(Tretur_h $treturh){
        // dd(request()->all());
        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_retur = request('no');
        }
        DB::delete('delete from tretur_ds where no_retur = ?', [$no_retur] );
        Tretur_h::where('id', '=', $treturh->id)->update([
            'no' => request('no'),
            'counter' => request('counter'),
            'tgl' => request('dt'),
            'note' => request('note'),
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            Tretur_d::create([
                'idh' => $treturh->id,
                'no_retur' => request('no'),
                'code' =>  request('kode_d')[$i],
                'name' =>  request('nama_item_d')[$i],
                'qty' =>  request('quantity_d')[$i],
                'satuan' => request('satuan_d')[$i],
            ]);
            $count++;
        }
        
        if($count == $countrows){
            return redirect()->route('treturjuallist');
        }
    }
}
