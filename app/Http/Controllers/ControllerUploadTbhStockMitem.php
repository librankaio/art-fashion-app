<?php

namespace App\Http\Controllers;

use App\Imports\MitemAddStockImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ControllerUploadTbhStockMitem extends Controller
{
    //
    public function index(){
        return view('pages.Upload.uploadtambahstock');
    }

    public function uploadpost(Request $request){
        Excel::import(new MitemAddStockImport, $request->file_upload);
        
        return redirect()->route('uploadtbhstock')->with('success', 'User Imported Successfully');
    }
}
