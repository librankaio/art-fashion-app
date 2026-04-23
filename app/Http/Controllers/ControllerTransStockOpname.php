<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\MitemCounters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTransStockOpname extends Controller
{
    public function index()
    {
        $privilage = session('privilage');

        if ($privilage == 'ADM') {
            $counters = Mcounter::select('id', 'code', 'name')->orderBy('name')->get();
        } else {
            $counters = Mcounter::select('id', 'code', 'name')->where('name', '=', session('counter'))->get();
        }

        $notrans = DB::select("select fgetcode('topname') as codetrans");

        return view('pages.Transaksi.tstockopname', [
            'counters' => $counters,
            'notrans'  => $notrans,
        ]);
    }

    public function getItemsByCounter(Request $request)
    {
        $code_counter = $request->code_counter;
        $search = $request->search;

        $query = DB::table('mitems_counters as mc')
            ->leftJoin('mitems as mi', 'mi.code', '=', 'mc.code_mitem')
            ->select(
                'mc.code_mitem as id',
                DB::raw("CONCAT(mc.code_mitem, ' - ', mc.name_mitem) as text"),
                'mc.code_mitem',
                'mc.name_mitem',
                'mc.stock',
                DB::raw('COALESCE(mi.hrgjual, 0) as harga')
            )
            ->where('mc.code_mcounters', '=', $code_counter);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('mc.code_mitem', 'like', "%{$search}%")
                  ->orWhere('mc.name_mitem', 'like', "%{$search}%");
            });
        }

        $items = $query->limit(10)->get();

        return response()->json($items);
    }

    public function post(Request $request)
    {
        DB::beginTransaction();

        try {
            $notrans = DB::select("select fgetcode('topname') as codetrans");
            foreach ($notrans as $notran) {
                $no = $notran->codetrans;
            }

            // Insert header
            DB::table('tstockopname_hs')->insert([
                'no'      => $no,
                'tgl'     => $request->dt,
                'counter' => $request->counter,
                'note'    => $request->note,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $idh = DB::getPdo()->lastInsertId();

            for ($i = 0; $i < count($request->kode_d); $i++) {
                DB::table('tstockopname_ds')->insert([
                    'idh'          => $idh,
                    'no_opname'    => $no,
                    'code'         => $request->kode_d[$i],
                    'name'         => $request->nama_d[$i],
                    'stock'        => $request->stock_d[$i],
                    'harga'        => $request->harga_d[$i],
                    'hasil_opname' => $request->hasil_opname_d[$i],
                    'adjustment'   => $request->adjustment_d[$i],
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $err) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data! ' . $err->getMessage());
        }
    }
}