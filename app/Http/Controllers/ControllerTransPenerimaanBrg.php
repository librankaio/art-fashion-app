<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\Tpenerimaan_d;
use App\Models\Tpenerimaan_h;
use App\Models\Tsj_d;
use App\Models\Tsj_h;
use App\Services\MitemExistTransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\StockCounterService;

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
        // Satu counter untuk seluruh transaksi. Versi sebelumnya mencari baris
        // dengan $request->counter tapi membuatnya dengan session('counter'),
        // sehingga baris baru tidak pernah ketemu lagi dan duplikat menumpuk.
        $counter = StockCounterService::resolveCounter($request->counter);
        if (!$counter) {
            return redirect()->back()->with('error', 'Counter tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            $notrans = DB::select("select fgetcode('tpenerimaan') as codetrans");
            foreach($notrans as $notran){
                $no = $notran->codetrans;
            }

            if (Tpenerimaan_h::where('no', $no)->exists()) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Nomor transaksi sudah ada!');
            }

            $header = Tpenerimaan_h::create([
                'no' => $no,
                'no_sj' => $request->nosj,
                'counter' => $request->counter,
                'tgl' => $request->dt,
                'note' => $request->note,
                'jenis' => $request->jenis,
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
            ]);
            $idh = $header->id;

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

                $code = StockCounterService::normalizeCode($request->kode_d[$i]);
                $qty  = (int) $request->quantity_d[$i];

                Mitem::where('code', $code)->increment('stock', $qty);

                StockCounterService::adjust($code, $counter, $qty, [
                    'name_mitem' => $request->nama_item_d[$i],
                    'notrans'    => $request->no,
                    'doctype'    => 'PENERIMAAN',
                    'jenis'      => 'PLUS',
                    'action'     => 'CREATE',
                ]);

                // Insert item into existing in transaction
                Mitem::where('code', $code)->update([
                    'exist_trans' => "Y",
                ]);
            }

            Tsj_h::where('no', '=', $request->nosj)->update([
                'exist_penerimaan' => "Y",
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan penerimaan: ' . $th->getMessage());
        }
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
        // Counter lama dari header, counter baru dari form.
        $oldCounter = StockCounterService::resolveCounter($tpenerimaanh->counter);
        $newCounter = StockCounterService::resolveCounter(request('counter'));

        if (!$oldCounter || !$newCounter) {
            return redirect()->route('tpenerimaanbrglist')
                ->with('error', 'Counter tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            // 1. Balikkan efek stok transaksi lama ke counter ASAL.
            $oldDetails = Tpenerimaan_d::where('idh', $tpenerimaanh->id)
                ->orWhere('no_penerimaan', $tpenerimaanh->no)
                ->get();

            $affected_kodes = [];
            foreach ($oldDetails as $old) {
                $code = StockCounterService::normalizeCode($old->code);
                $qty  = (int) $old->qty;
                $affected_kodes[] = $code;

                Mitem::where('code', $code)->decrement('stock', $qty);

                StockCounterService::adjust($code, $oldCounter, -$qty, [
                    'name_mitem' => $old->name,
                    'notrans'    => $tpenerimaanh->no,
                    'doctype'    => 'PENERIMAAN',
                    'jenis'      => 'ADJUST-MINUS',
                    'action'     => 'UPDATE',
                ]);
            }

            // 2. Ganti detail lama dan simpan header versi baru.
            Tpenerimaan_d::where('idh', $tpenerimaanh->id)
                ->orWhere('no_penerimaan', $tpenerimaanh->no)
                ->delete();

            Tpenerimaan_h::where('id', '=', $tpenerimaanh->id)->update([
                'no' => request('no'),
                'no_sj' => request('nosj'),
                'counter' => request('counter'),
                'tgl' => request('dt'),
                'note' => request('note'),
                'jenis' => request('jenis'),
                'grdtotal' => (float) str_replace(',', '', request('price_total'))
            ]);

            // 3. Terapkan stok versi baru ke counter dari form.
            for ($i=0;$i<sizeof(request('no_d'));$i++){
                if((request('deleted_item_d')[$i] ?? null) != request('id_d')[$i]){
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

                    $code = StockCounterService::normalizeCode(request('kode_d')[$i]);
                    $qty  = (int) request('quantity_d')[$i];
                    $affected_kodes[] = $code;

                    Mitem::where('code', $code)->increment('stock', $qty);

                    StockCounterService::adjust($code, $newCounter, $qty, [
                        'name_mitem' => request('nama_item_d')[$i],
                        'notrans'    => request('no'),
                        'doctype'    => 'PENERIMAAN',
                        'jenis'      => 'ADJUST-PLUS',
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

            return redirect()->route('tpenerimaanbrglist')->with('success', 'Data berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('tpenerimaanbrglist')
                ->with('error', 'Gagal mengupdate penerimaan: ' . $th->getMessage());
        }
    }

    public function delete(Tpenerimaan_h $tpenerimaanh){
        $counter = StockCounterService::resolveCounter($tpenerimaanh->counter);
        if (!$counter) {
            return redirect()->route('tpenerimaanbrglist')
                ->with('error', 'Counter transaksi tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            $penerimaan_detail = Tpenerimaan_d::where('idh','=',$tpenerimaanh->id)->get();
            // Kumpulkan semua kode SEBELUM delete
            $affected_kodes = $penerimaan_detail
                ->map(fn($d) => StockCounterService::normalizeCode($d->code))
                ->toArray();

            foreach($penerimaan_detail as $penerimaan_old_item){
                $code = StockCounterService::normalizeCode($penerimaan_old_item->code);
                $qty  = (int) $penerimaan_old_item->qty;

                Mitem::where('code', $code)->decrement('stock', $qty);

                StockCounterService::adjust($code, $counter, -$qty, [
                    'name_mitem' => $penerimaan_old_item->name,
                    'notrans'    => $tpenerimaanh->no,
                    'doctype'    => 'PENERIMAAN',
                    'jenis'      => 'MINUS',
                    'action'     => 'DELETE',
                ]);
            }

            $tpenerimaan = Tpenerimaan_h::where('id','=',$tpenerimaanh->id)->first();
            Tsj_h::where('no', '=', $tpenerimaan->no_sj)->update([
                'exist_penerimaan' => NULL,
            ]);
            Tpenerimaan_d::where('idh','=',$tpenerimaanh->id)->delete();
            Tpenerimaan_h::where('id','=',$tpenerimaanh->id)->delete();

            DB::commit();

            // Recheck exist_trans untuk semua item yang terdampak
            MitemExistTransService::recheckMany($affected_kodes);

            return redirect()->route('tpenerimaanbrglist')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('tpenerimaanbrglist')
                ->with('error', 'Gagal menghapus penerimaan: ' . $th->getMessage());
        }
    }
}
