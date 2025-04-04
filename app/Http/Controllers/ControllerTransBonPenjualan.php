<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\MitemCounters;
use App\Models\Mjenispayment;
use App\Models\MsaldoAwal;
use App\Models\MutasiAF;
use App\Models\Tpenjualan_d;
use App\Models\Tpenjualan_h;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ControllerTransBonPenjualan extends Controller
{
    public function index()
    {
        $privilage = session('privilage');
        $counter_name = session('counter');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        date_default_timezone_set('Asia/Jakarta');
        $today_saldo = MsaldoAwal::select('tgl','saldo','counter')->where('counter','=',session('counter'))->where('tgl','=',date("Y-m-d"))->first();
        // dd($today_saldo);
        if ($today_saldo == null){
            $today_saldo = "N";
        }else{
            $today_saldo = "Y";
        }
        // dd($today_saldo);
        // $mitems = Mitem::select('id','code','name')->get();
        // $mitems = DB::select( DB::raw("SELECT * FROM some_table WHERE some_col = '$someVariable'") );
        
        // $mitems = DB::select( DB::raw("SELECT DISTINCT p.code , p.name FROM mitems p JOIN mitems_counters s ON p.code = s.code_mitem WHERE s.name_mcounters = '$counter_name' "));
        // $mitems = DB::select(DB::raw("select code_mitem as code, name_mitem as name from mitems_counters where name_mcounters = '$counter_name' and stock > 0"));
        $latest_counter = Tpenjualan_h::select('counter')->where('user','=', session('nik'))->orderBy('id', 'desc')->first();
        // dd($latest_counter);
        // $tanggal = Tpenjualan_h::select('counter')->where('user','=', session('nik'))->orderBy('id', 'desc')->first();
        $mitems = Mitem::select('id','code','name')->limit(10)->get();
        $payments = Mjenispayment::select('id','code','name')->get();
        $notrans = DB::select("select fgetcode('tpenjualan') as codetrans");
        return view('pages.Transaksi.tbonpenjualan',[
            'counters' => $counters,
            'latest_counter' => $latest_counter,
            'mitems' => $mitems,
            'payments' => $payments,
            'notrans' => $notrans,
            'today_saldo' => $today_saldo,
        ]);
    }

    public function post(Request $request){
        if($request->no_d != null){
            $notrans = DB::select("select fgetcode('tpenjualan') as codetrans");
            foreach($notrans as $notran){
                $no = $notran->codetrans;
            }
            // BYPASS SYS
            $items = array();
            $is_stocknotvalid = 0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                $stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', $request->counter)
                ->first();
                if($stock_mitem_counter == null){
                    $mcounter = Mcounter::where('name', '=', $request->counter)->first();
                    date_default_timezone_set('Asia/Jakarta');
                    $datetime = date('d-m-Y H:i:s');
                    MitemCounters::create([
                        'code_mitem' => strtok($request->kode_d[$i], " "),
                        'name_mitem' => $request->namaitem_d[$i],
                        'code_mcounters' => $mcounter->code,
                        'name_mcounters' => $request->counter,
                        'stock' => 10,
                        'datein' => $datetime,
                    ]);
                    $stock_mitem_counter = DB::table('mitems_counters')
                    ->selectRaw('stock')
                    ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                    ->where('name_mcounters', '=', $request->counter)
                    ->first();
                }
                $stock_counter_min = $stock_mitem_counter->stock-$request->quantity_d[$i];
                // dd($stock_mitem_counter);            
                if ($request->quantity_d[$i] > $stock_mitem_counter->stock){
                    array_push($items, strtok($request->kode_d[$i], " "));
                    Session::flash('items_error', $items);
                    Session::flash('counter_selected', $request->counter);
                    $is_stocknotvalid++;
                }
            }
            // if ($is_stocknotvalid != 0){
            //     return redirect()->back()->with('error', 'Salah satu item stock counter kosong atau lebih dari stock counter!');
            // }
            // END BYPASS SYS
            $checkexist = Tpenjualan_h::select('id','no')->where('no','=', $no)->first();
            if($checkexist == null){
                Tpenjualan_h::create([
                    'no' => $no,
                    'tgl' => $request->dt,
                    'counter' => $request->counter,
                    'jenis_promosi' => $request->jenis_promosi,
                    'note' => $request->note,
                    'payment_mthd' => $request->payment_mthd,
                    'payment_mthd_2' => $request->payment_mthd_2,
                    'noreff' => $request->noreff,
                    'diskon' =>  (float) str_replace(',', '', $request->price_disc),
                    'hrgsblmdisc' => (float) str_replace(',', '', $request->price_sebelumdisc),
                    'grdtotal' => (float) str_replace(',', '', $request->price_total),
                    'totbayar' => (float) str_replace(',', '', $request->totbayar),
                    'totbayar_2' => (float) str_replace(',', '', $request->totbayar_2),
                    'totkembali' => (float) str_replace(',', '', $request->totkembali),
                    'user' => session('nik'),
                ]);
                $idh_loop = Tpenjualan_h::select('id')->where('no','=',$no)->get();
                for($j=0; $j<sizeof($idh_loop); $j++){
                    $idh = $idh_loop[$j]->id;
                }
        
                $countrows = sizeof($request->no_d);
                $count=0;
                for ($i=0;$i<sizeof($request->no_d);$i++){
                    Tpenjualan_d::create([
                        'idh' => $idh,
                        'no_penjualan' => $no,
                        'code' => $request->kode_d[$i],
                        'name' => $request->namaitem_d[$i],
                        'warna' => $request->warna_d[$i],
                        'qty' => $request->quantity_d[$i],
                        'satuan' => $request->satuan_d[$i],
                        'qty' => $request->quantity_d[$i],
                        'diskon' => $request->diskon_d[$i],
                        'subtotal' => (float) str_replace(',', '', $request->subtot_d[$i]),
                        'harga_awal' => (float) str_replace(',', '', $request->harga_awal_d[$i]),
                        'hrgjual' => (float) str_replace(',', '', $request->hrgjual_d[$i]),
                        'disctot' => (float) str_replace(',', '', $request->totdisc_d[$i]),
                        'hrgsetdisc' => (float) str_replace(',', '', $request->hrgsetdisc_d[$i]),
                        'subtotfinal' => (float) str_replace(',', '', $request->subtotfinal_d[$i]),
                        'note' => $request->keterangan_d[$i],
                    ]);
                    
                    $mcounter = Mcounter::where('name', '=', $request->counter)->first();

                    $stock_mitem_counter = DB::table('mitems_counters')
                    ->selectRaw('stock')
                    ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                    ->where('name_mcounters', '=', $request->counter)
                    ->first();
                    $stock_counter_min = $stock_mitem_counter->stock-$request->quantity_d[$i];
                    DB::table('mitems_counters')
                    ->selectRaw('stock')
                    ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                    ->where('name_mcounters', '=', $request->counter)
                    ->update([
                        'stock' => (int)$stock_counter_min,
                    ]);

                    $mcounter = Mcounter::where('name', '=', $request->counter)->first();
                    MutasiAF::create([  
                        'code_mitem' => strtok($request->kode_d[$i], " "),
                        'code_mcounters' => $mcounter->code,
                        'qty' => $request->quantity_d[$i],
                        'notrans' => $no,
                        'doctype' => "PENJUALAN",
                        'jenis' => "MINUS",
                        'action' => "CREATE",
                        'user' => session('nik'),
                    ]);

                    // // Insert item into existing in transaction
                    Mitem::where('code', '=', strtok($request->kode_d[$i], " "))->update([
                        'exist_trans' => "Y",
                    ]);
                    $count++;
                }
                
                if($count == $countrows){
                    if(session('privilage') == 'ADM' || session('privilage') == 'SPG DS'){
                        // $query_update = "UPDATE tpenjualan_hs SET grandtot = (SELECT SUM(subtotal) FROM tpenjualan_ds TX WHERE tpenjualan_hs.no = TX.no_penjualan) WHERE tpenjualan_hs.no = $no";
                        // DB::statement($query_update);
                        return redirect()->back()->with('success', 'Data berhasil di Insert');
                    }else{
                        $tpenjualanh = Tpenjualan_h::where('no','=', $no)->first();
                        $tpenjualands = Tpenjualan_d::where('no_penjualan','=', $tpenjualanh->no)->get();
                        $address = Mcounter::select('alamat')->where('name','=',$tpenjualanh->counter)->first();
                        // $query_update = "UPDATE tpenjualan_hs SET grandtot = (SELECT SUM(subtotal) FROM tpenjualan_ds TX WHERE tpenjualan_hs.no = TX.no_penjualan) WHERE tpenjualan_hs.no = $no";
                        // DB::statement($query_update);

                        return view('pages.Print.tbonjualprint',[
                            'tpenjualanh' => $tpenjualanh,
                            'tpenjualands' => $tpenjualands,
                            'address' => $address,
                        ]);
                    }                
                    // return redirect()->back();
                }
            }
            return redirect()->back();
        }
        Session::flash('counter_selected', $request->counter);
        return redirect()->back()->with('error_data', 'Silahkan periksa data anda kembali! [Data pada tabel kosong, silahkan klik tombol tambah(+) untuk memasukan item terlebih dahulu.]');
    }

    public function  getmitem(Request $request){
        $kode = $request->kode;
        if($kode == ''){
            $mitems = Mitem::select('id','code','name','satuan','hrgjual')->get();
        }else{
            $mitems = Mitem::select('id','code','name','satuan','hrgjual')->where('code','=',$kode)->get();
        }
        return json_encode($mitems);
    }

    public function list(){
        ini_set('memory_limit', '3000M');
        ini_set('max_execution_time', '0');
        if (!Session::has('bonjual_counter')){
            $bonjual_counter = Request()->counter_filter;
            Request()->session()->put('bonjual_counter', $bonjual_counter);
        }
        // dd(session('bonjual_counter'));
        if(session('privilage') == null){
            if (isset(request()->search)) {
                $tpenjualanhs = Tpenjualan_h::select('id','no','tgl','counter','note','payment_mthd','noreff','grdtotal','hrgsblmdisc','diskon')->where('counter','=',session('counter'))->where('no','LIKE','%'.request()->search.'%')->orderBy('tgl', 'asc')->paginate(50);
                $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','qty','satuan','hrgjual','diskon','subtotal','note',)->get();
            }else{
                $tpenjualanhs = Tpenjualan_h::select('id','no','tgl','counter','note','payment_mthd','noreff','grdtotal','hrgsblmdisc','diskon')->where('counter','=',session('counter'))->orderBy('tgl', 'asc')->paginate(50);
                $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','qty','satuan','hrgjual','diskon','subtotal','note',)->get();
            }
        }else if (session('privilage') == 'ADM'){
            if(Request()->counter_filter != null){
                if (isset(request()->search)) {
                    $tpenjualanhs = Tpenjualan_h::select('id','no','tgl','counter','note','payment_mthd','noreff','grdtotal','hrgsblmdisc','diskon')->where('counter','=',session('bonjual_counter'))->where('no','LIKE','%'.request()->search.'%')->orderBy('tgl', 'asc')->paginate(50);
                    $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','qty','satuan','hrgjual','diskon','subtotal','note',)->get();
                }else{
                    // dd(Request()->counter_filter);
                    if(isset(request()->counter_filter)){
                        if (Session::has('bonjual_counter')){
                            $bonjual_counter = Request()->counter_filter;
                            Request()->session()->put('bonjual_counter', $bonjual_counter);
                        }
                    }
                    $tpenjualanhs = Tpenjualan_h::select('id','no','tgl','counter','note','payment_mthd','noreff','grdtotal','hrgsblmdisc','diskon')->where('counter','=',session('bonjual_counter'))->orderBy('tgl', 'asc')->paginate(50);
                    $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','qty','satuan','hrgjual','diskon','subtotal','note',)->get();
                }
            }else{
                if (isset(request()->search)) {
                    $tpenjualanhs = Tpenjualan_h::select('id','no','tgl','counter','note','payment_mthd','noreff','grdtotal','hrgsblmdisc','diskon')->where('counter','=',session('bonjual_counter'))->where('no','LIKE','%'.request()->search.'%')->orderBy('tgl', 'asc')->paginate(50);
                    $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','qty','satuan','hrgjual','diskon','subtotal','note',)->get();
                }else{
                    $tpenjualanhs = Tpenjualan_h::select('id','no','tgl','counter','note','payment_mthd','noreff','grdtotal','hrgsblmdisc','diskon')->where('counter','=',session('bonjual_counter'))->orderBy('tgl', 'asc')->paginate(50);
                    $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','qty','satuan','hrgjual','diskon','subtotal','note',)->get();
                }
            }
        }else{
            if (isset(request()->search)) {
                $tpenjualanhs = Tpenjualan_h::select('id','no','tgl','counter','note','payment_mthd','noreff','grdtotal','hrgsblmdisc','diskon')->where('counter','=',session('counter'))->where('no','LIKE','%'.request()->search.'%')->orderBy('tgl', 'asc')->paginate(50);
                $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','qty','satuan','hrgjual','diskon','subtotal','note',)->get();
            }else{
                $tpenjualanhs = Tpenjualan_h::select('id','no','tgl','counter','note','payment_mthd','noreff','grdtotal','hrgsblmdisc','diskon')->where('counter','=',session('counter'))->orderBy('tgl', 'asc')->paginate(50);
                $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','qty','satuan','hrgjual','diskon','subtotal','note',)->get();
            }
        }
        return view('pages.Transaksi.tbonpenjualanlist',[
            'tpenjualanhs' => $tpenjualanhs,
            'tpenjualands' => $tpenjualands
        ]);
    }

    public function getedit(Tpenjualan_h $tpenjualanh){
        $privilage = session('privilage');
        if($privilage == 'ADM'){
            $counters = Mcounter::select('id','code','name')->get();
        }else if($privilage == null){
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }else{
            $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        }
        // $mitems = Mitem::select('id','code','name')->get();
        $counter_name = session('counter');
        // $mitems = DB::select( DB::raw("select code_mitem as code, name_mitem as name from mitems_counters where name_mcounters = '$counter_name' and stock > 0"));
        $mitems = Mitem::select('id','code','name')->get();
        $payments = Mjenispayment::select('id','code','name')->get();
        $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','warna','qty','satuan','harga_awal','hrgjual','diskon','subtotal','disctot','hrgsetdisc','subtotfinal','note')->where('idh','=',$tpenjualanh->id)->get();
        return view('pages.Transaksi.tbonpenjualanedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'payments' => $payments,
            'tpenjualanh' => $tpenjualanh,
            'tpenjualands' => $tpenjualands,
        ]);
    }

    public function update(Tpenjualan_h $tpenjualanh){
        // dd(request()->all());
        for($x=0;$x<sizeof(request('existdb_d'));$x++){
            $getstock_old = Tpenjualan_d::where('id', '=', request('id_d')[$x])->first();
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
                $normalize_stock_counter = $old_stock_mitem_counter->stock+(int)$getstock_old->qty;
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
                $normalize_stock_mitem = $stock_mitem_old->stock + (int)$getstock_old->qty;
                Mitem::where('code', '=', strtok($getstock_old->code, " "))->update([
                    'stock' => (int)$normalize_stock_mitem,
                ]);

                if(request('deleted_item_d') == request('id_d')[$x]){
                    Tpenjualan_d::where('id','=',request('id_d')[$x])->delete();
                }
            }
        }

        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_penjualan = request('no');
        }
        DB::delete('delete from tpenjualan_ds where no_penjualan = ?', [$no_penjualan] );
        Tpenjualan_h::where('id', '=', $tpenjualanh->id)->update([
            'no' => request('no'), 
            'counter' => request('counter'),
            'jenis_promosi' => request('jenis_promosi'),
            'tgl' => request('dt'),
            'note' => request('note'),
            'payment_mthd' => request('payment_mthd'),
            'payment_mthd_2' => request('payment_mthd_2'),
            'noreff' => request('noreff'),
            'diskon' =>  (float) str_replace(',', '', request('price_disc')),
            'grdtotal' =>  (float) str_replace(',', '', request('price_total')),
            'hrgsblmdisc' => (float) str_replace(',', '',request('price_sebelumdisc')),
            'totbayar' =>  (float) str_replace(',', '', request('totbayar')),
            'totbayar_2' =>  (float) str_replace(',', '', request('totbayar_2')),
            'totkembali' =>  (float) str_replace(',', '', request('totkembali')),
            'user' => session('nik'),
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));        
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            if(request('deleted_item_d')[$i] != request('id_d')[$i]){
                Tpenjualan_d::create([
                    'idh' => $tpenjualanh->id,
                    'no_penjualan' => request('no'),
                    'code' => request('kode_d')[$i],
                    'name' => request('nama_item_d')[$i],
                    'warna' => request('warna_d')[$i],
                    'qty' => request('quantity_d')[$i],
                    'satuan' => request('satuan_d')[$i],
                    'diskon' => request('diskon_d')[$i],
                    'subtotal' => (float) str_replace(',', '', request('subtot_d')[$i]),
                    'harga_awal' => (float) str_replace(',', '', request('harga_awal_d')[$i]),
                    'hrgjual' => (float) str_replace(',', '', request('hrgjual_d')[$i]),
                    'disctot' => (float) str_replace(',', '', request('totdisc_d')[$i]),
                    'hrgsetdisc' => (float) str_replace(',', '', request('hrgsetdisc_d')[$i]),
                    'subtotfinal' => (float) str_replace(',', '', request('subtotfinal_d')[$i]),
                    'note' => request('keterangan_d')[$i],
                ]);
                $stock_mitem = Mitem::select('stock')->where('code', '=', strtok(request('kode_d')[$i], " "))->first();
                $stock_min = $stock_mitem->stock-request('quantity_d')[$i];
                Mitem::where('code', '=', strtok(request('kode_d')[$i], " "))->update([
                    'stock' => (int)$stock_min,
                ]);
                $stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
                ->where('name_mcounters', '=', request('counter'))
                ->first();

                $mcounter = Mcounter::where('name', '=', request('counter'))->first();

                if ($stock_mitem_counter == null) {
                    $stock_mitem_counter = 0;
                    $stock_counter_min = $stock_mitem_counter - request('quantity_d')[$i];
                    date_default_timezone_set('Asia/Jakarta');
                    $datetime = date('d-m-Y H:i:s');
                    MitemCounters::create([
                        'code_mitem' => strtok(request('kode_d')[$i], " "),
                        'name_mitem' => request('nama_item_d')[$i],
                        'code_mcounters' => $mcounter->code,
                        'name_mcounters' => request('counter'),
                        'stock' => $stock_counter_min,
                        'datein' => $datetime,
                    ]);
                }else{
                    $stock_counter_min = $stock_mitem_counter->stock - request('quantity_d')[$i];
                    DB::table('mitems_counters')
                    ->selectRaw('stock')
                    ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
                    ->where('name_mcounters', '=', request('counter'))
                    ->update([
                        'stock' => (int)$stock_counter_min,
                    ]);

                    $mcounter = Mcounter::where('name', '=', request('counter'))->first();
                    MutasiAF::create([  
                        'code_mitem' => strtok(request('kode_d')[$i], " "),
                        'code_mcounters' => $mcounter->code,
                        'qty' => request('quantity_d')[$i],
                        'notrans' => request('no'),
                        'doctype' => "PENJUALAN",
                        'jenis' => "ADJUST",
                        'action' => "UPDATE",
                        'user' => session('nik'),
                    ]);
                }
                // dd($stock_mitem_counter);
                $count++;
            }
        }
        return redirect()->route('tbonjuallist');
        // if($count == $countrows){
        //     return redirect()->route('tbonjuallist');
        // }
    }

    public function delete(Tpenjualan_h $tpenjualanh){
        $penjualan_detail = Tpenjualan_d::where('idh','=',$tpenjualanh->id)->get();
        foreach($penjualan_detail as $penjualan_old_item){
            // Mins a value from the old stock in mitems_counters table
            $stock_mitem_counter = DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($penjualan_old_item->code, " "))
            ->where('name_mcounters', '=', $tpenjualanh->counter)
            ->first();
            // dd($stock_mitem_counter);
            $stock_mitem_counter_sum = $stock_mitem_counter->stock + (int)$penjualan_old_item->qty;
            // dd($stock_mitem_counter_sum);
            DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($penjualan_old_item->code, " "))
            ->where('name_mcounters', '=', $tpenjualanh->counter)
            ->update([
                'stock' => (int)$stock_mitem_counter_sum,
            ]);
            $mcounter = Mcounter::where('name', '=', $tpenjualanh->counter)->first();
            MutasiAF::create([  
                'code_mitem' => strtok($penjualan_old_item->code, " "),
                'code_mcounters' => $mcounter->code,
                'qty' => (int)$penjualan_old_item->qty,
                'notrans' => $tpenjualanh->no,
                'doctype' => "PENERIMAAN",
                'jenis' => "PLUS",
                'action' => "DELETE",
                'user' => session('nik'),
            ]);
        }
        Tpenjualan_h::find($tpenjualanh->id)->delete();
        Tpenjualan_d::where('idh','=',$tpenjualanh->id)->delete();

        return redirect()->route('tbonjuallist');
    }

    public function print(Tpenjualan_h $tpenjualanh){        
        $tpenjualands = Tpenjualan_d::where('idh','=',$tpenjualanh->id)->get();
        $address = Mcounter::select('alamat')->where('name','=',$tpenjualanh->counter)->first();

        return view('pages.Print.tbonjualprint',[
            'tpenjualanh' => $tpenjualanh,
            'tpenjualands' => $tpenjualands,
            'address' => $address,
        ]);
    }
    public function printmatrix(Tpenjualan_h $tpenjualanh){        
        $tpenjualands = Tpenjualan_d::where('idh','=',$tpenjualanh->id)->get();
        $address = Mcounter::select('alamat')->where('name','=',$tpenjualanh->counter)->first();

        return view('pages.Print.bonpenjualdotmatrix',[
            'tpenjualanh' => $tpenjualanh,
            'tpenjualands' => $tpenjualands,
            'address' => $address,
        ]);
    }

    public function printpdfbonjual(Tpenjualan_h $tpenjualanh){
        $tpenjualands = Tpenjualan_d::where('idh','=',$tpenjualanh->id)->get();
        // dd($tpenjualands);
        $address = Mcounter::select('alamat')->where('name','=',$tpenjualanh->counter)->first();
        // 1 inch = 72 point
        // 1 inch = 2.54 cm
        // 10 cm = 10/2.54*72 = 283.464566929
        // 20 cm = 10/2.54*72 = 566.929133858
        $customPaper = array(0,0,226.7,850.3);
        $pdf = Pdf::loadView('pages.Print.tbonpenjualanprintmatrix', [
            'tpenjualanh' => $tpenjualanh,
            'tpenjualands'=> $tpenjualands,
            // 'address'=> $address
            ])->setPaper($customPaper, 'portrait');
        return $pdf->stream("Bon_Penjualan/".$tpenjualanh->no);
    }
}
