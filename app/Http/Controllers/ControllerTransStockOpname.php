<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Tstockopname_d;
use App\Models\Tstockopname_h;
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

        $notrans = DB::select("select fgetcode('tstockopname') as codetrans");

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
            $notrans = DB::select("select fgetcode('tstockopname') as codetrans");
            foreach ($notrans as $notran) {
                $no = $notran->codetrans;
            }

            $header = Tstockopname_h::create([
                'notrans' => $no,
                'tanggal' => $request->dt,
                'counter' => $request->counter,
                'note'    => $request->note,
                'status'  => 'POSTED',
            ]);

            $idh = $header->id;

            for ($i = 0; $i < count($request->kode_d); $i++) {
                Tstockopname_d::create([
                    'idh'          => $idh,
                    'no_opname'    => $no,
                    'no'           => $i + 1,
                    'kode_barang'  => $request->kode_d[$i],
                    'nama_barang'  => $request->nama_d[$i],
                    'stock'        => $request->stock_d[$i],
                    'harga'        => $request->harga_d[$i],
                    'hasil_opname' => $request->hasil_opname_d[$i],
                    'adjustment'   => $request->adjustment_d[$i],
                ]);

                // Tambahkan hasil_opname ke stock existing di mitems_counters
                DB::table('mitems_counters')
                    ->where('code_mcounters', $request->counter)
                    ->where('code_mitem', $request->kode_d[$i])
                    ->update(['stock' => DB::raw('stock + ' . (int)$request->hasil_opname_d[$i])]);
            }

            DB::commit();
            return redirect()->route('tstockopnamelist')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $err) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data! ' . $err->getMessage());
        }
    }

    public function list()
    {
        $data = Tstockopname_h::orderBy('created_at', 'desc')->get();
        return view('pages.Transaksi.tstockopnamelist', ['data' => $data]);
    }

    public function getedit(Tstockopname_h $tstockopname_h)
    {
        $privilage = session('privilage');

        if ($privilage == 'ADM') {
            $counters = Mcounter::select('id', 'code', 'name')->orderBy('name')->get();
        } else {
            $counters = Mcounter::select('id', 'code', 'name')->where('name', '=', session('counter'))->get();
        }

        $details = Tstockopname_d::where('idh', $tstockopname_h->id)->get();

        return view('pages.Transaksi.tstockopnameedit', [
            'counters' => $counters,
            'header'   => $tstockopname_h,
            'details'  => $details,
        ]);
    }

    public function update(Request $request, Tstockopname_h $tstockopname_h)
    {
        DB::beginTransaction();

        try {
            // Kurangi stock dengan hasil_opname lama (reverse)
            $oldDetails = Tstockopname_d::where('idh', $tstockopname_h->id)->get();
            foreach ($oldDetails as $old) {
                DB::table('mitems_counters')
                    ->where('code_mcounters', $tstockopname_h->counter)
                    ->where('code_mitem', $old->kode_barang)
                    ->update(['stock' => DB::raw('stock - ' . (int)$old->hasil_opname)]);
            }

            $tstockopname_h->update([
                'tanggal' => $request->dt,
                'counter' => $request->counter,
                'note'    => $request->note,
            ]);

            // Delete old details
            Tstockopname_d::where('idh', $tstockopname_h->id)->delete();

            // Re-insert details & update stock
            for ($i = 0; $i < count($request->kode_d); $i++) {
                Tstockopname_d::create([
                    'idh'          => $tstockopname_h->id,
                    'no_opname'    => $tstockopname_h->notrans,
                    'no'           => $i + 1,
                    'kode_barang'  => $request->kode_d[$i],
                    'nama_barang'  => $request->nama_d[$i],
                    'stock'        => $request->stock_d[$i],
                    'harga'        => $request->harga_d[$i],
                    'hasil_opname' => $request->hasil_opname_d[$i],
                    'adjustment'   => $request->adjustment_d[$i],
                ]);

                // Tambahkan hasil_opname baru ke stock existing
                DB::table('mitems_counters')
                    ->where('code_mcounters', $request->counter)
                    ->where('code_mitem', $request->kode_d[$i])
                    ->update(['stock' => DB::raw('stock + ' . (int)$request->hasil_opname_d[$i])]);
            }

            DB::commit();
            return redirect()->route('tstockopnamelist')->with('success', 'Data berhasil diupdate');
        } catch (\Throwable $err) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengupdate data! ' . $err->getMessage());
        }
    }

    public function delete(Tstockopname_h $tstockopname_h)
    {
        DB::beginTransaction();

        try {
            // Kurangi stock dengan hasil_opname yang pernah ditambahkan (reverse)
            $details = Tstockopname_d::where('idh', $tstockopname_h->id)->get();
            foreach ($details as $d) {
                DB::table('mitems_counters')
                    ->where('code_mcounters', $tstockopname_h->counter)
                    ->where('code_mitem', $d->kode_barang)
                    ->update(['stock' => DB::raw('stock - ' . (int)$d->hasil_opname)]);
            }

            Tstockopname_d::where('idh', $tstockopname_h->id)->delete();
            $tstockopname_h->delete();

            DB::commit();
            return redirect()->route('tstockopnamelist')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $err) {
            DB::rollBack();
            return redirect()->route('tstockopnamelist')->with('error', 'Gagal menghapus data! ' . $err->getMessage());
        }
    }
}