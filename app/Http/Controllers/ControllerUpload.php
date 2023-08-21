<?php

namespace App\Http\Controllers;

use App\Imports\MitemsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ControllerUpload extends Controller
{
    public function index(){
        return view('pages.Upload.sampleupload');
    }

    public function uploadpost(Request $request){
        Excel::import(new MitemsImport, $request->file);

        return redirect()->route('uploadsample')->with('success', 'User Imported Successfully');
    }
}
