<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\MitemCounters;
use App\Models\Tretur_d;
use App\Models\Tretur_h;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ControllerTransReturPenjualan extends Controller
{
    public function index()
    {
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        $mitems = Mitem::select('id','code','name')->get();
        $notrans = DB::select("select fgetcode('tretur') as codetrans");
        return view('pages.Transaksi.treturpenjualan',[
            'counters' => $counters,
            'mitems' => $mitems,
            'notrans' => $notrans,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        $items = array();
        $is_stocknotvalid = 0;
        for ($i=0;$i<sizeof($request->no_d);$i++){
            $stock_mitem_counter = DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
            ->where('name_mcounters', '=', $request->counter_from)
            ->first();
            $stock_counter_min = $stock_mitem_counter->stock-$request->quantity_d[$i];
            // dd($stock_mitem_counter);
            if ($request->quantity_d[$i] > $stock_mitem_counter->stock){
                array_push($items, strtok($request->kode_d[$i], " "));
                Session::flash('items_error', $items);
                Session::flash('counter_selected', $request->counter_from);
                $is_stocknotvalid++;
            }            
        }
        if ($is_stocknotvalid != 0){
            // dd(count(session('items_error')));
            return redirect()->back()->with('error', 'Salah satu item stock counter kosong atau lebih dari stock counter!');
        }
        
        $checkexist = Tretur_h::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tretur_h::create([
                'no' => $request->no,
                'counter' => $request->counter,
                'counter_from' => $request->counter_from,
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
                    'warna' => $request->warna_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'satuan' => $request->satuan_d[$i],
                ]);
                $stock_mitem = Mitem::select('stock')->where('code', '=', strtok($request->kode_d[$i], " "))->first();
                // dd($stock_mitem);
                $stock_min = $stock_mitem->stock - $request->quantity_d[$i];
                // dd($stock_min);
                Mitem::where('code', '=', strtok($request->kode_d[$i], " "))->update([
                    'stock' => (int)$stock_min,
                ]);
                $stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', $request->counter_from)
                ->first();
                $stock_counter_min = $stock_mitem_counter->stock-$request->quantity_d[$i];
                // dd($stock_counter_min);
                DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', $request->counter_from)
                ->update([
                    'stock' => (int)$stock_counter_min,
                ]);
                $stock_mitem_counter_to = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', $request->counter)
                ->first();
                $stock_counter_to_plus = $stock_mitem_counter_to->stock+$request->quantity_d[$i];
                // dd($stock_counter_min);
                DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', $request->counter)
                ->update([
                    'stock' => (int)$stock_counter_to_plus,
                ]);
                $count++;
            }
            if($count == $countrows){
                return redirect()->back()->with('success', 'Data berhasil ditambahkan');
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
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        $mitems = Mitem::select('id','code','name')->get();
        $treturds = Tretur_d::select('id','idh','no_retur','code','name','warna','qty','satuan',)->where('idh','=',$treturh->id)->get();
        return view('pages.Transaksi.treturpenjualanedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'treturh' => $treturh,
            'treturds' => $treturds,
        ]);
    }

    public function update(Tretur_h $treturh){
        // dd(request()->all());
        for($x=0;$x<sizeof(request('existdb_d'));$x++){
            $getstock_old = Tretur_d::where('id', '=', request('id_d')[$x])->first();
            if ($getstock_old != null){
                // dd($getstock_old);
                // dd((int)$getstock_old->qty);
                // dd($getstock_old->code);
                $old_stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($getstock_old->code, " "))
                ->where('name_mcounters', '=', request('counter_from'))
                ->first();
                // dd($old_stock_mitem_counter->stock-(int)$getstock_old->qty);
                // Make stock counter value is equal to old stock
                // $getstock_old->qty is tretur_d stock value
                $normalize_stock_counter = $old_stock_mitem_counter->stock+(int)$getstock_old->qty;
                DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($getstock_old->code, " "))
                ->where('name_mcounters', '=', request('counter_from'))
                ->update([
                    'stock' => (int)$normalize_stock_counter,
                ]);

                $old_stock_mitem_counter_to = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($getstock_old->code, " "))
                ->where('name_mcounters', '=', request('counter'))
                ->first();
                $normalize_stock_counter_to = $old_stock_mitem_counter_to->stock-(int)$getstock_old->qty;
                DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($getstock_old->code, " "))
                ->where('name_mcounters', '=', request('counter'))
                ->update([
                    'stock' => (int)$normalize_stock_counter_to,
                ]);

                $stock_mitem_old = Mitem::select('stock')->where('code', '=', strtok($getstock_old->code, " "))->first();
                // Make stock mitem value is equal to mitem old stock
                $normalize_stock_mitem = $stock_mitem_old->stock + (int)$getstock_old->qty;
                Mitem::where('code', '=', strtok($getstock_old->code, " "))->update([
                    'stock' => (int)$normalize_stock_mitem,
                ]);

                if(request('deleted_item_d') == request('id_d')[$x]){
                    Tretur_d::where('id','=',request('id_d')[$x])->delete();
                }
            }
        }

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
            if(request('deleted_item_d')[$i] != request('id_d')[$i]){
                Tretur_d::create([
                    'idh' => $treturh->id,
                    'no_retur' => request('no'),
                    'code' =>  request('kode_d')[$i],
                    'name' =>  request('nama_item_d')[$i],
                    'qty' =>  request('quantity_d')[$i],
                    'satuan' => request('satuan_d')[$i],
                ]);
                $stock_mitem = Mitem::select('stock')->where('code', '=', strtok(request('kode_d')[$i], " "))->first();
                $stock_min = $stock_mitem->stock-request('quantity_d')[$i];
                Mitem::where('code', '=', strtok(request('kode_d')[$i], " "))->update([
                    'stock' => (int)$stock_min,
                ]);
                $stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
                ->where('name_mcounters', '=', request('counter_from'))
                ->first();
                $stock_mitem_counter_to = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
                ->where('name_mcounters', '=', request('counter'))
                ->first();

                $mcounter = Mcounter::where('name', '=', request('counter_from'))->first();

                if ($stock_mitem_counter == null) {
                    $stock_mitem_counter = 0;
                    $stock_counter_min = $stock_mitem_counter - request('quantity_d')[$i];
                    date_default_timezone_set('Asia/Jakarta');
                    $datetime = date('d-m-Y H:i:s');
                    MitemCounters::create([
                        'code_mitem' => strtok(request('kode_d')[$i], " "),
                        'name_mitem' => request('nama_item_d')[$i],
                        'code_mcounters' => $mcounter->code,
                        'name_mcounters' => request('counter_from'),
                        'stock' => $stock_counter_min,
                        'datein' => $datetime,
                    ]);
                }else{
                    $stock_counter_min = $stock_mitem_counter->stock - request('quantity_d')[$i];
                    DB::table('mitems_counters')
                    ->selectRaw('stock')
                    ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
                    ->where('name_mcounters', '=', request('counter_from'))
                    ->update([
                        'stock' => (int)$stock_counter_min,
                    ]);
                    $stock_counter_to_plus = $stock_mitem_counter_to->stock + request('quantity_d')[$i];
                    DB::table('mitems_counters')
                    ->selectRaw('stock')
                    ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
                    ->where('name_mcounters', '=', request('counter'))
                    ->update([
                        'stock' => (int)$stock_counter_to_plus,
                    ]);
                }
                $count++;
            }
        }
        
        if($count == $countrows){
            return redirect()->route('treturjuallist')->with('success', 'Data berhasil diupdate');
        }
    }

    public function delete(Tretur_h $treturh){
        $tretur_detail = Tretur_d::where('idh','=',$treturh->id)->get();
        foreach($tretur_detail as $tretur_old_item){
            // Mins a value from the old stock in mitems table
            // $stock_mitem = Mitem::select('stock')->where('code', '=',strtok($tretur_old_item->code, " "))->first();
            // $stock_mitem_sum = $stock_mitem->stock + (int)$tretur_old_item->qty;
            
            // Mitem::where('code', '=', strtok($tretur_old_item->code, " "))->update([
            //     'stock' => (int)$stock_mitem_sum,
            // ]);
            // Mins a value from the old stock in mitems_counters table
            $stock_mitem_counter = DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($tretur_old_item->code, " "))
            ->where('name_mcounters', '=', $treturh->counter_from)
            ->first();
            // dd($stock_mitem_counter);
            $stock_mitem_counter_sum = $stock_mitem_counter->stock + (int)$tretur_old_item->qty;
            // dd($stock_mitem_counter_sum);
            DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($tretur_old_item->code, " "))
            ->where('name_mcounters', '=', $treturh->counter_from)
            ->update([
                'stock' => (int)$stock_mitem_counter_sum,
            ]);
            $stock_mitem_counter_to = DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($tretur_old_item->code, " "))
            ->where('name_mcounters', '=', $treturh->counter)
            ->first();
            // dd($stock_mitem_counter);
            $stock_mitem_counter_to_min = $stock_mitem_counter_to->stock - (int)$tretur_old_item->qty;
            // dd($stock_mitem_counter_sum);
            DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($tretur_old_item->code, " "))
            ->where('name_mcounters', '=', $treturh->counter)
            ->update([
                'stock' => (int)$stock_mitem_counter_to_min,
            ]);
        }
        // Tretur_h::find($treturh->id)->delete();
        Tretur_h::where('id','=',$treturh->id)->delete();
        Tretur_d::where('idh','=',$treturh->id)->delete();

        return redirect()->route('treturjuallist')->with('success', 'Data berhasil dihapus');
    }
}
