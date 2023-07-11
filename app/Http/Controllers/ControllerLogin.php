<?php

namespace App\Http\Controllers;

use App\Models\AuthUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerLogin extends Controller
{
    protected $comp_name;
    protected $comp_code;
    protected $privilage;
    // protected $create_mitem;
    // protected $read_mitem;
    // protected $update_mitem;
    // protected $delete_mitem;
    // protected $create_user;
    // protected $read_user;
    // protected $update_user;
    // protected $delete_user;
    // protected $create_satuan;
    // protected $read_satuan;
    // protected $update_satuan;
    // protected $delete_satuan;
    // protected $create_group;
    // protected $read_group;
    // protected $update_group;
    // protected $delete_group;
    // protected $create_coa;
    // protected $read_coa;
    // protected $update_coa;
    // protected $delete_coa;
    // protected $create_bank;
    // protected $read_bank;
    // protected $update_bank;
    // protected $delete_bank;
    // protected $create_mtuang;
    // protected $read_mtuang;
    // protected $update_mtuang;
    // protected $delete_mtuang;
    // protected $create_cust;
    // protected $read_cust;
    // protected $update_cust;
    // protected $delete_cust;
    // protected $create_supp;
    // protected $read_supp;
    // protected $update_supp;
    // protected $delete_supp;
    // protected $create_lokasi;
    // protected $read_lokasi;
    // protected $update_lokasi;
    // protected $delete_lokasi;
    // protected $create_cabang;
    // protected $read_cabang;
    // protected $update_cabang;
    // protected $delete_cabang;
    // protected $create_belibrg;
    // protected $read_belibrg;
    // protected $update_belibrg;
    // protected $delete_belibrg;
    // protected $create_pos;
    // protected $read_pos;
    // protected $update_pos;
    // protected $delete_pos;
    // protected $create_bayarops;
    // protected $read_bayarops;
    // protected $update_bayarops;
    // protected $delete_bayarops;
    // protected $create_jvouch;
    // protected $read_jvouch;
    // protected $update_jvouch;
    // protected $delete_jvouch;
    // protected $create_penerimaan;
    // protected $read_penerimaan;
    // protected $update_penerimaan;
    // protected $delete_penerimaan;
    
    public function index(){
        return view('auth.login');
    }

    public function postLogin(Request $request){
        if(Auth::attempt($request->only('username', 'password'))){
            $request->session()->regenerate();
            $username = Auth::User()->username;
            $comp_name = Auth::User()->comp_name;
            $comp_code = Auth::User()->comp_code;
            $privilage = Auth::User()->privilage;
            $request->session()->put('comp_name', $comp_name);
            $request->session()->put('username', $username);
            $request->session()->put('comp_code', $comp_code);
            $request->session()->put('privilage', $privilage);
            
            $user = User::select('id','username','email')->where('username','=', $request->username)->first();

            $auth_mitem = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mitem')->first();

            if($auth_mitem != null){
                $request->session()->put('mitem_save', $auth_mitem->save);
                $request->session()->put('mitem_open', $auth_mitem->open);
                $request->session()->put('mitem_updt', $auth_mitem->updt);
                $request->session()->put('mitem_dlt', $auth_mitem->dlt);
            }

            $auth_muser = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'muser')->first();

            if($auth_muser != null){
                $request->session()->put('muser_save', $auth_muser->save);
                $request->session()->put('muser_open', $auth_muser->open);
                $request->session()->put('muser_updt', $auth_muser->updt);
                $request->session()->put('muser_dlt', $auth_muser->dlt);
            }            

            $auth_msatuan = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'msatuan')->first();

            if($auth_msatuan != null){
                $request->session()->put('msatuan_save', $auth_msatuan->save);
                $request->session()->put('msatuan_open', $auth_msatuan->open);
                $request->session()->put('msatuan_updt', $auth_msatuan->updt);
                $request->session()->put('msatuan_dlt', $auth_msatuan->dlt);
            }

            $auth_mdtgrp = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mdtgrp')->first();

            if($auth_mdtgrp != null){
                $request->session()->put('mdtgrp_save', $auth_mdtgrp->save);
                $request->session()->put('mdtgrp_open', $auth_mdtgrp->open);
                $request->session()->put('mdtgrp_updt', $auth_mdtgrp->updt);
                $request->session()->put('mdtgrp_dlt', $auth_mdtgrp->dlt);
            }            

            $auth_mcoa = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcoa')->first();

            if($auth_mcoa != null){
                $request->session()->put('mcoa_save', $auth_mcoa->save);
                $request->session()->put('mcoa_open', $auth_mcoa->open);
                $request->session()->put('mcoa_updt', $auth_mcoa->updt);
                $request->session()->put('mcoa_dlt', $auth_mcoa->dlt);
            }

            $auth_mbank = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mbank')->first();

            if($auth_mbank != null){
                $request->session()->put('mbank_save', $auth_mbank->save);
                $request->session()->put('mbank_open', $auth_mbank->open);
                $request->session()->put('mbank_updt', $auth_mbank->updt);
                $request->session()->put('mbank_dlt', $auth_mbank->dlt);
            }

            $auth_mmtuang = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mmtuang')->first();

            if($auth_mmtuang != null){
                $request->session()->put('mmtuang_save', $auth_mmtuang->save);
                $request->session()->put('mmtuang_open', $auth_mmtuang->open);
                $request->session()->put('mmtuang_updt', $auth_mmtuang->updt);
                $request->session()->put('mmtuang_dlt', $auth_mmtuang->dlt);
            }

            $auth_mcust = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcust')->first();

            if($auth_mcust != null){
                $request->session()->put('mcust_save', $auth_mcust->save);
                $request->session()->put('mcust_open', $auth_mcust->open);
                $request->session()->put('mcust_updt', $auth_mcust->updt);
                $request->session()->put('mcust_dlt', $auth_mcust->dlt);
            }

            $auth_msupp = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'msupp')->first();
            
            if($auth_msupp != null){
                $request->session()->put('msupp_save', $auth_msupp->save);
                $request->session()->put('msupp_open', $auth_msupp->open);
                $request->session()->put('msupp_updt', $auth_msupp->updt);
                $request->session()->put('msupp_dlt', $auth_msupp->dlt);
            }

            $auth_mlokasi = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mlokasi')->first();

            if($auth_mlokasi != null){
                $request->session()->put('mlokasi_save', $auth_mlokasi->save);
                $request->session()->put('mlokasi_open', $auth_mlokasi->open);
                $request->session()->put('mlokasi_updt', $auth_mlokasi->updt);
                $request->session()->put('mlokasi_dlt', $auth_mlokasi->dlt);
            }

            $auth_mcabang = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'mcabang')->first();

            if($auth_mcabang != null){
                $request->session()->put('mcabang_save', $auth_mcabang->save);
                $request->session()->put('mcabang_open', $auth_mcabang->open);
                $request->session()->put('mcabang_updt', $auth_mcabang->updt);
                $request->session()->put('mcabang_dlt', $auth_mcabang->dlt);
            }

            $auth_tpembelianbrg = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpembelianbrg')->first();

            if($auth_tpembelianbrg != null){
                $request->session()->put('tpembelianbrg_save', $auth_tpembelianbrg->save);
                $request->session()->put('tpembelianbrg_open', $auth_tpembelianbrg->open);
                $request->session()->put('tpembelianbrg_updt', $auth_tpembelianbrg->updt);
                $request->session()->put('tpembelianbrg_dlt', $auth_tpembelianbrg->dlt);
            }

            $auth_tpos = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpos')->first();

            if($auth_tpos != null){
                $request->session()->put('tpos_save', $auth_tpos->save);
                $request->session()->put('tpos_open', $auth_tpos->open);
                $request->session()->put('tpos_updt', $auth_tpos->updt);
                $request->session()->put('tpos_dlt', $auth_tpos->dlt);
            }

            $auth_tops = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tops')->first();

            if($auth_tops != null){
                $request->session()->put('tops_save', $auth_tops->save);
                $request->session()->put('tops_open', $auth_tops->open);
                $request->session()->put('tops_updt', $auth_tops->updt);
                $request->session()->put('tops_dlt', $auth_tops->dlt);
            }

            $auth_tjvouch = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tjvouch')->first();

            if($auth_tjvouch != null){
                $request->session()->put('tjvouch_save', $auth_tjvouch->save);
                $request->session()->put('tjvouch_open', $auth_tjvouch->open);
                $request->session()->put('tjvouch_updt', $auth_tjvouch->updt);
                $request->session()->put('tjvouch_dlt', $auth_tjvouch->dlt);
            }

            $auth_tpenerimaan = AuthUser::where('id_user', '=', $user->id)->where('feature', '=', 'tpenerimaan')->first();

            if($auth_tpenerimaan != null){
                $request->session()->put('tpenerimaan_save', $auth_tpenerimaan->save);
                $request->session()->put('tpenerimaan_open', $auth_tpenerimaan->open);
                $request->session()->put('tpenerimaan_updt', $auth_tpenerimaan->updt);
                $request->session()->put('tpenerimaan_dlt', $auth_tpenerimaan->dlt);
            }

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
