<?php

namespace App\Http\Controllers;

use App\Models\MsaldoAwal;
use Illuminate\Http\Request;

class ControllerMasterSaldoAwal extends Controller
{
    public function index()
    {
        $datas = MsaldoAwal::select('id','tgl','saldo','counter')->get();
        return view('pages.Master.msaldoawal',[
            'datas' => $datas,
        ]);
    }
}
