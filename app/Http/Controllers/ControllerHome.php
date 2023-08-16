<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerHome extends Controller
{
    public function index(){
        return view('pages.home');
    }
    public function uploadsample(){
        return view('pages.Upload.sampleupload');
    }
}
