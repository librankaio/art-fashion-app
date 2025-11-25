<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\MitemCounters;
use App\Models\MutasiAF;
use App\Models\Tadj_d;
use App\Models\Tadj_h;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransAdjustmentStock extends Controller
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
        $notrans = DB::select("select fgetcode('tadj') as codetrans");
        return view('pages.Transaksi.tadjustmentstock',[
            'counters' => $counters,
            'mitems' => $mitems,
            'notrans' => $notrans,
        ]);
    }

    // public function post(Request $request){
    //     $notrans = DB::select("select fgetcode('tadj') as codetrans");

    //     foreach($notrans as $notran){
    //         $no = $notran->codetrans;
    //     }

    //     $checkexist = Tadj_h::select('id','no')->where('no','=', $no)->first();
    //     if($checkexist == null){
    //         Tadj_h::create([
    //             'no' => $no,
    //             'tgl' => $request->dt,
    //             'counter' => $request->counter,
    //             'jenis' => $request->jenis,
    //             'note' => $request->note,
    //         ]);
    //         $idh_loop = Tadj_h::select('id')->where('no','=',$no)->get();
    //         for($j=0; $j<sizeof($idh_loop); $j++){
    //             $idh = $idh_loop[$j]->id;
    //         }
    
    //         $countrows = sizeof($request->no_d);
    //         $count=0;
    //         for ($i=0;$i<sizeof($request->no_d);$i++){
    //             Tadj_d::create([
    //                 'idh' => $idh,
    //                 'no_adj' => $no,
    //                 'code' => $request->kode_d[$i],
    //                 'name' => $request->nama_item_d[$i],
    //                 'warna' => $request->warna_d[$i],
    //                 'qty' => $request->quantity_d[$i],
    //                 'satuan' => $request->satuan_d[$i],
    //             ]);
    //             $mcounter = Mcounter::where('name', '=', $request->counter)->first();

    //             if ($request->jenis == 'Plus'){
    //                 $stock_mitem_counter = DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
    //                 ->where('name_mcounters', '=', $request->counter)
    //                 ->first();
    //                 // dd($stock_mitem_counter);
    //                 $stock_counter_sum = $stock_mitem_counter->stock+$request->quantity_d[$i];
    //                 DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
    //                 ->where('name_mcounters', '=', $request->counter)
    //                 ->update([
    //                     'stock' => (int)$stock_counter_sum,
    //                 ]);
    //                 $mcounter = Mcounter::where('name', '=', $request->counter)->first();
    //                 MutasiAF::create([  
    //                     'code_mitem' => strtok($request->kode_d[$i], " "),
    //                     'code_mcounters' => $mcounter->code,
    //                     'qty' => $request->quantity_d[$i],
    //                     'notrans' => $request->no,
    //                     'doctype' => "ADJUSTMENT",
    //                     'jenis' => "PLUS",
    //                     'action' => "CREATE",
    //                     'user' => session('nik'),
    //                 ]);
    //             }else if ($request->jenis == 'Minus'){
    //                 $stock_mitem_counter = DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
    //                 ->where('name_mcounters', '=', $request->counter)
    //                 ->first();
    //                 $stock_counter_min = $stock_mitem_counter->stock-$request->quantity_d[$i];
    //                 DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
    //                 ->where('name_mcounters', '=', $request->counter)
    //                 ->update([
    //                     'stock' => (int)$stock_counter_min,
    //                 ]);
    //                 MutasiAF::create([  
    //                     'code_mitem' => strtok($request->kode_d[$i], " "),
    //                     'code_mcounters' => $mcounter->code,
    //                     'qty' => $request->quantity_d[$i],
    //                     'notrans' => $request->no,
    //                     'doctype' => "ADJUSTMENT",
    //                     'jenis' => "MINUS",
    //                     'action' => "CREATE",
    //                     'user' => session('nik'),
    //                 ]);                   
    //             }
    //             $count++;
    //         }
    //         if($count == $countrows){
    //             return redirect()->back()->with('success', 'Data berhasil disimpan');
    //         }
    //     }
    //     return redirect()->back()->with('error', 'Nomer Transaksi sudah ada!');
    // }

    public function post(Request $request)
    {
        DB::beginTransaction(); // ⬅️ mulai transaksi

        try {

            $notrans = DB::select("select fgetcode('tadj') as codetrans");
            foreach ($notrans as $notran) {
                $no = $notran->codetrans;
            }

            // ⛔ Mencegah double transaksi jika user klik 2 kali
            if (Tadj_h::where('no', $no)->exists()) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Nomor transaksi sudah ada!');
            }

            // INSERT HEADER
            $header = Tadj_h::create([
                'no' => $no,
                'tgl' => $request->dt,
                'counter' => $request->counter,
                'jenis' => $request->jenis,
                'note' => $request->note,
            ]);

            $idh = $header->id;
            $mcounter = Mcounter::where('name', $request->counter)->first();

            // INSERT DETAIL & APPLY STOCK
            for ($i = 0; $i < sizeof($request->no_d); $i++) {

                Tadj_d::create([
                    'idh' => $idh,
                    'no_adj' => $no,
                    'code' => $request->kode_d[$i],
                    'name' => $request->nama_item_d[$i],
                    'warna' => $request->warna_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'satuan' => $request->satuan_d[$i],
                ]);

                $code = strtok($request->kode_d[$i], " ");

                $stock_mitem_counter = DB::table('mitems_counters')
                    ->where('code_mitem', $code)
                    ->where('name_mcounters', $request->counter)
                    ->lockForUpdate() // ⬅️ cegah race condition (2 user update stok bersamaan)
                    ->first();

                if (!$stock_mitem_counter) {
                    throw new \Exception("Stock counter tidak ditemukan");
                }

                if ($request->jenis == 'Plus') {
                    $new_stock = $stock_mitem_counter->stock + $request->quantity_d[$i];
                    $mutasi_jenis = "PLUS";
                } else {
                    $new_stock = $stock_mitem_counter->stock - $request->quantity_d[$i];

                    if ($new_stock < 0) {
                        throw new \Exception("Stok tidak mencukupi untuk item $code !");
                    }

                    $mutasi_jenis = "MINUS";
                }

                DB::table('mitems_counters')
                    ->where('code_mitem', $code)
                    ->where('name_mcounters', $request->counter)
                    ->update(['stock' => (int)$new_stock]);

                // INSERT MUTASI
                MutasiAF::create([
                    'code_mitem' => $code,
                    'code_mcounters' => $mcounter->code,
                    'qty' => $request->quantity_d[$i],
                    'notrans' => $no,
                    'doctype' => "ADJUSTMENT",
                    'jenis' => $mutasi_jenis,
                    'action' => "CREATE",
                    'user' => session('nik'),
                ]);
            }

            DB::commit(); // ⬅️ semua OK → simpan

            return redirect()->back()->with('success', 'Data berhasil disimpan');

        } catch (\Throwable $err) {

            DB::rollBack(); // ⬅️ terjadi error → batalkan semuanya

            return redirect()->back()->with('error',
                'Gagal menyimpan data! ' . $err->getMessage()
            );
        }
    }

    public function list(){
        $tadjhs = Tadj_h::select('id','no','tgl','note','counter')->orderBy('created_at', 'asc')->get();
        $tadjds = Tadj_d::select('id','idh','no_adj','code','name','qty','satuan')->get();
        return view('pages.Transaksi.tadjustmentstocklist',[
            'tadjhs' => $tadjhs,
            'tadjds' => $tadjds
        ]);
    }

    public function getedit(Tadj_h $tadjh){
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        $mitems = Mitem::select('id','code','name')->get();
        $tadjs = Tadj_d::select('id','idh','no_adj','code','name','warna','qty','satuan',)->where('idh','=',$tadjh->id)->get();
        return view('pages.Transaksi.tadjustmentstockedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'tadjh' => $tadjh,
            'tadjs' => $tadjs,
        ]);
    }

    // public function update(Tadj_h $tadjh){
    //     if (request('jenis') == 'Plus'){
    //         for($x=0;$x<sizeof(request('existdb_d'));$x++){
    //             $getstock_old = Tadj_d::where('id', '=', request('id_d')[$x])->first();
    //             if ($getstock_old != null){
    //                 $old_stock_mitem_counter = DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok($getstock_old->code, " "))
    //                 ->where('name_mcounters', '=', request('counter'))
    //                 ->first();

    //                 // Make stock counter value is equal to old stock
    //                 // $getstock_old->qty is pembelian_d stock value

    //                 $normalize_stock_counter = $old_stock_mitem_counter->stock - (int)$getstock_old->qty;
    //                 DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok($getstock_old->code, " "))
    //                 ->where('name_mcounters', '=', request('counter'))
    //                 ->update([
    //                     'stock' => (int)$normalize_stock_counter,
    //                 ]);

    //                 $stock_mitem_old = Mitem::select('stock')->where('code', '=', strtok($getstock_old->code, " "))->first();
    //                 // Make stock mitem value is equal to mitem old stock
    //                 $normalize_stock_mitem = $stock_mitem_old->stock - (int)$getstock_old->qty;
    //                 Mitem::where('code', '=', strtok($getstock_old->code, " "))->update([
    //                     'stock' => (int)$normalize_stock_mitem,
    //                 ]);
    
    //                 if(request('deleted_item_d') == request('id_d')[$x]){
    //                     Tadj_d::where('id','=',request('id_d')[$x])->delete();
    //                 }
    //             }
    //         }
    //     }else if(request('jenis') == 'Minus'){
    //         for($x=0;$x<sizeof(request('existdb_d'));$x++){
    //             $getstock_old = Tadj_d::where('id', '=', request('id_d')[$x])->first();
    //             if ($getstock_old != null){
    //                 $old_stock_mitem_counter = DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok($getstock_old->code, " "))
    //                 ->where('name_mcounters', '=', request('counter'))
    //                 ->first();

    //                 // Make stock counter value is equal to old stock
    //                 // $getstock_old->qty is pembelian_d stock value

    //                 $normalize_stock_counter = $old_stock_mitem_counter->stock + (int)$getstock_old->qty;
    //                 DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok($getstock_old->code, " "))
    //                 ->where('name_mcounters', '=', request('counter'))
    //                 ->update([
    //                     'stock' => (int)$normalize_stock_counter,
    //                 ]);
    
    //                 $stock_mitem_old = Mitem::select('stock')->where('code', '=', strtok($getstock_old->code, " "))->first();
    //                 // Make stock mitem value is equal to mitem old stock
    //                 $normalize_stock_mitem = $stock_mitem_old->stock + (int)$getstock_old->qty;
    //                 Mitem::where('code', '=', strtok($getstock_old->code, " "))->update([
    //                     'stock' => (int)$normalize_stock_mitem,
    //                 ]);
    
    //                 if(request('deleted_item_d') == request('id_d')[$x]){
    //                     Tadj_d::where('id','=',request('id_d')[$x])->delete();
    //                 }
    //             }
    //         }
    //     }

    //     for($j=0;$j<sizeof(request('no_d'));$j++){
    //         $no_adj = request('no');
    //     }
    //     DB::delete('delete from tadj_ds where no_adj = ?', [$no_adj] );
    //     Tadj_h::where('id', '=', $tadjh->id)->update([
    //         'no' => request('no'),
    //         'tgl' => request('dt'),
    //         'counter' => request('counter'),
    //         'jenis' => request('jenis'),
    //         'note' => request('note'),
    //     ]);
    //     $count=0;      
    //     $counting_item = 0;  
    //     for ($i=0;$i<sizeof(request('no_d'));$i++){
    //         if(request('deleted_item_d')[$i] != request('id_d')[$i]){
    //             Tadj_d::create([
    //                 'idh' => $tadjh->id,
    //                 'no_adj' => request('no'),
    //                 'code' => request('kode_d')[$i],
    //                 'name' => request('nama_item_d')[$i],
    //                 'warna' => request('warna_d')[$i],
    //                 'qty' => request('quantity_d')[$i],
    //                 'satuan' => request('satuan_d')[$i],
    //             ]);
    //             $counting_item++;
    //             $mcounter = Mcounter::where('name', '=', request('counter'))->first();
    //             if (request('jenis') == 'Plus'){
    //                 $stock_mitem_counter = DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
    //                 ->where('name_mcounters', '=', request('counter'))
    //                 ->first();
    //                 $stock_counter_sum = $stock_mitem_counter->stock+request('quantity_d')[$i];
    //                 DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
    //                 ->where('name_mcounters', '=', request('counter'))
    //                 ->update([
    //                     'stock' => (int)$stock_counter_sum,
    //                 ]); 
    //                 $mcounter = Mcounter::where('name', '=', request('counter'))->first();
    //                 MutasiAF::create([  
    //                     'code_mitem' => strtok(request('kode_d')[$i], " "),
    //                     'code_mcounters' => $mcounter->code,
    //                     'qty' => request('quantity_d')[$i],
    //                     'notrans' => request('no'),
    //                     'doctype' => "ADJUSTMENT",
    //                     'jenis' => "ADJUST-PLUS",
    //                     'action' => "UPDATE",
    //                     'user' => session('nik'),
    //                 ]);
    //             }else if(request('jenis') == 'Minus'){
    //                 $stock_mitem_counter = DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
    //                 ->where('name_mcounters', '=', request('counter'))
    //                 ->first();
    //                 // dd($stock_mitem_counter);
    //                 $stock_counter_min = $stock_mitem_counter->stock-request('quantity_d')[$i];
    //                 DB::table('mitems_counters')
    //                 ->selectRaw('stock')
    //                 ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
    //                 ->where('name_mcounters', '=', request('counter'))
    //                 ->update([
    //                     'stock' => (int)$stock_counter_min,
    //                 ]); 
    //                 $mcounter = Mcounter::where('name', '=', request('counter'))->first();
    //                 MutasiAF::create([  
    //                     'code_mitem' => strtok(request('kode_d')[$i], " "),
    //                     'code_mcounters' => $mcounter->code,
    //                     'qty' => request('quantity_d')[$i],
    //                     'notrans' => request('no'),
    //                     'doctype' => "ADJUSTMENT",
    //                     'jenis' => "ADJUST-MINUS",
    //                     'action' => "UPDATE",
    //                     'user' => session('nik'),
    //                 ]);
    //                     // DB::update('CALL sminstock  (?,?,?)', [ strtok(request('kode_d')[$i], " "), $mcounter->code, request('quantity_d')[$i]]);
    //             }
    //             $count++;
    //         }
    //     }
    //     return redirect()->route('tadjlist')->with('success', 'Data berhasil di update');
    // }
    public function update(Tadj_h $tadjh)
    {
        DB::beginTransaction(); // ⬅️ mulai transaksi

        try {

            // REVERSE ADJ OLD DETAIL
            for($x = 0; $x < sizeof(request('existdb_d')); $x++){
                $getstock_old = Tadj_d::where('id', request('id_d')[$x])->first();
                if (!$getstock_old) continue;

                $code = strtok($getstock_old->code, " ");
                $oldCounter = DB::table('mitems_counters')
                    ->where('code_mitem', $code)
                    ->where('name_mcounters', request('counter'))
                    ->first();

                if (!$oldCounter) throw new \Exception("Stock counter tidak ditemukan!");

                if (request('jenis') == 'Plus'){
                    // PLUS berarti sebelumnya stok bertambah → sekarang harus dikurangi
                    $normalize_counter = $oldCounter->stock - (int)$getstock_old->qty;
                    $normalize_mitem = Mitem::where('code', $code)->first()->stock - (int)$getstock_old->qty;
                } else {
                    // MINUS berarti sebelumnya stok berkurang → sekarang harus ditambah
                    $normalize_counter = $oldCounter->stock + (int)$getstock_old->qty;
                    $normalize_mitem = Mitem::where('code', $code)->first()->stock + (int)$getstock_old->qty;
                }

                DB::table('mitems_counters')
                    ->where('code_mitem', $code)
                    ->where('name_mcounters', request('counter'))
                    ->update(['stock' => (int)$normalize_counter]);

                Mitem::where('code', $code)->update(['stock' => (int)$normalize_mitem]);

                if (request('deleted_item_d') == request('id_d')[$x]){
                    Tadj_d::where('id', request('id_d')[$x])->delete();
                }
            }

            // UPDATE HEADER
            Tadj_h::where('id', $tadjh->id)->update([
                'no' => request('no'),
                'tgl' => request('dt'),
                'counter' => request('counter'),
                'jenis' => request('jenis'),
                'note' => request('note'),
            ]);

            // DELETE ALL OLD DETAIL
            DB::table('tadj_ds')->where('no_adj', request('no'))->delete();

            // INSERT NEW DETAIL + APPLY STOCK
            for ($i = 0; $i < sizeof(request('no_d')); $i++){
                if(request('deleted_item_d')[$i] == request('id_d')[$i]) continue;

                Tadj_d::create([
                    'idh' => $tadjh->id,
                    'no_adj' => request('no'),
                    'code' => request('kode_d')[$i],
                    'name' => request('nama_item_d')[$i],
                    'warna' => request('warna_d')[$i],
                    'qty' => request('quantity_d')[$i],
                    'satuan' => request('satuan_d')[$i],
                ]);

                $code = strtok(request('kode_d')[$i], " ");
                $mcounter = Mcounter::where('name', request('counter'))->first();

                $stockCounter = DB::table('mitems_counters')
                    ->where('code_mitem', $code)
                    ->where('name_mcounters', request('counter'))
                    ->first();

                if (!$stockCounter) throw new \Exception("Stock counter tidak ditemukan!");

                if (request('jenis') == 'Plus'){
                    $new_counter_stock = $stockCounter->stock + request('quantity_d')[$i];
                    $mutasi_jenis = "ADJUST-PLUS";
                } else {
                    $new_counter_stock = $stockCounter->stock - request('quantity_d')[$i];
                    $mutasi_jenis = "ADJUST-MINUS";
                }

                DB::table('mitems_counters')
                    ->where('code_mitem', $code)
                    ->where('name_mcounters', request('counter'))
                    ->update(['stock' => (int)$new_counter_stock]);

                MutasiAF::create([
                    'code_mitem' => $code,
                    'code_mcounters' => $mcounter->code,
                    'qty' => request('quantity_d')[$i],
                    'notrans' => request('no'),
                    'doctype' => "ADJUSTMENT",
                    'jenis' => $mutasi_jenis,
                    'action' => "UPDATE",
                    'user' => session('nik'),
                ]);
            }

            DB::commit(); // ⬅️ semua sukses

            return redirect()->route('tadjlist')->with('success', 'Data berhasil di update');

        } catch (\Throwable $err) {

            DB::rollBack(); // ⬅️ kalau error → batal semua

            return redirect()->route('tadjlist')
                ->with('error', 'Update gagal / koneksi jelek! Semua perubahan dibatalkan.');
        }
    }

    // public function delete(Tadj_h $tadjh){
    //     $tadj_length = Tadj_d::where('idh', '=', $tadjh->id)->get();
    //     if ($tadjh->jenis == 'Plus'){
    //         for($x=0;$x<sizeof($tadj_length);$x++){
    //             // dd($tadj_length[$x]->id);
    //             $getstock_old = Tadj_d::where('id', '=', $tadj_length[$x]->id)->first();
    //             $old_stock_mitem_counter = DB::table('mitems_counters')
    //             ->selectRaw('stock')
    //             ->where('code_mitem', '=', strtok($tadj_length[$x]->code, " "))
    //             ->where('name_mcounters', '=', $tadjh->counter)
    //             ->first();

    //                 // Make stock counter value is equal to old stock
    //                 // $getstock_old->qty is pembelian_d stock value

    //             $normalize_stock_counter = $old_stock_mitem_counter->stock - (int)$getstock_old->qty;
                
    //             DB::table('mitems_counters')
    //             ->selectRaw('stock')
    //             ->where('code_mitem', '=', strtok($tadj_length[$x]->code, " "))
    //             ->where('name_mcounters', '=', $tadjh->counter)
    //             ->update([
    //                 'stock' => (int)$normalize_stock_counter,
    //             ]);

    //             $mcounter = Mcounter::where('name', '=', $tadjh->counter)->first();
    //             MutasiAF::create([  
    //                 'code_mitem' => strtok($tadj_length[$x]->code, " "),
    //                 'code_mcounters' => $mcounter->code,
    //                 'qty' => (int)$getstock_old->qty,
    //                 'notrans' => $tadjh->no,
    //                 'doctype' => "ADJUSTMENT",
    //                 'jenis' => "ADJUSTMENT-MINUS",
    //                 'action' => "DELETE",
    //                 'user' => session('nik'),
    //             ]);
    
    //             $stock_mitem_old = Mitem::select('stock')->where('code', '=', strtok($getstock_old->code, " "))->first();
    //                 // Make stock mitem value is equal to mitem old stock
    //             $normalize_stock_mitem = $stock_mitem_old->stock - (int)$getstock_old->qty;
    //             Mitem::where('code', '=', strtok($getstock_old->code, " "))->update([
    //                 'stock' => (int)$normalize_stock_mitem,
    //             ]);
    //         }
    //     }else if($tadjh->jenis == 'Minus'){
    //         for($x=0;$x<sizeof($tadj_length);$x++){
    //             $getstock_old = Tadj_d::where('id', '=', $tadj_length[$x]->id)->first();
    //             $old_stock_mitem_counter = DB::table('mitems_counters')
    //             ->selectRaw('stock')
    //             ->where('code_mitem', '=', strtok($tadj_length[$x]->code, " "))
    //             ->where('name_mcounters', '=', $tadjh->counter)
    //             ->first();
    //             // Make stock counter value is equal to old stock
    //             // $getstock_old->qty is pembelian_d stock value
    //             $normalize_stock_counter = $old_stock_mitem_counter->stock + (int)$getstock_old->qty;
    //             DB::table('mitems_counters')
    //             ->selectRaw('stock')
    //             ->where('code_mitem', '=', strtok($tadj_length[$x]->code, " "))
    //             ->where('name_mcounters', '=', $tadjh->counter)
    //             ->update([
    //                 'stock' => (int)$normalize_stock_counter,
    //             ]);

    //             $mcounter = Mcounter::where('name', '=', $tadjh->counter)->first();
    //             MutasiAF::create([  
    //                 'code_mitem' => strtok($tadj_length[$x]->code, " "),
    //                 'code_mcounters' => $mcounter->code,
    //                 'qty' => (int)$getstock_old->qty,
    //                 'notrans' => $tadjh->no,
    //                 'doctype' => "ADJUSTMENT",
    //                 'jenis' => "ADJUSTMENT-PLUS",
    //                 'action' => "DELETE",
    //                 'user' => session('nik'),
    //             ]);
    
    //             $stock_mitem_old = Mitem::select('stock')->where('code', '=', strtok($getstock_old->code, " "))->first();
    //             // Make stock mitem value is equal to mitem old stock
    //             // dd($stock_mitem_old->stock - (int)$getstock_old->qty);
    //             $normalize_stock_mitem = $stock_mitem_old->stock + (int)$getstock_old->qty;
    //             Mitem::where('code', '=', strtok($getstock_old->code, " "))->update([
    //                 'stock' => (int)$normalize_stock_mitem,
    //             ]);
    //         }
    //     }
        
    //     Tadj_h::find($tadjh->id)->delete();
    //     Tadj_d::where('idh','=',$tadjh->id)->delete();


    //     return redirect()->route('tadjlist')->with('success', 'Data berhasil di hapus');
    // }
    public function delete(Tadj_h $tadjh)
    {
        DB::beginTransaction(); // ⬅️ mulai transaksi

        try {

            $tadj_length = Tadj_d::where('idh', $tadjh->id)
                ->lockForUpdate() // ⬅️ cegah stok berubah oleh transaksi lain
                ->get();

            foreach ($tadj_length as $row) {

                $getstock_old = $row;
                $codeItem = strtok($row->code, " ");

                // ambil stok counter
                $old_stock_mitem_counter = DB::table('mitems_counters')
                    ->where('code_mitem', $codeItem)
                    ->where('name_mcounters', $tadjh->counter)
                    ->lockForUpdate()
                    ->first();

                // ambil stok mitem
                $stock_mitem_old = Mitem::where('code', $codeItem)
                    ->lockForUpdate()
                    ->first();

                if ($tadjh->jenis === 'Plus') {
                    // Adjustment PLUS → delete berarti stok harus dikurangi
                    $normalize_stock_counter = $old_stock_mitem_counter->stock - $getstock_old->qty;
                    $normalize_stock_mitem   = $stock_mitem_old->stock - $getstock_old->qty;
                    $jenis_mutasi = "ADJUSTMENT-MINUS";

                } else { // jenis MINUS
                    // Adjustment MINUS → delete berarti stok harus dikembalikan (ditambah)
                    $normalize_stock_counter = $old_stock_mitem_counter->stock + $getstock_old->qty;
                    $normalize_stock_mitem   = $stock_mitem_old->stock + $getstock_old->qty;
                    $jenis_mutasi = "ADJUSTMENT-PLUS";
                }

                // Update stok counter
                DB::table('mitems_counters')
                    ->where('code_mitem', $codeItem)
                    ->where('name_mcounters', $tadjh->counter)
                    ->update(['stock' => (int) $normalize_stock_counter]);

                // Update stok mitem
                Mitem::where('code', $codeItem)
                    ->update(['stock' => (int) $normalize_stock_mitem]);

                // Insert mutasi
                $mcounter = Mcounter::where('name', $tadjh->counter)->first();
                MutasiAF::create([
                    'code_mitem' => $codeItem,
                    'code_mcounters' => $mcounter->code,
                    'qty' => $getstock_old->qty,
                    'notrans' => $tadjh->no,
                    'doctype' => "ADJUSTMENT",
                    'jenis' => $jenis_mutasi,
                    'action' => "DELETE",
                    'user' => session('nik'),
                ]);
            }

            // Delete header & detail
            Tadj_d::where('idh', $tadjh->id)->delete();
            Tadj_h::find($tadjh->id)->delete();

            DB::commit(); // ⬅️ success
            return redirect()->route('tadjlist')->with('success', 'Data berhasil dihapus');

        } catch (\Throwable $th) {
            DB::rollBack(); // ⬅️ kalau gagal semua dibatalkan
            return redirect()->route('tadjlist')
                ->with('error', 'Gagal menghapus data: ' . $th->getMessage());
        }
    }
}
