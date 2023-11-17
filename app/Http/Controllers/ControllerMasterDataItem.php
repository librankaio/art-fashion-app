<?php

namespace App\Http\Controllers;

use App\Models\Mitem;
use App\Models\MitemCounters;
use App\Models\Mwarna;
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
        // if ($request->ajax()) {
        //     $data = Mitem::select('id','code','name','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice')->get();           
        //     // return datatables()->of($data)->toJson();

        //     return datatables()->of($data)
        //         ->addIndexColumn()
        //         ->addColumn('action', function($data){
        //             $token = request()->session()->token();
 
        //             $token = csrf_token();
        //             $actionBtn = '<a href="/mitem/'.$data->id.'/edit"
        //             class="btn btn-icon icon-left btn-primary"><i class="far fa-edit">
        //                 Edit</i></a>
                        
        //                 <form action="/mitem/delete/'.$data->id.'" id="del-'.$data->id.'"
        //                     method="POST" class="px-2">
        //                     <input type="hidden" name="_token" value="'.$token.'" />
        //                     <button class="btn btn-icon icon-left btn-danger"
        //                         id="del-'.$data->id.'" type="submit"
        //                         data-confirm="WARNING!|Do you want to delete '.$data->id.' data?"
        //                         data-confirm-yes="submitDel('.$data->id.')"><i
        //                             class="fa fa-trash">
        //                             Delete</i></button>
        //                 </form>';
        //             return $actionBtn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        // $datas = Mitem::select('id','code','name','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice')->get();

        if (isset($request->search)) {
            $warnas = Mwarna::select('code','name')->get();
            $datas = Mitem::select('id','code','name','name_lbl','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice','exist_trans')->where('code','LIKE','%'.$request->search.'%')->paginate(50);
            return view('pages.Master.mdataitem',[
                'datas' => $datas,
                'warnas' => $warnas
            ]);
        }
            $warnas = Mwarna::select('code','name')->get();
            $datas = Mitem::select('id','code','name','name_lbl','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice','exist_trans')->paginate(50);
            return view('pages.Master.mdataitem',[
                'datas' => $datas,
                'warnas' => $warnas
        ]);
    }

    public function search(Request $request){

    }

    public function post(Request $request){
        $availcode = Mitem::where('code', '=', $request->kode)->first();
        $counter = session('counter');
        $nik = session('nik');
        if($availcode != null){
            return redirect()->back()->with('error', 'Kode sudah terdaftar');
        }else{
            // DB::select( DB::raw("INSERT INTO mitems_counters (code_mitem, name_mitem, code_mcounters, name_mcounters)
            // (SELECT code, name, '$request->kode', '$counter' FROM mitems TA);") );
            Mitem::create([  
                'name' => $request->nama,
                'name_lbl' => $request->name_lbl,
                'code' => $request->kode,
                'warna' => $request->warna,
                'kategori' => $request->kategori,
                'hrgjual' => (float) str_replace(',', '', $request->price),
                'size' => $request->size,
                'satuan' => $request->satuan,
                'material' => $request->material,
                'gross' => (float) str_replace(',', '', $request->price_gross),
                'nett' => (float) str_replace(',', '', $request->price_nett),
                'spcprice' => (float) str_replace(',', '', $request->price_special),
            ]);
            DB::insert( DB::raw("insert into mitems_counters (code_mitem, name_mitem, code_mcounters, name_mcounters, stock)
            select '$request->kode', '$request->nama', code, name, 0 FROM mcounters"));
            // DB::select( DB::raw("INSERT INTO mitems_counters (code_mitem, name_mitem, code_mcounters, name_mcounters, stock)
            // select '$request->kode', '$request->nama', code, name, 0 FROM mcounters"));
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
    }

    // public function  getmitem(Request $request){
    //     // $datas = Mitem::select('id','code','name','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice')->get();

    //     if ($request->ajax()) {
    //         $data = Mitem::select('id','code','name','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice')->get();
    //         return datatables()->of($data)->toJson();
    //         // return datatables()->of($data)
    //         //     ->addIndexColumn()
    //         //     ->addColumn('action', function($row){
    //         //         $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
    //         //         return $actionBtn;
    //         //     })
    //         //     ->rawColumns(['action'])
    //         //     ->make(true)
    //         //     ->toJson();
    //     }
    //     // return json_encode($datas);
    // }
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
            $stock = MitemCounters::select('stock')->where('code_mitem','=',$kode)->where('name_mcounters','=',$counter_asal)->first();
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
        // dd(request()->all());
        Mitem::where('id', '=', $mitem->id)->update([
            'name' => request('nama'),
            'name_lbl' => request('name_lbl'),
            'code' => request('kode'),
            'warna' => request('warna'),
            'kategori' => request('kategori'),
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

    public function delete(Mitem $mitem){
        Mitem::find($mitem->id)->delete();
        DB::select( DB::raw("delete from mitems_counters where code_mitem = '$mitem->code' "));
        return redirect()->route('mitem')->with('success', 'Data berhasil di hapus');
    }
    
    public function print(Mitem $mitem){
        // dd($mitem);
        // return view('pages.Print.mitemprint',[
        //     'mitem' => $mitem
        // ]);

        $datenow = date("Y-m-d");
        $customPaper = array(0,0,85.039,141.732);
        $pdf = Pdf::loadView('pages.Print.mitemprint', [
            'mitem'=>$mitem
        ])->setPaper($customPaper, 'portrait');
        return $pdf->stream($datenow."_ITEM/".$mitem->code);
    }

    public function exportpdf(){
        // $pdf = Pdf::loadHTML('<h1>TEST</h1>');

        // return $pdf->stream();

        // $pdf = App::make('dompdf.wrapper');
        // return $pdf->stream();
        
        $customPaper = array(0,0,85.039,141.732);
        $pdf = PDF::loadView('pages.Print.mitemprint2')->setPaper($customPaper, 'landscape');
        // $pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();
    }

    public function exportExcel(Request $request)
    {
        $results = Mitem::select('id','code','name','name_lbl','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice','exist_trans')->get();
        // dd($results);
        return view('pages.Print.Excel.mitemexcl', compact('results'));
    }
}
