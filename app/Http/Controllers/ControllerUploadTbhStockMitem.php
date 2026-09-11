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
        $import = new MitemAddStockImport;
        Excel::import($import, $request->file_upload);

        $msg = "Tambah stock diproses: {$import->applied} baris.";
        if ($import->skipped > 0) {
            $msg .= " Dilewati: {$import->skipped} baris.";
            return redirect()->route('uploadtbhstock')
                ->with('error', $msg)
                ->with('import_errors', array_slice($import->errors, 0, 50));
        }

        return redirect()->route('uploadtbhstock')->with('success', $msg);
    }
}
