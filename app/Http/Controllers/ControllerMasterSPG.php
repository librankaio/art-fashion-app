<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\User;
use Illuminate\Http\Request;

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
        return redirect()->route('mspg');
    }

    public function delete(User $user){
        User::find($user->id)->delete();
        return redirect()->route('mspg');
    }
}
