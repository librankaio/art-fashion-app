<?php

namespace App\Http\Controllers;

use App\Models\Mitem;
use App\Models\MitemCounters;
use App\Models\Mwarna;
use App\Services\MitemExistTransService;
use App\Services\MitemRenameService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables as DataTables;
use App\Services\StockCounterService;

class ControllerMasterDataItem extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->search)) {
            $warnas = Mwarna::select('code','name')->get();
            $datas = Mitem::select('id','code','name','name_lbl','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice','exist_trans')
            ->where('code','LIKE','%'.$request->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
            return view('pages.Master.mdataitem',[
                'datas' => $datas,
                'warnas' => $warnas
            ]);
        }
            $warnas = Mwarna::select('code','name')->get();
            $datas = Mitem::select('id','code','name','name_lbl','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice','exist_trans')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
            return view('pages.Master.mdataitem',[
                'datas' => $datas,
                'warnas' => $warnas
        ]);
    }

    public function post(Request $request){
        // Kode dinormalisasi memakai aturan yang sama dengan seluruh aplikasi,
        // supaya baris mitems_counters yang dibuat di bawah bisa ditemukan lagi
        // oleh controller transaksi.
        $kode = StockCounterService::normalizeCode($request->kode);
        if ($kode === '') {
            return redirect()->back()->with('error', 'Kode item tidak boleh kosong');
        }
        $availcode = Mitem::where('code', '=', $kode)->first();
        $counter = session('counter');
        $nik = session('nik');
        if($availcode != null){
            return redirect()->back()->with('error', 'Kode sudah terdaftar');
        }else{
            Mitem::create([  
                'name' => $request->nama,
                'name_lbl' => $request->name_lbl,
                'code' => $kode,
                'warna' => $request->warna,
                'kategori' => $request->kategori,
                'barcode' => $request->barcode,
                'hrgjual' => (float) str_replace(',', '', $request->price),
                'size' => $request->size,
                'satuan' => $request->satuan,
                'material' => $request->material,
                'gross' => (float) str_replace(',', '', $request->price_gross),
                'nett' => (float) str_replace(',', '', $request->price_nett),
                'spcprice' => (float) str_replace(',', '', $request->price_special),
            ]);
            DB::insert(
                "INSERT INTO mitems_counters (code_mitem, name_mitem, code_mcounters, name_mcounters, stock)
                SELECT ?, ?, code, name, 0 FROM mcounters",
                [$kode, $request->nama]
            );
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function  getmitem(Request $request){
        $search = $request->search;

        if($search == ''){
            $mitems = Mitem::orderby('name','asc')->select('id','name','code')->limit(30)->get();
        }else{
            $mitems = Mitem::orderby('name','asc')->select('id','name','code')->where('code','LIKE','%'.$search.'%')->limit(30)->get();
        }
        
        $response = array();
        foreach($mitems as $mitem){
            $response[] = array(
                "id"=>$mitem->code,
                "text"=>$mitem->code." - ".$mitem->name
            );
        }

      return response()->json($response);
    }

    public function getstock(Request $request){
        // $stock dulu hanya di-assign di dalam if, sehingga request tanpa kode
        // menghasilkan "Undefined variable $stock".
        $kode = StockCounterService::normalizeCode($request->kode);
        $counter = StockCounterService::resolveCounter($request->counter_asal);

        if ($kode === '' || !$counter) {
            return json_encode(['stock' => 0]);
        }

        return json_encode([
            'stock' => StockCounterService::currentStock($kode, $counter),
        ]);
    }

    public function getpriceitem(Request $request){
        $kode = $request->kode;
        if($kode != ''){
            $stock = Mitem::select('hrgjual')->where('code','=',$kode)->first();
        }
        return json_encode($stock);
    }

    public function getedit(Mitem $mitem){
        return view('pages.Master.mdataitemedit',['mitem' => $mitem]);
    }

    public function update(Mitem $mitem){
        $newKode = StockCounterService::normalizeCode(request('kode'));
        // Kode lama diambil dari database, bukan dari hidden input old_kode
        // yang bisa basi atau dimanipulasi.
        $oldKode = StockCounterService::normalizeCode($mitem->code);
        $codeChanged = $newKode !== $oldKode;
        // Collation MySQL case-insensitive: "af1" dan "AF1" dianggap sama.
        $caseOnly = $codeChanged && strcasecmp($newKode, $oldKode) === 0;

        if ($newKode === '') {
            return redirect()->back()->with('error', 'Kode item tidak boleh kosong');
        }
        if (mb_strlen($newKode) > 64) {
            return redirect()->back()->with('error', 'Kode item maksimal 64 karakter');
        }

        if ($codeChanged) {
            if (Mitem::where('code', $newKode)->where('id', '!=', $mitem->id)->exists()) {
                return redirect()->back()->with('error', "Kode '$newKode' sudah dipakai item lain.");
            }

            // Kode baru masih punya data sisa (item lama yang terhapus / hasil
            // import). Kalau dilanjutkan, riwayat & stoknya tergabung ke item ini.
            if (!$caseOnly) {
                $orphanStock = DB::table('mitems_counters')
                    ->where('code_mitem', $newKode)
                    ->where('stock', '!=', 0)
                    ->exists();
                if ($orphanStock || MitemExistTransService::isUsed($newKode)) {
                    return redirect()->back()->with('error',
                        "Kode '$newKode' masih memiliki data transaksi/stok lama. Gunakan kode lain.");
                }
            }
        }

        try {
            $transRows = DB::transaction(function () use ($mitem, $newKode, $oldKode, $codeChanged, $caseOnly) {
                Mitem::whereKey($mitem->id)->lockForUpdate()->first();

                Mitem::where('id', '=', $mitem->id)->update([
                    'name' => request('nama'),
                    'name_lbl' => request('name_lbl'),
                    'code' => $newKode,
                    'warna' => request('warna'),
                    'kategori' => request('kategori'),
                    'barcode' => request('barcode'),
                    'hrgjual' => (float) str_replace(',', '', request('price')),
                    'size' => request('size'),
                    'satuan' => request('satuan'),
                    'material' => request('material'),
                    'gross' => (float) str_replace(',', '', request('price_gross')),
                    'nett' => (float) str_replace(',', '', request('price_nett')),
                    'spcprice' => (float) str_replace(',', '', request('price_special')),
                ]);

                $transRows = 0;
                if ($codeChanged) {
                    if (!$caseOnly) {
                        // Baris counter yatim ber-stok 0 milik kode baru dibuang
                        // supaya tidak dobel dengan baris hasil rename.
                        DB::table('mitems_counters')->where('code_mitem', $newKode)->delete();
                    }
                    $transRows = MitemRenameService::rename($oldKode, $newKode);
                }

                // Nama di mitems_counters selalu ikut master, termasuk saat hanya nama yang diubah.
                DB::table('mitems_counters')
                    ->where('code_mitem', $newKode)
                    ->update(['name_mitem' => request('nama')]);

                MitemExistTransService::recheckMany([$oldKode, $newKode]);

                return $transRows;
            });
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('error', 'Gagal update item: ' . $e->getMessage());
        }

        $message = 'Data berhasil di update';
        if ($codeChanged) {
            $message .= ". Kode '$oldKode' diganti menjadi '$newKode' di $transRows baris transaksi.";
        }

        return redirect()->route('mitem')->with('success', $message);
    }

    //OLD DELETE
    // public function delete(Mitem $mitem){
    //     Mitem::find($mitem->id)->delete();
    //     DB::select( DB::raw("delete from mitems_counters where code_mitem = '$mitem->code' "));
    //     return redirect()->route('mitem')->with('success', 'Data berhasil di hapus');
    // }

    public function delete(Mitem $mitem){
        $cleanCode = StockCounterService::normalizeCode($mitem->code);

        // Cek di semua tabel transaksi (daftar tabelnya di MitemExistTransService)
        if (MitemExistTransService::isUsed($cleanCode)) {
            // Pastikan flag konsisten
            Mitem::where('code', $cleanCode)->update(['exist_trans' => 'Y']);
            return redirect()->route('mitem')
                ->with('error', "Item '$mitem->code' masih digunakan di transaksi sehingga tidak bisa dihapus.");
        }

        // Aman → hapus counter mapping dan item
        // Dulu memakai LIKE 'kode%', sehingga menghapus item AF1 ikut
        // menghapus baris counter milik AF10, AF11, AF123, dan seterusnya.
        DB::delete("DELETE FROM mitems_counters WHERE code_mitem = ?", [$cleanCode]);
        $mitem->delete();

        return redirect()->route('mitem')
            ->with('success', 'Data berhasil dihapus');
    }
    
    public function print(Mitem $mitem){

        $datenow = date("Y-m-d");
        $customPaper = array(0,0,85.039,141.732);
        $pdf = Pdf::loadView('pages.Print.mitemprint', [
            'mitem'=>$mitem
        ])->setPaper($customPaper, 'portrait');
        return $pdf->stream($datenow."_ITEM/".$mitem->code);
    }

    public function barcode(Mitem $mitem){

        $datenow = date("Y-m-d");
        $customPaper = array(0,0,85.039,141.732);
        if($mitem->barcode == null){
            $mitem->setAttribute('barcode', 'none');
        }
        // dd($mitem);
        $pdf = Pdf::loadView('pages.Print.barcodemitem', [
            'mitem'=>$mitem
        ])->setPaper($customPaper, 'portrait');
        return $pdf->stream($datenow."_ITEM/".$mitem->code);
    }

    public function exportpdf(){
        
        $customPaper = array(0,0,85.039,141.732);
        $pdf = PDF::loadView('pages.Print.mitemprint2')->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }

    public function exportExcel(Request $request)
    {
        $results = Mitem::select('id','code','name','name_lbl','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice','exist_trans')->get();
        return view('pages.Print.Excel.mitemexcl', compact('results'));
    }
}
