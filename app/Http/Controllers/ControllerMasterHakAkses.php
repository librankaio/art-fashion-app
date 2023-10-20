<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mhakakses;
use App\Models\User;
use Illuminate\Http\Request;

class ControllerMasterHakAkses extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        $datas = User::select('id','nik','name','counter','acs_stat')->get();
        $users = User::select('id','nik','name','counter')->get();
        $hakakses = Mhakakses::select('id','id_user','nik','counter','feature','save','open','updt','dlt','print')->get();
        return view('pages.Master.mdatahakses',[
            'datas' => $datas,
            'counters' => $counters,
            'users' => $users,
            'hakakses' => $hakakses,
        ]);
    }

    public function post(Request $request){
        $checkexist = Mhakakses::select('id','nik','counter')->where('nik','=', $request->nik)->first();
    //    dd($request->all());
        if($checkexist == null){
            $user = User::select('id','nik','counter')->where('nik','=', $request->nik)->first();
            for ($i=0; $i<sizeof($request->features); $i++){
                Mhakakses::create([
                    'id_user' => $user->id,
                    'nik' => $user->nik,
                    'counter' => $user->counter,
                    'feature' => $request->features[$i],
                ]);
            }
            User::where('nik', '=', $request->nik)->update([
                'acs_stat' => 'Y',
            ]);

            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mitem')->update([
                'save' => $request->create_mitem,
                'open' => $request->read_mitem,
                'updt' => $request->update_mitem,
                'dlt' => $request->delete_mitem,
                'print' => $request->print_mitem,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'muser')->update([
                'save' => $request->create_muser,
                'open' => $request->read_muser,
                'updt' => $request->update_muser,
                'dlt' => $request->delete_muser,
                'print' => $request->print_muser,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mwarna')->update([
                'save' => $request->create_mwarna,
                'open' => $request->read_mwarna,
                'updt' => $request->update_mwarna,
                'dlt' => $request->delete_mwarna,
                'print' => $request->print_mwarna,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mcounter')->update([
                'save' => $request->create_mcounter,
                'open' => $request->read_mcounter,
                'updt' => $request->update_mcounter,
                'dlt' => $request->delete_mcounter,
                'print' => $request->print_mcounter,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mhakses')->update([
                'save' => $request->create_mhakses,
                'open' => $request->read_mhakses,
                'updt' => $request->update_mhakses,
                'dlt' => $request->delete_mhakses,
                'print' => $request->print_mhakses,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tsob')->update([
                'save' => $request->create_tsob,
                'open' => $request->read_tsob,
                'updt' => $request->update_tsob,
                'dlt' => $request->delete_tsob,
                'print' => $request->print_tsob,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tpenerimaan')->update([
                'save' => $request->create_tpenerimaan,
                'open' => $request->read_tpenerimaan,
                'updt' => $request->update_tpenerimaan,
                'dlt' => $request->delete_tpenerimaan,
                'print' => $request->print_tpenerimaan,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tretur')->update([
                'save' => $request->create_tretur,
                'open' => $request->read_tretur,
                'updt' => $request->update_tretur,
                'dlt' => $request->delete_tretur,
                'print' => $request->print_tretur,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tbonjual')->update([
                'save' => $request->create_tbonjual,
                'open' => $request->read_tbonjual,
                'updt' => $request->update_tbonjual,
                'dlt' => $request->delete_tbonjual,
                'print' => $request->print_tbonjual,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tadjstock')->update([
                'save' => $request->create_tadjstock,
                'open' => $request->read_tadjstock,
                'updt' => $request->update_tadjstock,
                'dlt' => $request->delete_tadjstock,
                'print' => $request->print_tadjstock,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tsuratjalan')->update([
                'save' => $request->create_tsuratjalan,
                'open' => $request->read_tsuratjalan,
                'updt' => $request->update_tsuratjalan,
                'dlt' => $request->delete_tsuratjalan,
                'print' => $request->print_tsuratjalan,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tstopname')->update([
                'save' => $request->create_tstopname,
                'open' => $request->read_tstopname,
                'updt' => $request->update_tstopname,
                'dlt' => $request->delete_tstopname,
                'print' => $request->print_tstopname,
            ]);
            Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tbelibrg')->update([
                'save' => $request->create_tbelibrg,
                'open' => $request->read_tbelibrg,
                'updt' => $request->update_tbelibrg,
                'dlt' => $request->delete_tbelibrg,
                'print' => $request->print_tbelibrg,
            ]);
        }
        return redirect()->back();
    }

    public function getedit(User $user){
        
        $counters = Mcounter::select('id','code','name')->get();
        $users = User::select('id','nik','name')->get();
        $hakakses_user = Mhakakses::select('id','id_user','nik','counter')->where('id_user', '=', $user->id)->first();
        $mhakakses = Mhakakses::select('id','id_user','nik','counter','feature','save','open','updt','dlt')->where('id_user', '=', $user->id)->first();
        // dd($hakakses_user);
        $auth_mitem = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mitem')->first();
        $auth_muser = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'muser')->first();
        $auth_mwarna = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mwarna')->first();
        $auth_mcounter = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mcounter')->first();
        $auth_mhakses = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'mhakses')->first();
        $auth_tsob = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tsob')->first();
        $auth_tpenerimaan = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tpenerimaan')->first();
        $auth_tretur = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tretur')->first();
        $auth_tbonjual = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tbonjual')->first();
        $auth_tadjstock = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tadjstock')->first();
        $auth_texpense = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'texpense')->first();
        $auth_tsuratjalan = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tsuratjalan')->first();
        $auth_tstopname = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tstopname')->first();
        $auth_tbelibrg = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'tbelibrg')->first();
        $auth_romsetperitem = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'romsetperitem')->first();
        $auth_romsetpercounter = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'romsetpercounter')->first();
        $auth_rstockpercounter = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'rstockpercounter')->first();
        $auth_rmutasistock = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'rmutasistock')->first();
        $auth_rstockoverview = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'rstockoverview')->first();
        $auth_umdataitem = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'umdataitem')->first();
        $auth_umitemcounter = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'umitemcounter')->first();
        $auth_sldawaltoko = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'sldawaltoko')->first();
        $auth_rlapoutlet = Mhakakses::where('id_user', '=', $user->id)->where('feature', '=', 'rlapoutlet')->first();
        // dd($auth_mitem);
        return view('pages.Master.mdatahaksesedit',[ 
            'hakakses_user' => $hakakses_user, 
            'user' => $user, 
            'mhakakses' => $mhakakses, 
            'users' => $users, 
            'counters' => $counters,
            'auth_mitem' => $auth_mitem,
            'auth_muser' => $auth_muser,
            'auth_mwarna' => $auth_mwarna,
            'auth_mcounter' => $auth_mcounter,
            'auth_mhakses' => $auth_mhakses,
            'auth_tsob' => $auth_tsob,
            'auth_tpenerimaan' => $auth_tpenerimaan,
            'auth_tretur' => $auth_tretur,
            'auth_tbonjual' => $auth_tbonjual,
            'auth_tadjstock' => $auth_tadjstock,
            'auth_texpense' => $auth_texpense,
            'auth_tsuratjalan' => $auth_tsuratjalan,
            'auth_tstopname' => $auth_tstopname,
            'auth_tbelibrg' => $auth_tbelibrg,
            'auth_romsetperitem' => $auth_romsetperitem,
            'auth_romsetpercounter' => $auth_romsetpercounter,
            'auth_rstockpercounter' => $auth_rstockpercounter,
            'auth_rmutasistock' => $auth_rmutasistock,
            'auth_rstockoverview' => $auth_rstockoverview,
            'auth_umdataitem' => $auth_umdataitem,
            'auth_umitemcounter' => $auth_umitemcounter,
            'auth_sldawaltoko' => $auth_sldawaltoko,
            'auth_rlapoutlet' => $auth_rlapoutlet,
        ]);
    }

    public function update(User $user){
        $user_akses = Mhakakses::select('id','id_user','nik','counter')->where('id_user','=', $user->id)->first();
        // $test = Mhakakses::select('id','id_user','nik','counter','feature')->where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'mitem')->first();
        // dd(request()->all());
       
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'mitem')->update([
            'save' => request('create_mitem'),
            'open' => request('read_mitem'),
            'updt' => request('update_mitem'),
            'dlt' => request('delete_mitem'),
            'print' => request('print_mitem')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'muser')->update([
            'save' => request('create_muser'),
            'open' => request('read_muser'),
            'updt' => request('update_muser'),
            'dlt' => request('delete_muser'),
            'print' => request('print_muser')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'mwarna')->update([
            'save' => request('create_mwarna'),
            'open' => request('read_mwarna'),
            'updt' => request('update_mwarna'),
            'dlt' => request('delete_mwarna'),
            'print' => request('print_mwarna')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'mcounter')->update([
            'save' => request('create_mcounter'),
            'open' => request('read_mcounter'),
            'updt' => request('update_mcounter'),
            'dlt' => request('delete_mcounter'),
            'print' => request('print_mcounter')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'mhakses')->update([
            'save' => request('create_mhakses'),
            'open' => request('read_mhakses'),
            'updt' => request('update_mhakses'),
            'dlt' => request('delete_mhakses'),
            'print' => request('print_mhakses')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'sldawaltoko')->update([
            'save' => request('create_sldawaltoko'),
            'open' => request('read_sldawaltoko'),
            'updt' => request('update_sldawaltoko'),
            'dlt' => request('delete_sldawaltoko'),
            'print' => request('print_sldawaltoko')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'tsob')->update([
            'save' => request('create_tsob'),
            'open' => request('read_tsob'),
            'updt' => request('update_tsob'),
            'dlt' => request('delete_tsob'),
            'print' => request('print_tsob')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'tpenerimaan')->update([
            'save' => request('create_tpenerimaan'),
            'open' => request('read_tpenerimaan'),
            'updt' => request('update_tpenerimaan'),
            'dlt' => request('delete_tpenerimaan'),
            'print' => request('print_tpenerimaan')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'tretur')->update([
            'save' => request('create_tretur'),
            'open' => request('read_tretur'),
            'updt' => request('update_tretur'),
            'dlt' => request('delete_tretur'),
            'print' => request('print_tretur')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'tbonjual')->update([
            'save' => request('create_tbonjual'),
            'open' => request('read_tbonjual'),
            'updt' => request('update_tbonjual'),
            'dlt' => request('delete_tbonjual'),
            'print' => request('print_tbonjual')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'tadjstock')->update([
            'save' => request('create_tadjstock'),
            'open' => request('read_tadjstock'),
            'updt' => request('update_tadjstock'),
            'dlt' => request('delete_tadjstock'),
            'print' => request('print_tadjstock')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'texpense')->update([
            'save' => request('create_texpense'),
            'open' => request('read_texpense'),
            'updt' => request('update_texpense'),
            'dlt' => request('delete_texpense'),
            'print' => request('print_texpense')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'tsuratjalan')->update([
            'save' => request('create_tsuratjalan'),
            'open' => request('read_tsuratjalan'),
            'updt' => request('update_tsuratjalan'),
            'dlt' => request('delete_tsuratjalan'),
            'print' => request('print_tsuratjalan')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'tstopname')->update([
            'save' => request('create_tstopname'),
            'open' => request('read_tstopname'),
            'updt' => request('update_tstopname'),
            'dlt' => request('delete_tstopname'),
            'print' => request('print_tstopname')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'tbelibrg')->update([
            'save' => request('create_tbelibrg'),
            'open' => request('read_tbelibrg'),
            'updt' => request('update_tbelibrg'),
            'dlt' => request('delete_tbelibrg'),
            'print' => request('print_tbelibrg')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'romsetperitem')->update([
            'save' => request('create_romsetperitem'),
            'open' => request('read_romsetperitem'),
            'updt' => request('update_romsetperitem'),
            'dlt' => request('delete_romsetperitem'),
            'print' => request('print_romsetperitem')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'romsetpercounter')->update([
            'save' => request('create_romsetpercounter'),
            'open' => request('read_romsetpercounter'),
            'updt' => request('update_romsetpercounter'),
            'dlt' => request('delete_romsetpercounter'),
            'print' => request('print_romsetpercounter')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'rstockpercounter')->update([
            'save' => request('create_rstockpercounter'),
            'open' => request('read_rstockpercounter'),
            'updt' => request('update_rstockpercounter'),
            'dlt' => request('delete_rstockpercounter'),
            'print' => request('print_rstockpercounter')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'rmutasistock')->update([
            'save' => request('create_rmutasistock'),
            'open' => request('read_rmutasistock'),
            'updt' => request('update_rmutasistock'),
            'dlt' => request('delete_rmutasistock'),
            'print' => request('print_rmutasistock')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'rstockoverview')->update([
            'save' => request('create_rstockoverview'),
            'open' => request('read_rstockoverview'),
            'updt' => request('update_rstockoverview'),
            'dlt' => request('delete_rstockoverview'),
            'print' => request('print_rstockoverview')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'rlapoutlet')->update([
            'save' => request('create_rlapoutlet'),
            'open' => request('read_rlapoutlet'),
            'updt' => request('update_rlapoutlet'),
            'dlt' => request('delete_rlapoutlet'),
            'print' => request('print_rlapoutlet')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'umdataitem')->update([
            'save' => request('create_umdataitem'),
            'open' => request('read_umdataitem'),
            'updt' => request('update_umdataitem'),
            'dlt' => request('delete_umdataitem'),
            'print' => request('print_umdataitem')
        ]);
        Mhakakses::where('id_user', '=', $user_akses->id_user)->where('feature', '=', 'umitemcounter')->update([
            'save' => request('create_umitemcounter'),
            'open' => request('read_umitemcounter'),
            'updt' => request('update_umitemcounter'),
            'dlt' => request('delete_umitemcounter'),
            'print' => request('print_umitemcounter')
        ]);

        return redirect()->route('mhakses');
    }

    public function delete(User $user){
        Mhakakses::where('id_user',$user->id)->delete();        
        User::where('id',$user->id)->update([
            'acs_stat' => null,
        ]);
        return redirect()->route('mhakses');
    }
}
