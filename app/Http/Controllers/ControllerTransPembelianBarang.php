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
                $stock_mitem = Mitem::select('stock')->where('code', '=', strtok($request->kode_d[$i], " "))->first();
                $stock_sum = $stock_mitem->stock+$request->quantity_d[$i];
                Mitem::where('code', '=', strtok($request->kode_d[$i], " "))->update([
                    'stock' => (int)$stock_sum,
                ]);
                $stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', session('counter'))
                ->first();
                // dd($stock_mitem_counter);
                $stock_counter_sum = $stock_mitem_counter->stock+$request->quantity_d[$i];
                DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', session('counter'))
                ->update([
                    'stock' => (int)$stock_counter_sum,
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
        for($x=0;$x<sizeof(request('id_d'));$x++){
            $getstock_old = Tpembelian_d::where('id', '=', request('id_d')[$x])->first();
            // dd((int)$getstock_old->qty);
            // dd($getstock_old->code);
            $old_stock_mitem_counter = DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($getstock_old->code, " "))
            ->where('name_mcounters', '=', session('counter'))
            ->first();
            // dd($old_stock_mitem_counter->stock-(int)$getstock_old->qty);
            // Make stock counter value is equal to old stock
            $normalize_stock_counter = $old_stock_mitem_counter->stock-(int)$getstock_old->qty;
            DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($getstock_old->code, " "))
            ->where('name_mcounters', '=', session('counter'))
            ->update([
                'stock' => (int)$normalize_stock_counter,
            ]);

            $stock_mitem_old = Mitem::select('stock')->where('code', '=', strtok($getstock_old->code, " "))->first();
            // Make stock mitem value is equal to mitem old stock
            // dd($stock_mitem_old->stock - (int)$getstock_old->qty);
            $normalize_stock_mitem = $stock_mitem_old->stock - (int)$getstock_old->qty;
            Mitem::where('code', '=', strtok($getstock_old->code, " "))->update([
                'stock' => (int)$normalize_stock_mitem,
            ]);
        }


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
            
            $stock_mitem = Mitem::select('stock')->where('code', '=', strtok(request('kode_d')[$i], " "))->first();
            $stock_sum = $stock_mitem->stock+request('quantity_d')[$i];
            Mitem::where('code', '=', strtok(request('kode_d')[$i], " "))->update([
                'stock' => (int)$stock_sum,
            ]);
            $stock_mitem_counter = DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
            ->where('name_mcounters', '=', session('counter'))
            ->first();
            // dd($stock_mitem_counter);
            $stock_counter_sum = $stock_mitem_counter->stock+request('quantity_d')[$i];
            DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
            ->where('name_mcounters', '=', session('counter'))
            ->update([
                'stock' => (int)$stock_counter_sum,
            ]);
            $count++;
        }
        if($count == $countrows){
            return redirect()->route('tpembelianbaranglist');
        }
    }

    public function delete(Tpembelian_h $tpembelianh){
        Tpembelian_h::find($tpembelianh->id)->delete();
        Tpembelian_d::where('idh','=',$tpembelianh->id)->delete();

        return redirect()->route('tpembelianbaranglist');
    }
}
