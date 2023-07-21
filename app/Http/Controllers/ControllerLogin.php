<?php

namespace App\Http\Controllers;


use App\Models\Mhakakses;
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
    
    public function index(){
        return view('auth.login');
    }

    public function postLogin(Request $request){
        // dd(request()->all());
        if(Auth::attempt($request->only('nik', 'password'))){
            $request->session()->regenerate();
            $nik = Auth::User()->nik;
            $privilage = Auth::User()->privilage;
            $request->session()->put('nik', $nik);
            $request->session()->put('privilage', $privilage);
            
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
