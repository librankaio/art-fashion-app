<?php

namespace App\Http\Controllers;

use App\Models\Mitem;
use App\Models\Mwarna;
use App\Models\Tpembelian_d;
use App\Models\Tpembelian_h;
use App\Services\MitemExistTransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\StockCounterService;

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
        // Pembelian selalu masuk ke counter user yang sedang login, dan nilai
        // itu juga yang disimpan di header, jadi keduanya harus dari sumber
        // yang sama.
        $counter = StockCounterService::resolveCounter(session('counter'));
        if (!$counter) {
            return redirect()->back()->with('error', 'Counter tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            $notrans = DB::select("select fgetcode('tpembelian') as codetrans");
            foreach($notrans as $notran){
                $no = $notran->codetrans;
            }

            if (Tpembelian_h::where('no', $no)->exists()) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Nomor transaksi sudah ada!');
            }

            $header = Tpembelian_h::create([
                'no' => $no,
                'tgl' => $request->dt,
                'supplier' => $request->supplier,
                'counter' => $counter->name,
                'note' => $request->note,
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
            ]);
            $idh = $header->id;

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
                    'hrgjual' => (float) str_replace(',', '', $request->hrgjual_d[$i]),
                    'subtotal' => (float) str_replace(',', '', $request->subtot_d[$i]),
                ]);

                $code = StockCounterService::normalizeCode($request->kode_d[$i]);
                $qty  = (int) $request->quantity_d[$i];

                Mitem::where('code', $code)->increment('stock', $qty);

                StockCounterService::adjust($code, $counter, $qty, [
                    'name_mitem' => $request->nama_item_d[$i],
                    'notrans'    => $request->no,
                    'doctype'    => 'PEMBELIAN',
                    'jenis'      => 'PLUS',
                    'action'     => 'CREATE',
                ]);

                // Insert item into existing in transaction
                Mitem::where('code', $code)->update([
                    'exist_trans' => "Y",
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan pembelian: ' . $th->getMessage());
        }
    }

    public function list(){
        $tpembelianhs = Tpembelian_h::select('id','no','tgl','supplier','note','grdtotal',)->where('counter','=', session('counter'))->orderBy('created_at', 'asc')->get();
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
        // Counter diambil dari header, bukan session('counter'). Versi
        // sebelumnya membalik stok ke counter user yang sedang login, sehingga
        // ADM atau gudang yang mengedit pembelian cabang lain merusak stok
        // counter-nya sendiri, atau menabrak null kalau barisnya tidak ada.
        $counter = StockCounterService::resolveCounter($tpembelianh->counter);
        if (!$counter) {
            return redirect()->route('tpembelianbaranglist')
                ->with('error', 'Counter transaksi tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            // 1. Balikkan efek stok transaksi lama.
            $oldDetails = Tpembelian_d::where('idh', $tpembelianh->id)
                ->orWhere('no_pembelian', $tpembelianh->no)
                ->get();

            $affected_kodes = [];
            foreach ($oldDetails as $old) {
                $code = StockCounterService::normalizeCode($old->code);
                $qty  = (int) $old->qty;
                $affected_kodes[] = $code;

                Mitem::where('code', $code)->decrement('stock', $qty);

                StockCounterService::adjust($code, $counter, -$qty, [
                    'name_mitem' => $old->name,
                    'notrans'    => $tpembelianh->no,
                    'doctype'    => 'PEMBELIAN',
                    'jenis'      => 'ADJUST-MINUS',
                    'action'     => 'UPDATE',
                ]);
            }

            // 2. Ganti detail lama dan simpan header versi baru.
            Tpembelian_d::where('idh', $tpembelianh->id)
                ->orWhere('no_pembelian', $tpembelianh->no)
                ->delete();

            Tpembelian_h::where('id', '=', $tpembelianh->id)->update([
                'no' => request('no'),
                'tgl' => request('dt'),
                'supplier' => request('supplier'),
                'counter' => $counter->name,
                'note' => request('note'),
                'grdtotal' =>  (float) str_replace(',', '', request('price_total'))
            ]);

            // 3. Terapkan stok versi baru.
            for ($i=0;$i<sizeof(request('no_d'));$i++){
                if((request('deleted_item_d')[$i] ?? null) != request('id_d')[$i]){
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

                    $code = StockCounterService::normalizeCode(request('kode_d')[$i]);
                    $qty  = (int) request('quantity_d')[$i];
                    $affected_kodes[] = $code;

                    Mitem::where('code', $code)->update([
                        'hrgjual' =>  (float) str_replace(',', '', request('hrgjual_d')[$i])
                    ]);

                    Mitem::where('code', $code)->increment('stock', $qty);

                    StockCounterService::adjust($code, $counter, $qty, [
                        'name_mitem' => request('nama_item_d')[$i],
                        'notrans'    => request('no'),
                        'doctype'    => 'PEMBELIAN',
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

            return redirect()->route('tpembelianbaranglist')->with('success', 'Data berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('tpembelianbaranglist')
                ->with('error', 'Gagal mengupdate pembelian: ' . $th->getMessage());
        }
    }

    public function delete(Tpembelian_h $tpembelianh){
        $counter = StockCounterService::resolveCounter($tpembelianh->counter);
        if (!$counter) {
            return redirect()->route('tpembelianbaranglist')
                ->with('error', 'Counter transaksi tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            $pembelian_detail = Tpembelian_d::where('idh','=',$tpembelianh->id)->get();
            // Kumpulkan semua kode SEBELUM delete untuk recheck exist_trans
            $affected_kodes = $pembelian_detail
                ->map(fn($d) => StockCounterService::normalizeCode($d->code))
                ->toArray();

            foreach($pembelian_detail as $pembelian_old_item){
                $code = StockCounterService::normalizeCode($pembelian_old_item->code);
                $qty  = (int) $pembelian_old_item->qty;

                Mitem::where('code', $code)->decrement('stock', $qty);

                StockCounterService::adjust($code, $counter, -$qty, [
                    'name_mitem' => $pembelian_old_item->name,
                    'notrans'    => $tpembelianh->no,
                    'doctype'    => 'PEMBELIAN',
                    'jenis'      => 'MINUS',
                    'action'     => 'DELETE',
                ]);
            }

            Tpembelian_d::where('idh','=',$tpembelianh->id)->delete();
            Tpembelian_h::where('id','=',$tpembelianh->id)->delete();

            DB::commit();

            // Recheck exist_trans untuk semua item yang terdampak
            MitemExistTransService::recheckMany($affected_kodes);

            return redirect()->route('tpembelianbaranglist')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('tpembelianbaranglist')
                ->with('error', 'Gagal menghapus pembelian: ' . $th->getMessage());
        }
    }
}
