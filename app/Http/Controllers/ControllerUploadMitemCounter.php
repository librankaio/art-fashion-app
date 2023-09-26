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
        // dd($request->all());
        Excel::import(new MitemCountersImport, $request->file_upload);

        return redirect()->route('uploadsample')->with('success', 'User Imported Successfully');
    }
}
