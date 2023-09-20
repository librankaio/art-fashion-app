<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\Mjenispayment;
use App\Models\Tpenjualan_d;
use App\Models\Tpenjualan_h;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransBonPenjualan extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->where('name','=',session('counter'))->get();
        $mitems = Mitem::select('id','code','name')->get();
        $payments = Mjenispayment::select('id','code','name')->get();
        $notrans = DB::select("select fgetcode('tpenjualan') as codetrans");
        return view('pages.Transaksi.tbonpenjualan',[
            'counters' => $counters,
            'mitems' => $mitems,
            'payments' => $payments,
            'notrans' => $notrans,
        ]);
    }

    public function post(Request $request){
        // dd($request->all());

        $checkexist = Tpenjualan_h::select('id','no')->where('no','=', $request->no)->first();
        if($checkexist == null){
            Tpenjualan_h::create([
                'no' => $request->no,
                'tgl' => $request->dt,
                'counter' => $request->counter,
                'jenis_promosi' => $request->jenis_promosi,
                'note' => $request->note,
                'payment_mthd' => $request->payment_mthd,
                'noreff' => $request->noreff,
                'diskon' =>  (float) str_replace(',', '', $request->price_disc),
                'grdtotal' => (float) str_replace(',', '', $request->price_total),
            ]);
            $idh_loop = Tpenjualan_h::select('id')->where('no','=',$request->no)->get();
            for($j=0; $j<sizeof($idh_loop); $j++){
                $idh = $idh_loop[$j]->id;
            }
    
            $countrows = sizeof($request->no_d);
            $count=0;
            for ($i=0;$i<sizeof($request->no_d);$i++){
                Tpenjualan_d::create([
                    'idh' => $idh,
                    'no_penjualan' => $request->no,
                    'code' => $request->kode_d[$i],
                    'name' => $request->namaitem_d[$i],
                    'warna' => $request->warna_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'satuan' => $request->satuan_d[$i],
                    'qty' => $request->quantity_d[$i],
                    'diskon' => $request->diskon_d[$i],
                    'subtotal' => (float) str_replace(',', '', $request->subtot_d[$i]),
                    'hrgjual' => (float) str_replace(',', '', $request->hrgjual_d[$i]),
                    'disctot' => (float) str_replace(',', '', $request->totdisc_d[$i]),
                    'note' => $request->keterangan_d[$i],
                ]);
                
                // $stock_mitem = Mitem::select('stock')->where('code', '=', strtok($request->kode_d[$i], " "))->first();
                // dd($stock_mitem);

                $stock_mitem = Mitem::select('stock')->where('code', '=', strtok($request->kode_d[$i], " "))->first();
                // dd($stock_mitem);
                $stock_min = $stock_mitem->stock - $request->quantity_d[$i];
                Mitem::where('code', '=', strtok($request->kode_d[$i], " "))->update([
                    'stock' => (int)$stock_min,
                ]);
                $stock_mitem_counter = DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', session('counter'))
                ->first();
                $stock_counter_min = $stock_mitem_counter->stock-$request->quantity_d[$i];
                DB::table('mitems_counters')
                ->selectRaw('stock')
                ->where('code_mitem', '=', strtok($request->kode_d[$i], " "))
                ->where('name_mcounters', '=', session('counter'))
                ->update([
                    'stock' => (int)$stock_counter_min,
                ]);

                // Insert item into existing in transaction
                Mitem::where('code', '=', strtok($request->kode_d[$i], " "))->update([
                    'exist_trans' => "Y",
                ]);
                $count++;
            }
            // Mitem::where('id', '=', $mitem->id)->update([
            //     'name' => request('nama'),
            //     'code' => request('kode'),
            //     'warna' => request('warna'),
            //     'kategori' => request('kategori'),
            //     'hrgjual' => (float) str_replace(',', '', request('price')),
            //     'size' => request('size'),
            //     'satuan' => request('satuan'),
            //     'material' => request('material'),
            //     'gross' => (float) str_replace(',', '', request('price_gross')),
            //     'nett' => (float) str_replace(',', '', request('price_nett')),
            //     'spcprice' => (float) str_replace(',', '', request('price_special')),
            // ]);
            
            if($count == $countrows){
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function  getmitem(Request $request){
        $kode = $request->kode;
        if($kode == ''){
            $mitems = Mitem::select('id','code','name','satuan','hrgjual')->get();
        }else{
            $mitems = Mitem::select('id','code','name','satuan','hrgjual')->where('code','=',$kode)->get();
        }
        return json_encode($mitems);
    }

    public function list(){
        $tpenjualanhs = Tpenjualan_h::select('id','no','tgl','counter','note','payment_mthd','noreff','grdtotal',)->orderBy('created_at', 'asc')->get();
        $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','qty','satuan','hrgjual','diskon','subtotal','note',)->get();
        return view('pages.Transaksi.tbonpenjualanlist',[
            'tpenjualanhs' => $tpenjualanhs,
            'tpenjualands' => $tpenjualands
        ]);
    }

    public function getedit(Tpenjualan_h $tpenjualanh){
        $counters = Mcounter::select('id','code','name')->get();
        $mitems = Mitem::select('id','code','name')->get();
        $payments = Mjenispayment::select('id','code','name')->get();
        $tpenjualands = Tpenjualan_d::select('id','idh','no_penjualan','code','name','warna','qty','satuan','hrgjual','diskon','subtotal','disctot','note')->where('idh','=',$tpenjualanh->id)->get();
        return view('pages.Transaksi.tbonpenjualanedit',[
            'counters' => $counters,
            'mitems' => $mitems,
            'payments' => $payments,
            'tpenjualanh' => $tpenjualanh,
            'tpenjualands' => $tpenjualands,
        ]);
    }

    public function update(Tpenjualan_h $tpenjualanh){
        // dd(request()->all());
        for($x=0;$x<sizeof(request('id_d'));$x++){
            $getstock_old = Tpenjualan_d::where('id', '=', request('id_d')[$x])->first();
            // dd((int)$getstock_old->qty);
            // dd($getstock_old->code);
            $old_stock_mitem_counter = DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($getstock_old->code, " "))
            ->where('name_mcounters', '=', session('counter'))
            ->first();
            // dd($old_stock_mitem_counter->stock-(int)$getstock_old->qty);
            // Make stock counter value is equal to old stock
            $normalize_stock_counter = $old_stock_mitem_counter->stock-(int)$getstock_old->qty;
            DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok($getstock_old->code, " "))
            ->where('name_mcounters', '=', session('counter'))
            ->update([
                'stock' => (int)$normalize_stock_counter,
            ]);

            $stock_mitem_old = Mitem::select('stock')->where('code', '=', strtok($getstock_old->code, " "))->first();
            // Make stock mitem value is equal to mitem old stock
            // dd($stock_mitem_old->stock - (int)$getstock_old->qty);
            $normalize_stock_mitem = $stock_mitem_old->stock - (int)$getstock_old->qty;
            Mitem::where('code', '=', strtok($getstock_old->code, " "))->update([
                'stock' => (int)$normalize_stock_mitem,
            ]);
        }

        for($j=0;$j<sizeof(request('no_d'));$j++){
            $no_penjualan = request('no');
        }
        DB::delete('delete from tpenjualan_ds where no_penjualan = ?', [$no_penjualan] );
        Tpenjualan_h::where('id', '=', $tpenjualanh->id)->update([
            'no' => request('no'),
            'counter' => request('counter'),
            'jenis_promosi' => request('jenis_promosi'),
            'tgl' => request('dt'),
            'note' => request('note'),
            'payment_mthd' => request('payment_mthd'),
            'noreff' => request('noreff'),
            'diskon' =>  (float) str_replace(',', '', request('price_disc')),
            'grdtotal' =>  (float) str_replace(',', '', request('price_total'))
        ]);
        $count=0;
        $countrows = sizeof(request('no_d'));
        for ($i=0;$i<sizeof(request('no_d'));$i++){
            Tpenjualan_d::create([
                'idh' => $tpenjualanh->id,
                'no_penjualan' => request('no'),
                'code' => request('kode_d')[$i],
                'name' => request('namaitem_d')[$i],
                'warna' => request('warna_d')[$i],
                'qty' => request('quantity_d')[$i],
                'satuan' => request('satuan_d')[$i],
                'diskon' => request('diskon_d')[$i],
                'hrgjual' => (float) str_replace(',', '', request('hrgjual_d')[$i]),
                'subtotal' => (float) str_replace(',', '', request('subtot_d')[$i]),
                'disctot' => (float) str_replace(',', '', request('totdisc_d')[$i]),
                'note' => request('keterangan_d')[$i],
            ]);
            $stock_mitem = Mitem::select('stock')->where('code', '=', strtok(request('kode_d')[$i], " "))->first();
            $stock_sum = $stock_mitem->stock+request('quantity_d')[$i];
            Mitem::where('code', '=', strtok(request('kode_d')[$i], " "))->update([
                'stock' => (int)$stock_sum,
            ]);
            $stock_mitem_counter = DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
            ->where('name_mcounters', '=', session('counter'))
            ->first();
            // dd($stock_mitem_counter);
            $stock_counter_sum = $stock_mitem_counter->stock+request('quantity_d')[$i];
            DB::table('mitems_counters')
            ->selectRaw('stock')
            ->where('code_mitem', '=', strtok(request('kode_d')[$i], " "))
            ->where('name_mcounters', '=', session('counter'))
            ->update([
                'stock' => (int)$stock_counter_sum,
            ]);
            $count++;
        }
        
        if($count == $countrows){
            return redirect()->route('tbonjuallist');
        }
    }

    public function delete(Tpenjualan_h $tpenjualanh){
        Tpenjualan_h::find($tpenjualanh->id)->delete();
        Tpenjualan_d::where('idh','=',$tpenjualanh->id)->delete();

        return redirect()->route('treturjuallist');
    }

    public function print(Tpenjualan_h $tpenjualanh){
        $tpenjualands = Tpenjualan_d::where('idh','=',$tpenjualanh->id)->get();
        
        // dd($tpenjualands);
        return view('pages.Print.tbonjualprint',[
            'tpenjualanh' => $tpenjualanh,
            'tpenjualands' => $tpenjualands
        ]);
    }
}
