<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\Tsj_d;
use App\Models\Tsj_h;
use App\Models\Tsob_h;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransSuratJalan extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        $mitems = Mitem::select('id','code','name')->get();
        $sobs = Tsob_h::select('id','no','tgl','counter','note','grdtotal','user',)->get();
        $notrans = DB::select("select fgetcode('tsj') as codetrans");
        return view('pages.Transaksi.tsuratjalan',[
            'counters' => $counters,
            'mitems' => $mitems,
            'sobs' => $sobs,
            'notrans' => $notrans,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());

        $checkexist = Tsj_h::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tsj_h::create([
                'no' => $request->no,
                'counter' => $request->counter,
                'jenis' => $request->jenis,
                'tgl' => $request->dt,
                'note' => $request->note,
                'no_sob' => $request->nosob,
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
            ]);
            $idh_loop = Tsj_h::select('id')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }
    
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tsj_d::create([
                    'idh' => $idh,
                    'no_sj' => $request->no,
                    'code' => $request->kode_d[$i],
                    'name' => $request->namaitem_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'satuan' => $request->satuan_d[$i],
                    'subtotal' => (float) str_replace(',', '', $request->subtot_d[$i]),
                    'hrgjual' => (float) str_replace(',', '', $request->hrgjual_d[$i]),
                ]);
                $count++;
            }
            if($count == $countrows){
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function list(){
        $tsjhs = Tsj_h::select('id','no','tgl','counter','note','grdtotal','user',)->orderBy('created_at', 'asc')->get();
        $tsjds = Tsj_d::select('id','idh','no_sj','code','name','qty','satuan','hrgjual','subtotal',)->get();
        return view('pages.Transaksi.tsuratjalanlist',[
            'tsjhs' => $tsjhs,
            'tsjds' => $tsjds
        ]);
    }

    public function getedit(Tsj_h $tsjh){
        $counters = Mcounter::select('id','code','name')->get();
        $mitems = Mitem::select('id','code','name')->get();
        $sobs = Tsob_h::select('id','no','tgl','counter','note','grdtotal','user',)->get();
        $tsjds = Tsj_d::select('id','idh','no_sj','code','name','qty','satuan','hrgjual','subtotal',)->where('idh','=',$tsjh->id)->get();
        return view('pages.Transaksi.tsuratjalanedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'sobs' => $sobs,
            'tsjh' => $tsjh,
            'tsjds' => $tsjds,
        ]);
    }

    public function update(Tsj_h $tsjh){
        // dd(request()->all());
        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_sjh = request('no');
        }
        DB::delete('delete from tsj_ds where no_sj = ?', [$no_sjh] );
        Tsj_h::where('id', '=', $tsjh->id)->update([
            'no' => request('no'),
            'counter' => request('counter'),
            'jenis' => request('jenis'),
            'tgl' => request('dt'),
            'note' => request('note'),
            'no_sob' => request('nosob'),
            'grdtotal' =>  (float) str_replace(',', '', request('price_total'))
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            Tsj_d::create([
                'idh' => $tsjh->id,
                'no_sj' => request('no')[$i],
                'code' => request('kode_d')[$i],
                'name' => request('namaitem_d')[$i],
                'qty' => request('quantity_d')[$i],
                'satuan' => request('satuan_d')[$i],
                'hrgjual' => (float) str_replace(',', '', request('hrgjual_d')[$i]),
                'subtotal' => (float) str_replace(',', '', request('subtot_d')[$i])
            ]);
            $count++;
        }
        
        if($count == $countrows){
            return redirect()->route('tsuratjalanlist');
        }
    }

    public function delete(Tsj_h $tsjh){
        Tsj_h::find($tsjh->id)->delete();
        Tsj_d::find($tsjh->id)->where('idh','=',$tsjh->id)->get();

        return redirect()->route('tsuratjalanlist');
    }

    public function print(Tsj_h $tsjh){
        
        $tsjds = Tsj_d::find($tsjh->id)->where('idh','=',$tsjh->id)->get();
        
        // dd($tsjds);
        return view('pages.Print.tsuratjalanprint',[
            'tsjh' => $tsjh,
            'tsjds' => $tsjds
        ]);
    }
}
