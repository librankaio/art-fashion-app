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

class ControllerTransSuratJalan extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
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
        // dd($request->all());

        $checkexist = Tsj_h::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tsj_h::create([
                'no' => $request->no,
                'counter' => $request->counter,
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
                Mitem::where('code', '=', strtok($request->kode_d[$i], " "))->update([
                    'stock' => (int)$stock_min,
                ]);
                $stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', session('counter'))
                ->first();
                $stock_counter_min = $stock_mitem_counter->stock-$request->quantity_d[$i];
                DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', session('counter'))
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
        return redirect()->back();
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
        $tsjhs = Tsj_h::select('id','no','tgl','counter','note','grdtotal','user',)->orderBy('created_at', 'asc')->get();
        $tsjds = Tsj_d::select('id','idh','no_sj','code','name','qty','satuan','hrgjual','subtotal',)->get();
        return view('pages.Transaksi.tsuratjalanlist',[
            'tsjhs' => $tsjhs,
            'tsjds' => $tsjds
        ]);
    }

    public function getedit(Tsj_h $tsjh){
        $counters = Mcounter::select('id','code','name')->get();
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
        // for($x=0;$x<sizeof(request('id_d'));$x++){
        //     $getstock_old = Tsj_d::where('id', '=', request('id_d')[$x])->first();
        //     // dd((int)$getstock_old->qty);
        //     // dd($getstock_old->code);
        //     $old_stock_mitem_counter = DB::table('mitems_counters')
        //     ->selectRaw('stock')
        //     ->where('code_mitem', '=', strtok($getstock_old->code, " "))
        //     ->where('name_mcounters', '=', session('counter'))
        //     ->first();
        //     // dd($old_stock_mitem_counter->stock-(int)$getstock_old->qty);
        //     // Make stock counter value is equal to old stock
        //     $normalize_stock_counter = $old_stock_mitem_counter->stock-(int)$getstock_old->qty;
        //     DB::table('mitems_counters')
        //     ->selectRaw('stock')
        //     ->where('code_mitem', '=', strtok($getstock_old->code, " "))
        //     ->where('name_mcounters', '=', session('counter'))
        //     ->update([
        //         'stock' => (int)$normalize_stock_counter,
        //     ]);

        //     $stock_mitem_old = Mitem::select('stock')->where('code', '=', strtok($getstock_old->code, " "))->first();
        //     // Make stock mitem value is equal to mitem old stock
        //     // dd($stock_mitem_old->stock - (int)$getstock_old->qty);
        //     $normalize_stock_mitem = $stock_mitem_old->stock - (int)$getstock_old->qty;
        //     Mitem::where('code', '=', strtok($getstock_old->code, " "))->update([
        //         'stock' => (int)$normalize_stock_mitem,
        //     ]);
        // }
        for($x=0;$x<sizeof(request('existdb_d'));$x++){
            $getstock_old = Tsj_d::where('id', '=', request('id_d')[$x])->first();
            if ($getstock_old != null){
                // dd($getstock_old);
                // dd((int)$getstock_old->qty);
                // dd($getstock_old->code);
                $old_stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($getstock_old->code, " "))
                ->where('name_mcounters', '=', session('counter'))
                ->first();
                // dd($old_stock_mitem_counter->stock-(int)$getstock_old->qty);
                // Make stock counter value is equal to old stock
                // $getstock_old->qty is pembelian_d stock value
                $normalize_stock_counter = $old_stock_mitem_counter->stock+(int)$getstock_old->qty;
                // dd($normalize_stock_counter);
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
                ->where('name_mcounters', '=', session('counter'))
                ->first();

                $mcounter = Mcounter::where('name', '=', session('counter'))->first();

                if ($stock_mitem_counter == null) {
                    $stock_mitem_counter = 0;
                    $stock_counter_min = $stock_mitem_counter - request('quantity_d')[$i];
                    date_default_timezone_set('Asia/Jakarta');
                    $datetime = date('d-m-Y H:i:s');
                    MitemCounters::create([
                        'code_mitem' => strtok(request('kode_d')[$i], " "),
                        'name_mitem' => request('nama_item_d')[$i],
                        'code_mcounters' => $mcounter->code,
                        'name_mcounters' => session('counter'),
                        'stock' => $stock_counter_min,
                        'datein' => $datetime,
                    ]);
                }else{
                    $stock_counter_min = $stock_mitem_counter->stock - request('quantity_d')[$i];
                    DB::table('mitems_counters')
                    ->selectRaw('stock')
                    ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
                    ->where('name_mcounters', '=', session('counter'))
                    ->update([
                        'stock' => (int)$stock_counter_min,
                    ]);
                }
                // dd($stock_mitem_counter);
                $count++;
            }
        }
        return redirect()->route('tsuratjalanlist');
        // if($count == $countrows){
        //     return redirect()->route('tsuratjalanlist');
        // }
    }

    public function delete(Tsj_h $tsjh){
        $tsj = Tsj_h::where('id','=',$tsjh->id)->first();
        $sobh = Tsob_h::where('no', '=', $tsj->no_sob)->first();
        Tsob_h::where('no', '=', $tsj->no_sob)->update([
            'exist_sj' => NULL,
        ]);
        // dd($tsjh->no_sob);
        Tsj_h::where('id','=',$tsjh->id)->delete();
        Tsj_d::where('idh','=',$tsjh->id)->delete();

        return redirect()->route('tsuratjalanlist');
    }

    public function print(Tsj_h $tsjh){
        // dd($tsjh->id);
        $tsjds = Tsj_d::where('idh','=',$tsjh->id)->get();
        
        // dd($tsjds);
        return view('pages.Print.tsuratjalanprint',[
            'tsjh' => $tsjh,
            'tsjds' => $tsjds
        ]);
    }

    public function printItem(Tsj_h $tsjh){
        $items = Tsj_d::where('idh','=',$tsjh->id)->get();
        $datenow = date("Y-m-d");
        $customPaper = array(0,0,85.039,141.732);
        $pdf = Pdf::loadView('pages.Print.tsuratjalanprintitem', array('items'=>$items))->setPaper($customPaper, 'landscape');
        return $pdf->stream($datenow."_NOSJ/".$tsjh->no);
    }
}
