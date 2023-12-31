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

            $auth_mjenisbayar = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mjenisbayar')->first();

            if($auth_mjenisbayar != null){
                $request->session()->put('mjenisbayar_save', $auth_mjenisbayar->save);
                $request->session()->put('mjenisbayar_open', $auth_mjenisbayar->open);
                $request->session()->put('mjenisbayar_updt', $auth_mjenisbayar->updt);
                $request->session()->put('mjenisbayar_dlt', $auth_mjenisbayar->dlt);
                $request->session()->put('mjenisbayar_print', $auth_mjenisbayar->print);
            }     

            $auth_sldawaltoko = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'sldawaltoko')->first();

            if($auth_sldawaltoko != null){
                $request->session()->put('sldawaltoko_save', $auth_sldawaltoko->save);
                $request->session()->put('sldawaltoko_open', $auth_sldawaltoko->open);
                $request->session()->put('sldawaltoko_updt', $auth_sldawaltoko->updt);
                $request->session()->put('sldawaltoko_dlt', $auth_sldawaltoko->dlt);
                $request->session()->put('sldawaltoko_print', $auth_sldawaltoko->print);
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
               
            $auth_texpense = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'texpense')->first();

            if($auth_texpense != null){
                $request->session()->put('texpense_save', $auth_texpense->save);
                $request->session()->put('texpense_open', $auth_texpense->open);
                $request->session()->put('texpense_updt', $auth_texpense->updt);
                $request->session()->put('texpense_dlt', $auth_texpense->dlt);
                $request->session()->put('texpense_print', $auth_texpense->print);
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

            $auth_romsetperitem = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'romsetperitem')->first();

            if($auth_romsetperitem != null){
                $request->session()->put('romsetperitem_save', $auth_romsetperitem->save);
                $request->session()->put('romsetperitem_open', $auth_romsetperitem->open);
                $request->session()->put('romsetperitem_updt', $auth_romsetperitem->updt);
                $request->session()->put('romsetperitem_dlt', $auth_romsetperitem->dlt);
                $request->session()->put('romsetperitem_print', $auth_romsetperitem->print);
            }            

            $auth_romsetpercounter = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'romsetpercounter')->first();

            if($auth_romsetpercounter != null){
                $request->session()->put('romsetpercounter_save', $auth_romsetpercounter->save);
                $request->session()->put('romsetpercounter_open', $auth_romsetpercounter->open);
                $request->session()->put('romsetpercounter_updt', $auth_romsetpercounter->updt);
                $request->session()->put('romsetpercounter_dlt', $auth_romsetpercounter->dlt);
                $request->session()->put('romsetpercounter_print', $auth_romsetpercounter->print);
            }         

            $auth_rstockpercounter = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'rstockpercounter')->first();

            if($auth_rstockpercounter != null){
                $request->session()->put('rstockpercounter_save', $auth_rstockpercounter->save);
                $request->session()->put('rstockpercounter_open', $auth_rstockpercounter->open);
                $request->session()->put('rstockpercounter_updt', $auth_rstockpercounter->updt);
                $request->session()->put('rstockpercounter_dlt', $auth_rstockpercounter->dlt);
                $request->session()->put('rstockpercounter_print', $auth_rstockpercounter->print);
            }            

            $auth_rmutasistock = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'rmutasistock')->first();

            if($auth_rmutasistock != null){
                $request->session()->put('rmutasistock_save', $auth_rmutasistock->save);
                $request->session()->put('rmutasistock_open', $auth_rmutasistock->open);
                $request->session()->put('rmutasistock_updt', $auth_rmutasistock->updt);
                $request->session()->put('rmutasistock_dlt', $auth_rmutasistock->dlt);
                $request->session()->put('rmutasistock_print', $auth_rmutasistock->print);
            }         

            $auth_rstockoverview = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'rstockoverview')->first();

            if($auth_rstockoverview != null){
                $request->session()->put('rstockoverview_save', $auth_rstockoverview->save);
                $request->session()->put('rstockoverview_open', $auth_rstockoverview->open);
                $request->session()->put('rstockoverview_updt', $auth_rstockoverview->updt);
                $request->session()->put('rstockoverview_dlt', $auth_rstockoverview->dlt);
                $request->session()->put('rstockoverview_print', $auth_rstockoverview->print);
            }    

            $auth_rlapoutlet = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'rlapoutlet')->first();

            if($auth_rlapoutlet != null){
                $request->session()->put('rlapoutlet_save', $auth_rlapoutlet->save);
                $request->session()->put('rlapoutlet_open', $auth_rlapoutlet->open);
                $request->session()->put('rlapoutlet_updt', $auth_rlapoutlet->updt);
                $request->session()->put('rlapoutlet_dlt', $auth_rlapoutlet->dlt);
                $request->session()->put('rlapoutlet_print', $auth_rlapoutlet->print);
            }            

            $auth_umdataitem = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'umdataitem')->first();

            if($auth_umdataitem != null){
                $request->session()->put('umdataitem_save', $auth_umdataitem->save);
                $request->session()->put('umdataitem_open', $auth_umdataitem->open);
                $request->session()->put('umdataitem_updt', $auth_umdataitem->updt);
                $request->session()->put('umdataitem_dlt', $auth_umdataitem->dlt);
                $request->session()->put('umdataitem_print', $auth_umdataitem->print);
            }

            $auth_umitemcounter = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'umitemcounter')->first();

            if($auth_umitemcounter != null){
                $request->session()->put('umitemcounter_save', $auth_umitemcounter->save);
                $request->session()->put('umitemcounter_open', $auth_umitemcounter->open);
                $request->session()->put('umitemcounter_updt', $auth_umitemcounter->updt);
                $request->session()->put('umitemcounter_dlt', $auth_umitemcounter->dlt);
                $request->session()->put('umitemcounter_print', $auth_umitemcounter->print);
            }            
            // dd(session()->all());
            return redirect()->intended('/home');
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
