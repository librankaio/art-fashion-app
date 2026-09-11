<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\Mjenispayment;
use App\Models\MsaldoAwal;
use App\Models\Tpenjualan_d;
use App\Models\Tpenjualan_h;
use App\Services\MitemExistTransService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\StockCounterService;

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
        if($request->no_d == null){
            Session::flash('counter_selected', $request->counter);
            return redirect()->back()->with('error_data', 'Silahkan periksa data anda kembali! [Data pada tabel kosong, silahkan klik tombol tambah(+) untuk memasukan item terlebih dahulu.]');
        }

        $counter = StockCounterService::resolveCounter($request->counter);
        if (!$counter) {
            Session::flash('counter_selected', $request->counter);
            return redirect()->back()->with('error', 'Counter tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            $notrans = DB::select("select fgetcode('tpenjualan') as codetrans");
            foreach($notrans as $notran){
                $no = $notran->codetrans;
            }

            if (Tpenjualan_h::where('no', $no)->exists()) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Nomor transaksi sudah ada!');
            }

            // BYPASS SYS: pengecekan stok hanya menandai item yang kurang,
            // tidak memblokir penyimpanan. Baris counter yang belum ada tidak
            // lagi dibuat dengan stok 10 hardcoded seperti versi sebelumnya.
            $items = [];
            for ($i=0;$i<sizeof($request->no_d);$i++){
                $code = StockCounterService::normalizeCode($request->kode_d[$i]);
                if ((int)$request->quantity_d[$i] > StockCounterService::currentStock($code, $counter)){
                    $items[] = $code;
                }
            }
            if ($items) {
                Session::flash('items_error', $items);
                Session::flash('counter_selected', $request->counter);
            }
            // END BYPASS SYS

            $header = Tpenjualan_h::create([
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
            $idh = $header->id;

            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tpenjualan_d::create([
                    'idh' => $idh,
                    'no_penjualan' => $no,
                    'code' => $request->kode_d[$i],
                    'name' => $request->namaitem_d[$i],
                    'warna' => $request->warna_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'satuan' => $request->satuan_d[$i],
                    'diskon' => $request->diskon_d[$i],
                    'subtotal' => (float) str_replace(',', '', $request->subtot_d[$i]),
                    'harga_awal' => (float) str_replace(',', '', $request->harga_awal_d[$i]),
                    'hrgjual' => (float) str_replace(',', '', $request->hrgjual_d[$i]),
                    'disctot' => (float) str_replace(',', '', $request->totdisc_d[$i]),
                    'hrgsetdisc' => (float) str_replace(',', '', $request->hrgsetdisc_d[$i]),
                    'subtotfinal' => (float) str_replace(',', '', $request->subtotfinal_d[$i]),
                    'note' => $request->keterangan_d[$i],
                ]);

                $code = StockCounterService::normalizeCode($request->kode_d[$i]);
                $qty  = (int) $request->quantity_d[$i];

                StockCounterService::adjust($code, $counter, -$qty, [
                    'name_mitem' => $request->namaitem_d[$i],
                    'notrans'    => $no,
                    'doctype'    => 'PENJUALAN',
                    'jenis'      => 'MINUS',
                    'action'     => 'CREATE',
                ]);

                // Insert item into existing in transaction
                Mitem::where('code', $code)->update([
                    'exist_trans' => "Y",
                ]);
            }

            DB::commit();

            if(session('privilage') == 'ADM' || session('privilage') == 'SPG DS'){
                return redirect()->back()->with('success', 'Data berhasil di Insert');
            }

            $tpenjualanh = Tpenjualan_h::where('no','=', $no)->first();
            $tpenjualands = Tpenjualan_d::where('no_penjualan','=', $tpenjualanh->no)->get();
            $address = Mcounter::select('alamat')->where('name','=',$tpenjualanh->counter)->first();

            return view('pages.Print.tbonjualprint',[
                'tpenjualanh' => $tpenjualanh,
                'tpenjualands' => $tpenjualands,
                'address' => $address,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('counter_selected', $request->counter);
            return redirect()->back()->with('error', 'Gagal menyimpan penjualan: ' . $th->getMessage());
        }
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

    public function getitemstock(Request $request){
        $kode    = $request->kode;
        $counter = $request->counter;

        // Pakai service yang sama dengan jalur simpan, supaya angka yang
        // dilihat kasir tidak berbeda dari angka yang dipakai saat posting.
        $mcounter = StockCounterService::resolveCounter($counter);
        if (!$mcounter) {
            return response()->json(['stock' => 0]);
        }

        return response()->json([
            'stock' => StockCounterService::currentStock($kode, $mcounter),
        ]);
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
        // Counter lama dari header, counter baru dari form. Versi sebelumnya
        // membalik stok memakai request('counter'), sehingga mengganti counter
        // saat edit membuat counter asal kehilangan stok secara permanen.
        $oldCounter = StockCounterService::resolveCounter($tpenjualanh->counter);
        $newCounter = StockCounterService::resolveCounter(request('counter'));

        if (!$oldCounter || !$newCounter) {
            return redirect()->route('tbonjuallist')
                ->with('error', 'Counter tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            // 1. Balikkan efek stok transaksi lama ke counter ASAL.
            $oldDetails = Tpenjualan_d::where('idh', $tpenjualanh->id)
                ->orWhere('no_penjualan', $tpenjualanh->no)
                ->get();

            $affected_kodes = [];
            foreach ($oldDetails as $old) {
                $code = StockCounterService::normalizeCode($old->code);
                $qty  = (int) $old->qty;
                $affected_kodes[] = $code;

                StockCounterService::adjust($code, $oldCounter, $qty, [
                    'name_mitem' => $old->name,
                    'notrans'    => $tpenjualanh->no,
                    'doctype'    => 'PENJUALAN',
                    'jenis'      => 'ADJUST-PLUS',
                    'action'     => 'UPDATE',
                ]);

                Mitem::where('code', $code)->increment('stock', $qty);
            }

            // 2. Ganti detail lama dan simpan header versi baru.
            Tpenjualan_d::where('idh', $tpenjualanh->id)
                ->orWhere('no_penjualan', $tpenjualanh->no)
                ->delete();

            Tpenjualan_h::where('id', $tpenjualanh->id)->update([
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

            // 3. Terapkan stok versi baru ke counter dari form.
            for ($i=0;$i<sizeof(request('no_d'));$i++){
                if((request('deleted_item_d')[$i] ?? null) != request('id_d')[$i]){
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

                    $code = StockCounterService::normalizeCode(request('kode_d')[$i]);
                    $qty  = (int) request('quantity_d')[$i];
                    $affected_kodes[] = $code;

                    Mitem::where('code', $code)->decrement('stock', $qty);

                    StockCounterService::adjust($code, $newCounter, -$qty, [
                        'name_mitem' => request('nama_item_d')[$i],
                        'notrans'    => request('no'),
                        'doctype'    => 'PENJUALAN',
                        'jenis'      => 'ADJUST-MINUS',
                        'action'     => 'UPDATE',
                    ]);

                    // Insert item into existing in transaction
                    Mitem::where('code', $code)->update([
                        'exist_trans' => "Y",
                    ]);
                }
            }

            DB::commit();

            MitemExistTransService::recheckMany($affected_kodes);

            return redirect()->route('tbonjuallist')->with('success', 'Data berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('tbonjuallist')
                ->with('error', 'Gagal mengupdate penjualan: ' . $th->getMessage());
        }
    }

    public function delete(Tpenjualan_h $tpenjualanh){
        $counter = StockCounterService::resolveCounter($tpenjualanh->counter);
        if (!$counter) {
            return redirect()->route('tbonjuallist')
                ->with('error', 'Counter transaksi tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            $penjualan_detail = Tpenjualan_d::where('idh','=',$tpenjualanh->id)->get();
            // Kumpulkan semua kode SEBELUM delete untuk recheck exist_trans
            $affected_kodes = $penjualan_detail
                ->map(fn($d) => StockCounterService::normalizeCode($d->code))
                ->toArray();

            foreach($penjualan_detail as $penjualan_old_item){
                $code = StockCounterService::normalizeCode($penjualan_old_item->code);
                $qty  = (int) $penjualan_old_item->qty;

                // Kembalikan stok yang sempat dikurangi saat penjualan dibuat.
                // Doctype dulu tertulis PENERIMAAN, itu salah label.
                StockCounterService::adjust($code, $counter, $qty, [
                    'name_mitem' => $penjualan_old_item->name,
                    'notrans'    => $tpenjualanh->no,
                    'doctype'    => 'PENJUALAN',
                    'jenis'      => 'PLUS',
                    'action'     => 'DELETE',
                ]);
            }

            Tpenjualan_d::where('idh','=',$tpenjualanh->id)->delete();
            Tpenjualan_h::where('id','=',$tpenjualanh->id)->delete();

            DB::commit();

            // Recheck exist_trans untuk semua item yang terdampak
            MitemExistTransService::recheckMany($affected_kodes);

            return redirect()->route('tbonjuallist')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('tbonjuallist')
                ->with('error', 'Gagal menghapus penjualan: ' . $th->getMessage());
        }
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
