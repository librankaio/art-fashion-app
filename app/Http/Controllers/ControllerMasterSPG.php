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
        User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'hp' => $request->phone,
            'jenis' => $request->jenis,
            'counter' => $request->counter,
            'password' => $request->password,
        ]);
        return redirect()->back();
    }
    
    public function getedit(User $user){
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Master.mdataspgedit',[ 'user' => $user , 'counters' => $counters]);
    }
    
    public function update(User $user){
        if($user->password == null || $user->password == ''){
            User::where('id', '=', $user->id)->update([
                'nik' => request('nik'),
                'name' => request('name'),
                'hp' => request('phone'),
                'jenis' => request('jenis'),
                'counter' => request('counter'),
            ]);
            return redirect()->route('mspg');
        }

        User::where('id', '=', $user->id)->update([
            'nik' => request('nik'),
            'name' => request('name'),
            'hp' => request('phone'),
            'jenis' => request('jenis'),
            'counter' => request('counter'),
            'password' => request('password'),         
        ]);
        return redirect()->route('mspg');
    }

    public function delete(User $user){
        User::find($user->id)->delete();
        return redirect()->route('mspg');
    }
}
