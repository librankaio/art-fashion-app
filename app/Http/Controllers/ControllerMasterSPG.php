<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Mhakakses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerMasterSPG extends Controller
{
    public function index()
    {
        $datas = User::select('id','nik','name','hp', 'jenis', 'counter')->get();
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Master.mdataspg',[
            'datas' => $datas,
            'counters' => $counters,
        ]);
    }
    
    public function post(Request $request){
        // dd($request->all());
        $availuser = User::where('nik', '=', $request->nik)->first();

        if($availuser != null){
            return redirect()->back()->with('error', 'NIK sudah terdaftar');
        }else{
            User::create([
                'nik' => $request->nik,
                'name' => $request->name,
                'hp' => $request->phone,
                'jenis' => $request->jenis,
                'counter' => $request->counter,
                'password' => $request->password,
            ]);
            if ($request->jenis == 'ADMIN'){
                User::where('nik', '=', $request->nik)->update([
                    'privilage' => 'ADM',
                ]);
            }else if ($request->jenis == 'SPG SR') {
                User::where('nik', '=', $request->nik)->update([
                    'privilage' => 'SPG SR',
                ]);
            }
            $user = User::select('id','nik','name')->where('nik','=',$request->nik)->first();
            DB::insert( DB::raw("insert into mhakakses (id_user, nik, counter, feature, save, open, updt, print, dlt) select '$user->id', '$request->nik', '$request->counter', code, 'Y', 'Y', 'Y', 'Y', 'Y' FROM app"));
            User::where('id', '=', $user->id)->update([
                'acs_stat' => 'Y',
            ]);
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
    }
    
    public function getedit(User $user){
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Master.mdataspgedit',[ 'user' => $user , 'counters' => $counters]);
    }
    
    public function update(User $user){
        // dd(request()->all());
        if(request('password') == null || request('password') == ''){
            User::where('id', '=', $user->id)->update([
                'nik' => request('nik'),
                'name' => request('name'),
                'hp' => request('phone'),
                'jenis' => request('jenis'),
                'counter' => request('counter'),
            ]);
            if (request('jenis') == 'ADMIN'){
                User::where('nik', '=', request('nik'))->update([
                    'privilage' => 'ADM',
                ]);
            }else if (request('jenis') == 'SPG SR') {
                User::where('nik', '=', request('nik'))->update([
                    'privilage' => 'SPG SR',
                ]);
            }
            return redirect()->route('mspg');
        }
        $password = bcrypt(request('password'));
        User::where('id', '=', $user->id)->update([
            'nik' => request('nik'),
            'name' => request('name'),
            'hp' => request('phone'),
            'jenis' => request('jenis'),
            'counter' => request('counter'),
            'password' => $password        
        ]);
        if (request('jenis') == 'ADMIN'){
            User::where('nik', '=', request('nik'))->update([
                'privilage' => 'ADM',
            ]);
        }else if (request('jenis') == 'SPG SR') {
            User::where('nik', '=', request('nik'))->update([
                'privilage' => 'SPG SR',
            ]);
        }
        return redirect()->route('mspg');
    }

    public function delete(User $user){
        User::find($user->id)->delete();
        Mhakakses::where('id_user',$user->id)->delete(); 
        return redirect()->route('mspg');
    }
}
