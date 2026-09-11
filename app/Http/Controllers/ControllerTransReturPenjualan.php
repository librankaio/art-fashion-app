<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\Tretur_d;
use App\Models\Tretur_h;
use App\Services\MitemExistTransService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\StockCounterService;

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
        // Counter di-resolve sekali di depan. Kalau salah satunya tidak ada di
        // master lokasi, berhenti di sini dengan pesan yang jelas alih-alih
        // menabrak null di tengah loop setelah sebagian stok sudah berubah.
        $counterFrom = StockCounterService::resolveCounter($request->counter_from);
        $counterTo   = StockCounterService::resolveCounter($request->counter);

        if (!$counterFrom || !$counterTo) {
            return redirect()->back()
                ->with('error', 'Counter asal atau tujuan retur tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            $notrans = DB::select("select fgetcode('tretur') as codetrans");
            foreach($notrans as $notran){
                $no = $notran->codetrans;
            }

            $checkexist = Tretur_h::select('id','no')->where('no','=', $no)->first();
            if($checkexist != null){
                DB::rollBack();
                return redirect()->back()->with('error', 'Nomor transaksi sudah ada!');
            }

            // Cek kecukupan stok counter asal. Pemblokirannya memang dimatikan
            // sejak lama, jadi di sini hanya menandai item yang stoknya kurang.
            $items = [];
            $is_stocknotvalid = 0;
            for ($i = 0; $i < sizeof($request->no_d); $i++){
                $code = StockCounterService::normalizeCode($request->kode_d[$i]);
                if ((int)$request->quantity_d[$i] > StockCounterService::currentStock($code, $counterFrom)){
                    $items[] = $code;
                    $is_stocknotvalid++;
                }
            }
            if ($is_stocknotvalid != 0){
                Session::flash('items_error', $items);
                Session::flash('counter_selected', $request->counter_from);
            }

            $header = Tretur_h::create([
                'no' => $no,
                'counter' => $request->counter,
                'counter_from' => $request->counter_from,
                'tgl' => $request->dt,
                'note' => $request->note,
            ]);
            $idh = $header->id;

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

                $code = StockCounterService::normalizeCode($request->kode_d[$i]);
                $qty  = (int) $request->quantity_d[$i];

                Mitem::where('code', $code)->decrement('stock', $qty);

                // Barang keluar dari counter asal
                StockCounterService::adjust($code, $counterFrom, -$qty, [
                    'name_mitem' => $request->nama_item_d[$i],
                    'notrans'    => $request->no,
                    'doctype'    => 'RETUR_PENJUALAN',
                    'jenis'      => 'CREATE-COUNTER_FROM-MINUS',
                    'action'     => 'CREATE',
                ]);

                // Barang masuk ke counter tujuan
                StockCounterService::adjust($code, $counterTo, $qty, [
                    'name_mitem' => $request->nama_item_d[$i],
                    'notrans'    => $request->no,
                    'doctype'    => 'RETUR_PENJUALAN',
                    'jenis'      => 'CREATE-COUNTER_TO-PLUS',
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
            return redirect()->back()->with('error', 'Gagal menyimpan retur: ' . $th->getMessage());
        }
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
        // Counter lama diambil dari header, counter baru dari form. Kalau user
        // mengganti counter tujuan saat edit, pembalikan harus tetap menyasar
        // counter asli transaksi.
        $oldCounterFrom = StockCounterService::resolveCounter($treturh->counter_from);
        $oldCounterTo   = StockCounterService::resolveCounter($treturh->counter);
        $newCounterFrom = StockCounterService::resolveCounter(request('counter_from') ?: $treturh->counter_from);
        $newCounterTo   = StockCounterService::resolveCounter(request('counter'));

        if (!$oldCounterFrom || !$oldCounterTo || !$newCounterFrom || !$newCounterTo) {
            return redirect()->route('treturjuallist')
                ->with('error', 'Counter asal atau tujuan retur tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            // 1. Balikkan seluruh efek stok transaksi lama.
            //    Blok ini dulu dimatikan karena selalu menabrak null, akibatnya
            //    setiap edit menerapkan perubahan stok dua kali.
            $oldDetails = Tretur_d::where('idh', $treturh->id)
                ->orWhere('no_retur', $treturh->no)
                ->get();

            foreach ($oldDetails as $old) {
                $code = StockCounterService::normalizeCode($old->code);
                $qty  = (int) $old->qty;

                Mitem::where('code', $code)->increment('stock', $qty);

                StockCounterService::adjust($code, $oldCounterFrom, $qty, [
                    'name_mitem' => $old->name,
                    'notrans'    => $treturh->no,
                    'doctype'    => 'RETUR_PENJUALAN',
                    'jenis'      => 'ADJUST-COUNTER_FROM-PLUS',
                    'action'     => 'UPDATE',
                ]);

                StockCounterService::adjust($code, $oldCounterTo, -$qty, [
                    'name_mitem' => $old->name,
                    'notrans'    => $treturh->no,
                    'doctype'    => 'RETUR_PENJUALAN',
                    'jenis'      => 'ADJUST-COUNTER_TO-MINUS',
                    'action'     => 'UPDATE',
                ]);
            }

            // 2. Ganti detail lama dan simpan header versi baru.
            Tretur_d::where('idh', $treturh->id)
                ->orWhere('no_retur', $treturh->no)
                ->delete();

            Tretur_h::where('id', $treturh->id)->update([
                'no' => request('no'),
                'counter' => request('counter'),
                'counter_from' => $newCounterFrom->name,
                'tgl' => request('dt'),
                'note' => request('note'),
            ]);

            // 3. Terapkan stok versi baru.
            for ($i=0;$i<sizeof(request('no_d'));$i++){
                if((request('deleted_item_d')[$i] ?? null) != request('id_d')[$i]){
                    Tretur_d::create([
                        'idh' => $treturh->id,
                        'no_retur' => request('no'),
                        'code' =>  request('kode_d')[$i],
                        'name' =>  request('nama_item_d')[$i],
                        'qty' =>  request('quantity_d')[$i],
                        'satuan' => request('satuan_d')[$i],
                    ]);

                    $code = StockCounterService::normalizeCode(request('kode_d')[$i]);
                    $qty  = (int) request('quantity_d')[$i];

                    Mitem::where('code', $code)->decrement('stock', $qty);

                    StockCounterService::adjust($code, $newCounterFrom, -$qty, [
                        'name_mitem' => request('nama_item_d')[$i],
                        'notrans'    => request('no'),
                        'doctype'    => 'RETUR_PENJUALAN',
                        'jenis'      => 'ADJUST-COUNTER_FROM-MINUS',
                        'action'     => 'UPDATE',
                    ]);

                    StockCounterService::adjust($code, $newCounterTo, $qty, [
                        'name_mitem' => request('nama_item_d')[$i],
                        'notrans'    => request('no'),
                        'doctype'    => 'RETUR_PENJUALAN',
                        'jenis'      => 'ADJUST-COUNTER_TO-PLUS',
                        'action'     => 'UPDATE',
                    ]);

                    // Insert item into existing in transaction
                    Mitem::where('code', $code)->update([
                        'exist_trans' => "Y",
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('treturjuallist')->with('success', 'Data berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('treturjuallist')
                ->with('error', 'Gagal mengupdate retur: ' . $th->getMessage());
        }
    }
    public function delete(Tretur_h $treturh){
        // Counter diambil dari header, bukan dari request(). Form hapus di
        // treturpenjualanlist.blade.php hanya mengirim _token, sehingga
        // request('counter_from') selalu null dan baris ini dulu selalu fatal.
        $counterFrom = StockCounterService::resolveCounter($treturh->counter_from);
        $counterTo   = StockCounterService::resolveCounter($treturh->counter);

        if (!$counterFrom || !$counterTo) {
            return redirect()->route('treturjuallist')
                ->with('error', 'Counter asal atau tujuan retur tidak ditemukan di master lokasi.');
        }

        DB::beginTransaction();

        try {
            $tretur_detail = Tretur_d::where('idh', $treturh->id)->get();
            // Kumpulkan semua kode SEBELUM delete
            $affected_kodes = $tretur_detail
                ->map(fn($d) => StockCounterService::normalizeCode($d->code))
                ->toArray();

            foreach ($tretur_detail as $tretur_old_item) {
                $code = StockCounterService::normalizeCode($tretur_old_item->code);
                $qty  = (int) $tretur_old_item->qty;

                // Kembalikan stok ke counter asal
                StockCounterService::adjust($code, $counterFrom, $qty, [
                    'name_mitem' => $tretur_old_item->name,
                    'notrans'    => $treturh->no,
                    'doctype'    => 'RETUR_PENJUALAN',
                    'jenis'      => 'DELETE-COUNTER_FROM-PLUS',
                    'action'     => 'DELETE',
                ]);

                // Tarik kembali stok dari counter tujuan
                StockCounterService::adjust($code, $counterTo, -$qty, [
                    'name_mitem' => $tretur_old_item->name,
                    'notrans'    => $treturh->no,
                    'doctype'    => 'RETUR_PENJUALAN',
                    'jenis'      => 'DELETE-COUNTER_TO-MINUS',
                    'action'     => 'DELETE',
                ]);
            }

            Tretur_h::where('id', $treturh->id)->delete();
            Tretur_d::where('idh', $treturh->id)->delete();

            DB::commit();

            // Recheck exist_trans untuk semua item yang terdampak
            MitemExistTransService::recheckMany($affected_kodes);

            return redirect()->route('treturjuallist')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('treturjuallist')
                ->with('error', 'Gagal menghapus retur: ' . $th->getMessage());
        }
    }

    public function printpdf(Tretur_h $treturh){
        $treturds = Tretur_d::where('idh','=',$treturh->id)->get();
        $address = Mcounter::select('alamat')->where('name','=',$treturh->counter)->first();
        
        $array_warna = [];
        foreach($treturds as $treturd){
            $warna = Mitem::where('code', StockCounterService::normalizeCode($treturd->code))->first();
            $treturd['warna'] = optional($warna)->warna;
        }

        // 1 inch = 72 point
        // 1 inch = 2.54 cm
        // 10 cm = 10/2.54*72 = 283.464566929
        // 20 cm = 10/2.54*72 = 566.929133858
        $datenow = date("Y-m-d");
        $customPaper = array(0,0,684,792);
        $pdf = PDF::loadView('pages.Print.treturbrgpdf',[
            'treturh' => $treturh,
            'treturds' => $treturds,
            'address' => $address
        ])->setPaper($customPaper, 'portrait');
        return $pdf->stream($datenow."NO_RETUR/".$treturh->no);
    }
}
