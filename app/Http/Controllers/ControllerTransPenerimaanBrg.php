<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\MitemCounters;
use App\Models\MutasiAF;
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
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == 'GUDANG'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        $mitems = Mitem::select('id','code','name')->get();
        $notsjs = Tsj_h::select('id','no','tgl','counter',)->whereNull('exist_penerimaan')->get();
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
        $notrans = DB::select("select fgetcode('tpenerimaan') as codetrans");

        foreach($notrans as $notran){
            $no = $notran->codetrans;
        }
        $checkexist = Tpenerimaan_h::select('id','no')->where('no','=', $no)->first();
        if($checkexist == null){
            Tpenerimaan_h::create([
                'no' => $no,
                'no_sj' => $request->nosj,
                'counter' => $request->counter,
                'tgl' => $request->dt,
                'note' => $request->note,
                'jenis' => $request->jenis,
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
            ]);
            $idh_loop = Tpenerimaan_h::select('id')->where('no','=',$no)->get();
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
                    'keterangan' => $request->keterangan_d[$i],
                    'subtotal' => (float)    str_replace(',', '', $request->subtot_d[$i]),
                ]);
                $stock_mitem = Mitem::select('stock')->where('code', '=', strtok($request->kode_d[$i], " "))->first();
                $stock_sum = $stock_mitem->stock+$request->quantity_d[$i];
                Mitem::where('code', '=', strtok($request->kode_d[$i], " "))->update([
                    'stock' => (int)$stock_sum,
                ]);
                $stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', $request->counter)
                ->first();
                $mcounter = Mcounter::where('name', '=', session('counter'))->first();
                if ($stock_mitem_counter == null) {
                    $stock_mitem_counter = 0;
                    $stock_counter_sum = $stock_mitem_counter+$request->quantity_d[$i];
                    date_default_timezone_set('Asia/Jakarta');
                    $datetime = date('d-m-Y H:i:s');
                    MitemCounters::create([
                        'code_mitem' => strtok($request->kode_d[$i], " "),
                        'name_mitem' => $request->nama_item_d[$i],
                        'code_mcounters' => $mcounter->code,
                        'name_mcounters' => session('counter'),
                        'stock' => $stock_counter_sum,
                        'datein' => $datetime,
                    ]);
                }else{
                    // dd($stock_mitem_counter);
                    $stock_counter_sum = $stock_mitem_counter->stock+$request->quantity_d[$i];
                    DB::table('mitems_counters')
                    ->selectRaw('stock')
                    ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                    ->where('name_mcounters', '=', $request->counter)
                    ->update([
                        'stock' => (int)$stock_counter_sum,
                    ]);

                    $mcounter = Mcounter::where('name', '=', $request->counter)->first();
                    MutasiAF::create([  
                        'code_mitem' => strtok($request->kode_d[$i], " "),
                        'code_mcounters' => $mcounter->code,
                        'qty' => $request->quantity_d[$i],
                        'notrans' => $request->no,
                        'doctype' => "PENERIMAAN",
                        'jenis' => "PLUS",
                        'action' => "CREATE",
                        'user' => session('nik'),
                    ]);
                }
                $count++;
            }
            Tsj_h::where('no', '=', $request->nosj)->update([
                'exist_penerimaan' => "Y",
            ]);
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

    public function  getnosjh(Request $request){
        $nosj = $request->nosj;
        if($nosj == ''){
            $items = Tsj_h::select('id','no','counter_from','counter')->get();
        }else{
            $items = Tsj_h::select('id','no','counter_from','counter')->where('no','=',$nosj)->get();
        }
        return json_encode($items);
    }

    public function list(){
        if(session('privilage') != "ADM"){
            $tpenerimaanhs = Tpenerimaan_h::select('id','no','no_sj','counter','tgl','note','jenis','grdtotal','user',)->orderBy('created_at', 'asc')->where('counter','=',session('counter'))->get();
            $tpenerimaands = Tpenerimaan_d::select('id','idh','no_penerimaan','code','name','qty','satuan','hrgjual','keterangan','subtotal',)->get();
        }else{
            $tpenerimaanhs = Tpenerimaan_h::select('id','no','no_sj','counter','tgl','note','jenis','grdtotal','user',)->orderBy('created_at', 'asc')->get();
            $tpenerimaands = Tpenerimaan_d::select('id','idh','no_penerimaan','code','name','qty','satuan','hrgjual','keterangan','subtotal',)->get();
        }
        return view('pages.Transaksi.tpenerimaanbrglist',[
            'tpenerimaanhs' => $tpenerimaanhs,
            'tpenerimaands' => $tpenerimaands
        ]);
    }

    public function getedit(Tpenerimaan_h $tpenerimaanh){
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == 'GUDANG'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        $mitems = Mitem::select('id','code','name')->get();
        $tpenerimaands = Tpenerimaan_d::select('id','idh','no_penerimaan','code','name','warna','qty','satuan','hrgjual','keterangan','subtotal',)->where('idh','=',$tpenerimaanh->id)->get();
        // dd($tpenerimaands);
        return view('pages.Transaksi.tpenerimaanbrgedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'tpenerimaanh' => $tpenerimaanh,
            'tpenerimaands' => $tpenerimaands,
        ]);
    }

    public function update(Tpenerimaan_h $tpenerimaanh){
        // dd(request()->all());

        for($x=0;$x<sizeof(request('existdb_d'));$x++){
            $getstock_old = Tpenerimaan_d::where('id', '=', request('id_d')[$x])->first();
            if ($getstock_old != null){
                // dd($getstock_old);
                // dd((int)$getstock_old->qty);
                // dd($getstock_old->code);
                $old_stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($getstock_old->code, " "))
                ->where('name_mcounters', '=', request('counter'))
                ->first();
                // dd($old_stock_mitem_counter->stock-(int)$getstock_old->qty);
                // Make stock counter value is equal to old stock
                // $getstock_old->qty is pembelian_d stock value
                $normalize_stock_counter = $old_stock_mitem_counter->stock-(int)$getstock_old->qty;
                // dd($normalize_stock_counter);
                DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($getstock_old->code, " "))
                ->where('name_mcounters', '=', request('counter'))
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

                if(request('deleted_item_d') == request('id_d')[$x]){
                    Tpenerimaan_d::where('id','=',request('id_d')[$x])->delete();
                }
            }
        }

        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_penerimaanh = request('no');
        }
        DB::delete('delete from tpenerimaan_ds where no_penerimaan = ?', [$no_penerimaanh] );
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
            if(request('deleted_item_d')[$i] != request('id_d')[$i]){
                Tpenerimaan_d::create([
                    'idh' => $tpenerimaanh->id,
                    'no_penerimaan' => request('no'),
                    'code' =>  request('kode_d')[$i],
                    'name' =>  request('nama_item_d')[$i],
                    'warna' =>  request('warna_d')[$i],
                    'qty' =>  request('quantity_d')[$i],
                    'satuan' => request('satuan_d')[$i],
                    'hrgjual' => (float) str_replace(',', '', request('hrgjual_d')[$i]),
                    'keterangan' => request('keterangan_d')[$i],
                    'subtotal' => (float) str_replace(',', '', request('subtot_d')[$i]),
                ]);
                $stock_mitem = Mitem::select('stock')->where('code', '=', strtok(request('kode_d')[$i], " "))->first();
                $stock_sum = $stock_mitem->stock+request('quantity_d')[$i];
                Mitem::where('code', '=', strtok(request('kode_d')[$i], " "))->update([
                    'stock' => (int)$stock_sum,
                ]);
                $stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
                ->where('name_mcounters', '=', request('counter'))
                ->first();

                $mcounter = Mcounter::where('name', '=', request('counter'))->first();

                if ($stock_mitem_counter == null) {
                    $stock_mitem_counter = 0;
                    $stock_counter_sum = $stock_mitem_counter + request('quantity_d')[$i];
                    date_default_timezone_set('Asia/Jakarta');
                    $datetime = date('d-m-Y H:i:s');
                    MitemCounters::create([
                        'code_mitem' => strtok(request('kode_d')[$i], " "),
                        'name_mitem' => request('nama_item_d')[$i],
                        'code_mcounters' => $mcounter->code,
                        'name_mcounters' => request('counter'),
                        'stock' => $stock_counter_sum,
                        'datein' => $datetime,
                    ]);
                }else{
                    $stock_counter_sum = $stock_mitem_counter->stock +request('quantity_d')[$i];
                    DB::table('mitems_counters')
                    ->selectRaw('stock')
                    ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
                    ->where('name_mcounters', '=', request('counter'))
                    ->update([
                        'stock' => (int)$stock_counter_sum,
                    ]);

                    $mcounter = Mcounter::where('name', '=', request('counter'))->first();
                    MutasiAF::create([  
                        'code_mitem' => strtok(request('kode_d')[$i], " "),
                        'code_mcounters' => $mcounter->code,
                        'qty' => request('quantity_d')[$i],
                        'notrans' => request('no'),
                        'doctype' => "PENERIMAAN",
                        'jenis' => "ADJUST",
                        'action' => "UPDATE",
                        'user' => session('nik'),
                    ]);
                }
                // dd($stock_mitem_counter);
                $count++;
            }
        }
        return redirect()->route('tpenerimaanbrglist');
        // if($count == $countrows){
        //     return redirect()->route('tpenerimaanbrglist');
        // }
    }

    public function delete(Tpenerimaan_h $tpenerimaanh){
        $penerimaan_detail = Tpenerimaan_d::where('idh','=',$tpenerimaanh->id)->get();
        foreach($penerimaan_detail as $penerimaan_old_item){
            // Mins a value from the old stock in mitems_counters table
            $stock_mitem_counter = DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($penerimaan_old_item->code, " "))
            ->where('name_mcounters', '=', $tpenerimaanh->counter)
            ->first();
            // dd($stock_mitem_counter);
            $stock_mitem_counter_min = $stock_mitem_counter->stock - (int)$penerimaan_old_item->qty;
            // dd($stock_mitem_counter_min);
            DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($penerimaan_old_item->code, " "))
            ->where('name_mcounters', '=', $tpenerimaanh->counter)
            ->update([
                'stock' => (int)$stock_mitem_counter_min,
            ]);

            $mcounter = Mcounter::where('name', '=', $tpenerimaanh->counter)->first();

            MutasiAF::create([  
                'code_mitem' => strtok($penerimaan_old_item->code, " "),
                'code_mcounters' => $mcounter->code,
                'qty' => (int)$penerimaan_old_item->qty,
                'notrans' => $tpenerimaanh->no,
                'doctype' => "PENERIMAAN",
                'jenis' => "MINUS",
                'action' => "DELETE",
                'user' => session('nik'),
            ]);
        }

        $tpenerimaan = Tpenerimaan_h::where('id','=',$tpenerimaanh->id)->first();
        $tsjh = Tsj_h::where('no', '=', $tpenerimaan->no_sj)->first();
        Tsj_h::where('no', '=', $tpenerimaan->no_sj)->update([
            'exist_penerimaan' => NULL,
        ]);
        Tpenerimaan_h::where('id','=',$tpenerimaanh->id)->delete();
        Tpenerimaan_d::where('idh','=',$tpenerimaanh->id)->delete();

        return redirect()->route('tpenerimaanbrglist');
    }
}
