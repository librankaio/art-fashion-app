<?php

namespace App\Http\Controllers;

use App\Imports\MitemCountersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ControllerUploadMitemCounter extends Controller
{
    public function index(){
        return view('pages.Upload.mitemcounterupload');
    }

    public function uploadpost(Request $request){
        $import = new MitemCountersImport;
        Excel::import($import, $request->file_upload);

        // Jangan lagi selalu bilang sukses: dulu baris yang tidak cocok
        // diam-diam tidak melakukan apa-apa tapi user tetap melihat
        // "Imported Successfully".
        $msg = "Stock counter diupdate: {$import->applied} baris.";
        if ($import->skipped > 0) {
            $msg .= " Dilewati: {$import->skipped} baris.";
            return redirect()->route('uploadmitemcounter')
                ->with('error', $msg)
                ->with('import_errors', array_slice($import->errors, 0, 50));
        }

        return redirect()->route('uploadmitemcounter')->with('success', $msg);
    }
}
