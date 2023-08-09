<?php

namespace App\Http\Controllers;


use App\Models\Mhakakses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerLogin extends Controller
{
    protected $name;
    protected $comp_code;
    protected $privilage;
    
    public function index(){
        return view('auth.login');
    }

    public function postLogin(Request $request){
        // dd(request()->all());
        if(Auth::attempt($request->only('nik', 'password'))){
            $request->session()->regenerate();
            $nik = Auth::User()->nik;
            $name = Auth::User()->name;
            $counter = Auth::User()->counter;
            $privilage = Auth::User()->privilage;
            $request->session()->put('nik', $nik);
            $request->session()->put('name', $name);
            $request->session()->put('privilage', $privilage);
            $request->session()->put('counter', $counter);
            
            $user = User::select('id','nik','name')->where('nik','=', $request->nik)->first();

            $auth_mitem = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mitem')->first();

            if($auth_mitem != null){
                $request->session()->put('mitem_save', $auth_mitem->save);
                $request->session()->put('mitem_open', $auth_mitem->open);
                $request->session()->put('mitem_updt', $auth_mitem->updt);
                $request->session()->put('mitem_dlt', $auth_mitem->dlt);
                $request->session()->put('mitem_print', $auth_mitem->print);
            }

            $auth_muser = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'muser')->first();

            if($auth_muser != null){
                $request->session()->put('muser_save', $auth_muser->save);
                $request->session()->put('muser_open', $auth_muser->open);
                $request->session()->put('muser_updt', $auth_muser->updt);
                $request->session()->put('muser_dlt', $auth_muser->dlt);
                $request->session()->put('muser_print', $auth_muser->print);
            }            

            $auth_mwarna = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mwarna')->first();

            if($auth_mwarna != null){
                $request->session()->put('mwarna_save', $auth_mwarna->save);
                $request->session()->put('mwarna_open', $auth_mwarna->open);
                $request->session()->put('mwarna_updt', $auth_mwarna->updt);
                $request->session()->put('mwarna_dlt', $auth_mwarna->dlt);
                $request->session()->put('mwarna_print', $auth_mwarna->print);
            }        

            $auth_mcounter = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mcounter')->first();

            if($auth_mcounter != null){
                $request->session()->put('mcounter_save', $auth_mcounter->save);
                $request->session()->put('mcounter_open', $auth_mcounter->open);
                $request->session()->put('mcounter_updt', $auth_mcounter->updt);
                $request->session()->put('mcounter_dlt', $auth_mcounter->dlt);
                $request->session()->put('mcounter_print', $auth_mcounter->print);
            }         

            $auth_mhakses = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mhakses')->first();

            if($auth_mhakses != null){
                $request->session()->put('mhakses_save', $auth_mhakses->save);
                $request->session()->put('mhakses_open', $auth_mhakses->open);
                $request->session()->put('mhakses_updt', $auth_mhakses->updt);
                $request->session()->put('mhakses_dlt', $auth_mhakses->dlt);
                $request->session()->put('mhakses_print', $auth_mhakses->print);
            }     

            $auth_tsob = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tsob')->first();

            if($auth_tsob != null){
                $request->session()->put('tsob_save', $auth_tsob->save);
                $request->session()->put('tsob_open', $auth_tsob->open);
                $request->session()->put('tsob_updt', $auth_tsob->updt);
                $request->session()->put('tsob_dlt', $auth_tsob->dlt);
                $request->session()->put('tsob_print', $auth_tsob->print);
            }     

            $auth_tpenerimaan = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tpenerimaan')->first();

            if($auth_tpenerimaan != null){
                $request->session()->put('tpenerimaan_save', $auth_tpenerimaan->save);
                $request->session()->put('tpenerimaan_open', $auth_tpenerimaan->open);
                $request->session()->put('tpenerimaan_updt', $auth_tpenerimaan->updt);
                $request->session()->put('tpenerimaan_dlt', $auth_tpenerimaan->dlt);
                $request->session()->put('tpenerimaan_print', $auth_tpenerimaan->print);
            }            

            $auth_tretur = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tretur')->first();

            if($auth_tretur != null){
                $request->session()->put('tretur_save', $auth_tretur->save);
                $request->session()->put('tretur_open', $auth_tretur->open);
                $request->session()->put('tretur_updt', $auth_tretur->updt);
                $request->session()->put('tretur_dlt', $auth_tretur->dlt);
                $request->session()->put('tretur_print', $auth_tretur->print);
            }            
            
            $auth_tbonjual = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tbonjual')->first();

            if($auth_tbonjual != null){
                $request->session()->put('tbonjual_save', $auth_tbonjual->save);
                $request->session()->put('tbonjual_open', $auth_tbonjual->open);
                $request->session()->put('tbonjual_updt', $auth_tbonjual->updt);
                $request->session()->put('tbonjual_dlt', $auth_tbonjual->dlt);
                $request->session()->put('tbonjual_print', $auth_tbonjual->print);
            }          

            $auth_tadjstock = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tadjstock')->first();

            if($auth_tadjstock != null){
                $request->session()->put('tadjstock_save', $auth_tadjstock->save);
                $request->session()->put('tadjstock_open', $auth_tadjstock->open);
                $request->session()->put('tadjstock_updt', $auth_tadjstock->updt);
                $request->session()->put('tadjstock_dlt', $auth_tadjstock->dlt);
                $request->session()->put('tadjstock_print', $auth_tadjstock->print);
            }        

            $auth_tsuratjalan = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tsuratjalan')->first();

            if($auth_tsuratjalan != null){
                $request->session()->put('tsuratjalan_save', $auth_tsuratjalan->save);
                $request->session()->put('tsuratjalan_open', $auth_tsuratjalan->open);
                $request->session()->put('tsuratjalan_updt', $auth_tsuratjalan->updt);
                $request->session()->put('tsuratjalan_dlt', $auth_tsuratjalan->dlt);
                $request->session()->put('tsuratjalan_print', $auth_tsuratjalan->print);
            }            

            $auth_tstopname = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tstopname')->first();

            if($auth_tstopname != null){
                $request->session()->put('tstopname_save', $auth_tstopname->save);
                $request->session()->put('tstopname_open', $auth_tstopname->open);
                $request->session()->put('tstopname_updt', $auth_tstopname->updt);
                $request->session()->put('tstopname_dlt', $auth_tstopname->dlt);
                $request->session()->put('tstopname_print', $auth_tstopname->print);
            }        

            $auth_tbelibrg = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tbelibrg')->first();

            if($auth_tbelibrg != null){
                $request->session()->put('tbelibrg_save', $auth_tbelibrg->save);
                $request->session()->put('tbelibrg_open', $auth_tbelibrg->open);
                $request->session()->put('tbelibrg_updt', $auth_tbelibrg->updt);
                $request->session()->put('tbelibrg_dlt', $auth_tbelibrg->dlt);
                $request->session()->put('tbelibrg_print', $auth_tbelibrg->print);
            }            
            // dd(session()->all());
            return redirect()->intended('/mwarna');
        }
        return redirect()->back();
    }

    public function logout(request $request){
        Auth::logout();
        // $current_date_time = Carbon::now()->toDateTimeString();
        // DB::table('userlog')->insert(['username' =>session()->get('username'), 'tbl'=>'ONLINE', 'idtbl'=> '0', 'notbl'=>'', 'act'=>'LOGOUT', 'comp_code'=>session()->get('comp_code'), 'usin'=>1,'datein'=>$current_date_time]);

        return redirect('/');
    }
}
