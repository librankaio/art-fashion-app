<?php

namespace App\Http\Controllers;

use App\Models\Mitem;
use Illuminate\Http\Request;
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
        $datas = Mitem::select('id','code','name','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice')->paginate(50);
        // $datas = Mitem::select('id','code','name','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice')->get();
        return view('pages.Master.mdataitem',[
            'datas' => $datas
        ]);
    }

    public function post(Request $request){
        // dd($request->all());
        Mitem::create([
            'name' => $request->nama,
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
        return redirect()->back();
    }

    public function  getmitem(Request $request){
        // $datas = Mitem::select('id','code','name','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice')->get();

        if ($request->ajax()) {
            $data = Mitem::select('id','code','name','warna','kategori','hrgjual','size','satuan','material','gross','nett','spcprice')->get();
            return datatables()->of($data)->toJson();
            // return datatables()->of($data)
            //     ->addIndexColumn()
            //     ->addColumn('action', function($row){
            //         $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
            //         return $actionBtn;
            //     })
            //     ->rawColumns(['action'])
            //     ->make(true)
            //     ->toJson();
        }
        // return json_encode($datas);
    }

    public function getedit(Mitem $mitem){
        return view('pages.Master.mdataitemedit',[ 'mitem' => $mitem]);
    }

    public function update(Mitem $mitem){
        Mitem::where('id', '=', $mitem->id)->update([
            'name' => request('nama'),
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

        return redirect()->route('mitem');
    }

    public function delete(Mitem $mitem){
        Mitem::find($mitem->id)->delete();
        return redirect()->route('mitem');
    }
}
