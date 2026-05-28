<?php

namespace App\Http\Controllers;

use App\Models\Mitem;
use App\Models\MitemCounters;
use App\Models\Mwarna;
use App\Models\Tadj_d;
use App\Models\Tpembelian_d;
use App\Models\Tpenerimaan_d;
use App\Models\Tpenjualan_d;
use App\Models\Tretur_d;
use App\Models\Tsj_d;
use App\Models\Tsob_d;
use App\Models\Tstockopname_d;
use App\Services\MitemExistTransService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables as DataTables;

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
        $availcode = Mitem::where('code', '=', $request->kode)->first();
        $counter = session('counter');
        $nik = session('nik');
        if($availcode != null){
            return redirect()->back()->with('error', 'Kode sudah terdaftar');
        }else{
            Mitem::create([  
                'name' => $request->nama,
                'name_lbl' => $request->name_lbl,
                'code' => $request->kode,
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
                [$request->kode, $request->nama]
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
        $kode = $request->kode;
        $counter_asal = $request->counter_asal;
        if($kode != '' && $counter_asal != ''){
            $stock = MitemCounters::select('stock')->where('code_mitem','=',strtok($kode, " "))->where('name_mcounters','=',$counter_asal)->first();
        }
        return json_encode($stock);
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
        $newKode  = request('kode');
        $old_kode = request('old_kode');

        // Jika kode diubah tapi item sudah ada di transaksi → tolak
        if ($newKode !== $old_kode && $mitem->exist_trans === 'Y') {
            return redirect()->route('mitem')
                ->with('error', "Kode item tidak bisa diubah karena item '$old_kode' sudah digunakan di transaksi.");
        }

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

        // Sinkronkan mitems_counters jika kode berubah
        if ($newKode !== $old_kode) {
            DB::update(
                "UPDATE mitems_counters SET code_mitem = ?, name_mitem = ? WHERE code_mitem = ?",
                [$newKode, request('nama'), $old_kode]
            );
            // Recheck exist_trans untuk kode lama dan baru
            MitemExistTransService::recheckMany([$old_kode, $newKode]);
        } else {
            // Recheck exist_trans untuk item ini (preventif)
            MitemExistTransService::recheck($newKode);
        }

        return redirect()->route('mitem')->with('success', 'Data berhasil di update');
    }

    //OLD DELETE
    // public function delete(Mitem $mitem){
    //     Mitem::find($mitem->id)->delete();
    //     DB::select( DB::raw("delete from mitems_counters where code_mitem = '$mitem->code' "));
    //     return redirect()->route('mitem')->with('success', 'Data berhasil di hapus');
    // }

    public function delete(Mitem $mitem){
        $cleanCode = strtok($mitem->code, " ");

        // Cek di semua tabel transaksi (termasuk tstockopname_d yg pakai kolom kode_barang)
        $existsInTrans =
            Tadj_d::where('code', 'like', $cleanCode . '%')->exists()           ||
            Tpembelian_d::where('code', 'like', $cleanCode . '%')->exists()      ||
            Tpenjualan_d::where('code', 'like', $cleanCode . '%')->exists()      ||
            Tretur_d::where('code', 'like', $cleanCode . '%')->exists()          ||
            Tsob_d::where('code', 'like', $cleanCode . '%')->exists()            ||
            Tsj_d::where('code', 'like', $cleanCode . '%')->exists()             ||
            Tpenerimaan_d::where('code', 'like', $cleanCode . '%')->exists()     ||
            Tstockopname_d::where('kode_barang', 'like', $cleanCode . '%')->exists();

        if ($existsInTrans) {
            // Pastikan flag konsisten
            Mitem::where('code', $cleanCode)->update(['exist_trans' => 'Y']);
            return redirect()->route('mitem')
                ->with('error', "Item '$mitem->code' masih digunakan di transaksi sehingga tidak bisa dihapus.");
        }

        // Aman → hapus counter mapping dan item
        DB::delete("DELETE FROM mitems_counters WHERE code_mitem LIKE ?", [$cleanCode . '%']);
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
