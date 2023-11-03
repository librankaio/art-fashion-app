<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\MitemCounters;
use App\Models\Tsj_d;
use App\Models\Tsj_h;
use App\Models\Tsob_d;
use App\Models\Tsob_h;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ControllerTransSuratJalan extends Controller
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
        $sobs = Tsob_h::select('id','no','tgl','counter','note','grdtotal','user',)->whereNull('exist_sj')->get();
        $notrans = DB::select("select fgetcode('tsj') as codetrans");
        return view('pages.Transaksi.tsuratjalan',[
            'counters' => $counters,
            'mitems' => $mitems,
            'sobs' => $sobs,
            'notrans' => $notrans,
        ]);
    }

    public function post(Request $request){
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
        $checkexist = Tsj_h::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tsj_h::create([
                'no' => $request->no,
                'counter' => $request->counter,
                'counter_from' => $request->counter_from,
                'jenis' => $request->jenis,
                'tgl' => $request->dt,
                'note' => $request->note,
                'no_sob' => $request->nosob,
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
            ]);
            $idh_loop = Tsj_h::select('id')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }
    
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tsj_d::create([
                    'idh' => $idh,
                    'no_sj' => $request->no,
                    'code' => $request->kode_d[$i],
                    'name' => $request->namaitem_d[$i],
                    'warna' => $request->warna_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'satuan' => $request->satuan_d[$i],
                    'subtotal' => (float) str_replace(',', '', $request->subtot_d[$i]),
                    'hrgjual' => (float) str_replace(',', '', $request->hrgjual_d[$i]),
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
                // dd($stock_counter_min);
                $count++;
            }
            Tsob_h::where('no', '=', $request->nosob)->update([
                'exist_sj' => "Y",
            ]);
            if($count == $countrows){
                return redirect()->back()->with('success', 'Data berhasil ditambahkan');
            }
        }
        return redirect()->back()->with('error', 'Nomor transaksi sudah ada!');
    }

    public function getnosob(Request $request){
        $nosob = $request->nosob;
        if($nosob == ''){
            $items = Tsob_d::select('id','idh','no_sob','code','name','qty','satuan','hrgjual','subtotal')->get();
        }else{
            $items = Tsob_d::select('id','idh','no_sob','code','name','warna','qty','satuan','hrgjual','subtotal')->where('no_sob','=',$nosob)->get();
        }
        return json_encode($items);
    }

    public function getcounter(Request $request){
        $nosob = $request->nosob;
        if($nosob == ''){
            $items = Tsob_h::select('id','no','tgl','counter','note','grdtotal')->get();
        }else{
            $items = Tsob_h::select('id','no','tgl','counter','note','grdtotal')->where('no','=',$nosob)->get();
        }
        return json_encode($items);
    }

    public function list(){
        $tsjhs = Tsj_h::select('id','no','tgl','counter','note','grdtotal','user','no_sob')->orderBy('created_at', 'asc')->get();
        $tsjds = Tsj_d::select('id','idh','no_sj','code','name','qty','satuan','hrgjual','subtotal',)->get();
        return view('pages.Transaksi.tsuratjalanlist',[
            'tsjhs' => $tsjhs,
            'tsjds' => $tsjds
        ]);
    }

    public function getedit(Tsj_h $tsjh){
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        $mitems = Mitem::select('id','code','name')->get();
        $sobs = Tsob_h::select('id','no','tgl','counter','note','grdtotal','user',)->get();
        $tsjds = Tsj_d::select('id','idh','no_sj','code','name','warna','qty','satuan','hrgjual','subtotal',)->where('idh','=',$tsjh->id)->get();
        return view('pages.Transaksi.tsuratjalanedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'sobs' => $sobs,
            'tsjh' => $tsjh,
            'tsjds' => $tsjds,
        ]);
    }

    public function update(Tsj_h $tsjh){
        for($x=0;$x<sizeof(request('existdb_d'));$x++){
            $getstock_old = Tsj_d::where('id', '=', request('id_d')[$x])->first();
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
                // $getstock_old->qty is pembelian_d stock value
                $normalize_stock_counter = $old_stock_mitem_counter->stock+(int)$getstock_old->qty;
                // dd($normalize_stock_counter);
                DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($getstock_old->code, " "))
                ->where('name_mcounters', '=', request('counter_from'))
                ->update([
                    'stock' => (int)$normalize_stock_counter,
                ]);

                $stock_mitem_old = Mitem::select('stock')->where('code', '=', strtok($getstock_old->code, " "))->first();
                // Make stock mitem value is equal to mitem old stock
                // dd($stock_mitem_old->stock - (int)$getstock_old->qty);
                $normalize_stock_mitem = $stock_mitem_old->stock + (int)$getstock_old->qty;
                Mitem::where('code', '=', strtok($getstock_old->code, " "))->update([
                    'stock' => (int)$normalize_stock_mitem,
                ]);

                if(request('deleted_item_d') == request('id_d')[$x]){
                    Tsj_d::where('id','=',request('id_d')[$x])->delete();
                }
            }
        }

        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_sjh = request('no');
        }
        DB::delete('delete from tsj_ds where no_sj = ?', [$no_sjh] );
        Tsj_h::where('id', '=', $tsjh->id)->update([
            'no' => request('no'),
            'counter_from' => request('counter_from'),
            'counter' => request('counter'),
            'jenis' => request('jenis'),
            'tgl' => request('dt'),
            'note' => request('note'),
            'no_sob' => request('nosob'),
            'grdtotal' =>  (float) str_replace(',', '', request('price_total'))
        ]);

        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            if(request('deleted_item_d')[$i] != request('id_d')[$i]){
                Tsj_d::create([
                    'idh' => $tsjh->id,
                    'no_sj' => request('no'),
                    'code' => request('kode_d')[$i],
                    'name' => request('namaitem_d')[$i],
                    'warna' => request('warna_d')[$i],
                    'qty' => request('quantity_d')[$i],
                    'satuan' => request('satuan_d')[$i],
                    'hrgjual' => (float) str_replace(',', '', request('hrgjual_d')[$i]),
                    'subtotal' => (float) str_replace(',', '', request('subtot_d')[$i])
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
                }
                // dd($stock_mitem_counter);
                $count++;
            }
        }
        return redirect()->route('tsuratjalanlist')->with('success', 'Data berhasil diupdate');
        // if($count == $countrows){
        //     return redirect()->route('tsuratjalanlist');
        // }
    }

    public function delete(Tsj_h $tsjh){
        $suratjalan_detail = Tsj_d::where('idh','=',$tsjh->id)->get();
        foreach($suratjalan_detail as $suratjalan_old_item){
            // Mins a value from the old stock in mitems table
            $stock_mitem = Mitem::select('stock')->where('code', '=',strtok($suratjalan_old_item->code, " "))->first();
            $stock_mitem_sum = $stock_mitem->stock + (int)$suratjalan_old_item->qty;
            
            Mitem::where('code', '=', strtok($suratjalan_old_item->code, " "))->update([
                'stock' => (int)$stock_mitem_sum,
            ]);
            // Mins a value from the old stock in mitems_counters table
            $stock_mitem_counter = DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($suratjalan_old_item->code, " "))
            ->where('name_mcounters', '=', $tsjh->counter_from)
            ->first();
            // dd($stock_mitem_counter);
            $stock_mitem_counter_sum = $stock_mitem_counter->stock + (int)$suratjalan_old_item->qty;
            // dd($stock_mitem_counter_sum);
            DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($suratjalan_old_item->code, " "))
            ->where('name_mcounters', '=', $tsjh->counter_from)
            ->update([
                'stock' => (int)$stock_mitem_counter_sum,
            ]);
        }

        $tsj = Tsj_h::where('id','=',$tsjh->id)->first();
        $sobh = Tsob_h::where('no', '=', $tsj->no_sob)->first();
        Tsob_h::where('no', '=', $tsj->no_sob)->update([
            'exist_sj' => NULL,
        ]);
        // dd($tsjh->no_sob);
        Tsj_h::where('id','=',$tsjh->id)->delete();
        Tsj_d::where('idh','=',$tsjh->id)->delete();

        return redirect()->route('tsuratjalanlist')->with('success', 'Data berhasil dihapus');
    }

    public function print(Tsj_h $tsjh){
        $tsjds = Tsj_d::where('idh','=',$tsjh->id)->get();
        $address = Mcounter::select('alamat')->where('name','=',$tsjh->counter)->first();
        
        $array_warna = [];
        foreach($tsjds as $tsjd){
            $warna = Mitem::where('code', '=', $tsjd->code)->first();
            // dd($warna);
            $tsjd['warna'] = $warna->warna;
        }

        // dd($tsjds);
        return view('pages.Print.tsuratjalanprint',[
            'tsjh' => $tsjh,
            'tsjds' => $tsjds,
            'address' => $address
        ]);
    }

    public function printItem(Tsj_h $tsjh){
        $items = Tsj_d::where('idh','=',$tsjh->id)->get();
        // dd($items);
        $array_name_lbl = [];
        
        foreach($items as $item){
            $name_lbl = Mitem::where('code', '=', $item->code)->first();
            // array_push($items, $name_lbl->name_lbl);
            // $items->put('name_lbl', $name_lbl->name_lbl);
            $item['name_lbl'] = $name_lbl->name_lbl;
        }
        // dd($items);
        $datenow = date("Y-m-d");
        $customPaper = array(0,0,85.039,141.732);
        $pdf = Pdf::loadView('pages.Print.tsuratjalanprintitem', [
            'items'=>$items,
            'array_name_lbl'=>$array_name_lbl])->setPaper($customPaper, 'portrait');
        return $pdf->stream($datenow."_NOSJ/".$tsjh->no);
    }
}
