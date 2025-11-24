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
            $mitems = Mitem::orderby('name','asc')->select('id','name','code')->limit(10)->get();
        }else{
            $mitems = Mitem::orderby('name','asc')->select('id','name','code')->where('code','LIKE','%'.$search.'%')->limit(10)->get();
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
        Mitem::where('id', '=', $mitem->id)->update([
            'name' => request('nama'),
            'name_lbl' => request('name_lbl'),
            'code' => request('kode'),
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
        $kode = request('kode');
        $nama = request('nama');
        $old_kode = request('old_kode');
        DB::update( DB::raw("update mitems_counters set code_mitem = '$kode', name_mitem = '$nama'
        where code_mitem = '$old_kode'"));

        return redirect()->route('mitem')->with('success', 'Data berhasil di update');
    }

    //OLD DELETE
    // public function delete(Mitem $mitem){
    //     Mitem::find($mitem->id)->delete();
    //     DB::select( DB::raw("delete from mitems_counters where code_mitem = '$mitem->code' "));
    //     return redirect()->route('mitem')->with('success', 'Data berhasil di hapus');
    // }

    public function delete(Mitem $mitem){
        // Ambil kode yang di-strtok (ambil dari depan sebelum spasi)
        $cleanCode = strtok($mitem->code, " ");

        // Daftar tabel yang harus dicek
        $checkModels = [
            Tadj_d::class,
            Tpembelian_d::class,
            Tpenjualan_d::class,
            Tretur_d::class,
            Tsob_d::class,
            Tsj_d::class,
            Tpenerimaan_d::class
        ];

        // Loop cek ke setiap tabel
        foreach ($checkModels as $model) {
            $exists = $model::where('code', 'like', $cleanCode . '%')->exists();

            if ($exists) {
                return redirect()->route('mitem')
                    ->with('error', "Item '$mitem->code' masih digunakan di tabel " . class_basename($model) . " sehingga tidak bisa dihapus.");
            }
        }

        // Hapus mitems_counters tanpa pengecekan
        DB::select(DB::raw("DELETE FROM mitems_counters WHERE code_mitem LIKE '{$cleanCode}%'"));

        // Jika aman → hapus
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
