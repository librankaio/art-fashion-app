<?php

namespace App\Http\Controllers;

use App\Models\Mitem;
use App\Models\Mwarna;
use App\Models\Tpembelian_d;
use App\Models\Tpembelian_h;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransPembelianBarang extends Controller
{
    public function index()
    {
        $mitems = Mitem::select('id','code','name')->get();
        $mwarnas = Mwarna::select('id','code','name')->get();
        $notrans = DB::select("select fgetcode('tpembelian') as codetrans");
        return view('pages.Transaksi.tpembelianbarang',[
            'mitems' => $mitems,
            'mwarnas' => $mwarnas,
            'notrans' => $notrans
        ]);
    }

    public function post(Request $request){
        // dd($request->all());

        $checkexist = Tpembelian_h::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tpembelian_h::create([
                'no' => $request->no,
                'tgl' => $request->dt,
                'supplier' => $request->supplier,
                'note' => $request->note,
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
            ]);
            $idh_loop = Tpembelian_h::select('id')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }
    
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tpembelian_d::create([
                    'idh' => $idh,
                    'no_pembelian' => $request->no,
                    'code' => $request->kode_d[$i],
                    'name' => $request->nama_item_d[$i],
                    'warna' => $request->warna_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'satuan' => $request->satuan_d[$i],
                    'hrgbeli' => (float) str_replace(',', '', $request->hrgbeli_d[$i]),
                    'hrgjual' => (float) str_replace(',', '', $request->subtot_d[$i]),
                    'subtotal' => (float) str_replace(',', '', $request->subtot_d[$i]),
                ]);
                $count++;
                
                $exist_transcode = Mitem::select('id','code')->where('code','=', $request->kode_d[$i])->first();
                // dd(strtok($request->kode_d[$i], " "));
                if($exist_transcode == null || $exist_transcode != "Y"){
                    Mitem::where('code', '=', strtok($request->kode_d[$i], " "))->update([
                        'exist_trans' => "Y",
                    ]);
                }
            }
            if($count == $countrows){
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function list(){
        $tpembelianhs = Tpembelian_h::select('id','no','tgl','supplier','note','grdtotal',)->orderBy('created_at', 'asc')->get();
        $toembeliands = Tpembelian_d::select('id','idh','no_pembelian','code','name','warna','qty','satuan','hrgbeli','hrgjual','subtotal')->get();
        return view('pages.Transaksi.tpembelianbaranglist',[
            'tpembelianhs' => $tpembelianhs,
            'toembeliands' => $toembeliands
        ]);
    }

    public function getedit(Tpembelian_h $tpembelianh){
        $mwarnas = Mwarna::select('id','code','name')->get();
        $mitems = Mitem::select('id','code','name')->get();
        $tpembeliands = Tpembelian_d::select('id','idh','no_pembelian','code','name','warna','qty','satuan','hrgbeli','hrgjual','subtotal')->where('idh','=',$tpembelianh->id)->get();
        return view('pages.Transaksi.tpembelianbarangedit',[
            'mwarnas' => $mwarnas,
            'mitems' => $mitems,
            'tpembelianh' => $tpembelianh,
            'tpembeliands' => $tpembeliands,
        ]);
    }

    public function update(Tpembelian_h $tpembelianh){
        // dd(request()->all());
        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_pembelianh = request('no');
        }
        DB::delete('delete from tpembelian_ds where no_pembelian = ?', [$no_pembelianh] );
        Tpembelian_h::where('id', '=', $tpembelianh->id)->update([
            'no' => request('no'),
            'tgl' => request('dt'),
            'supplier' => request('supplier'),
            'note' => request('note'),
            'grdtotal' =>  (float) str_replace(',', '', request('price_total'))
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            Tpembelian_d::create([
                'idh' => $tpembelianh->id,
                'no_pembelian' => request('no'),
                'code' => request('kode_d')[$i],
                'name' => request('nama_item_d')[$i],
                'warna' => request('warna_d')[$i],
                'qty' => request('quantity_d')[$i],
                'satuan' => request('satuan_d')[$i],
                'hrgbeli' => (float) str_replace(',', '', request('hrgbeli_d')[$i]),
                'hrgjual' => (float) str_replace(',', '', request('hrgjual_d')[$i]),
                'subtotal' => (float) str_replace(',', '', request('subtot_d')[$i])
            ]);
            $count++;
        }
        
        if($count == $countrows){
            return redirect()->route('tpembelianbaranglist');
        }
    }

    public function delete(Tpembelian_h $tpembelianh){
        Tpembelian_h::find($tpembelianh->id)->delete();
        Tpembelian_d::find($tpembelianh->id)->where('idh','=',$tpembelianh->id)->get();

        return redirect()->route('tpembelianbaranglist');
    }
}
