<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ControllerHomeV2 extends Controller
{
    public function index()
    {
        return view('pages.homev2');
    }

    public function summary(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        // Bon Penjualan
        $penjualan = DB::table('tpenjualan_hs')
            ->whereDate('tgl', $date)
            ->selectRaw('COUNT(*) as jumlah, COALESCE(SUM(grdtotal),0) as total')
            ->first();

        // Surat Jalan
        $suratjalan = DB::table('tsj_hs')
            ->whereDate('tgl', $date)
            ->selectRaw('COUNT(*) as jumlah, COALESCE(SUM(grdtotal),0) as total')
            ->first();

        // Pembelian Barang
        $pembelian = DB::table('tpembelian_hs')
            ->whereDate('tgl', $date)
            ->selectRaw('COUNT(*) as jumlah, COALESCE(SUM(grdtotal),0) as total')
            ->first();

        // Penerimaan Barang
        $penerimaan = DB::table('tpenerimaan_hs')
            ->whereDate('tgl', $date)
            ->selectRaw('COUNT(*) as jumlah, COALESCE(SUM(grdtotal),0) as total')
            ->first();

        // Retur Penjualan
        $retur = DB::table('tretur_hs')
            ->whereDate('tgl', $date)
            ->selectRaw('COUNT(*) as jumlah')
            ->first();

        // Adjustment Stock
        $adjustment = DB::table('tadj_hs')
            ->whereDate('tgl', $date)
            ->selectRaw('COUNT(*) as jumlah')
            ->first();

        // Stock Opname
        $stockopname = DB::table('tstockopname_h')
            ->whereDate('tanggal', $date)
            ->selectRaw('COUNT(*) as jumlah')
            ->first();

        // Expense
        $expense = DB::table('texpense_hs')
            ->whereDate('tgl', $date)
            ->selectRaw('COUNT(*) as jumlah, COALESCE(SUM(total),0) as total')
            ->first();

        return response()->json([
            'date' => $date,
            'penjualan'   => ['jumlah' => $penjualan->jumlah,   'total' => $penjualan->total],
            'suratjalan'  => ['jumlah' => $suratjalan->jumlah,  'total' => $suratjalan->total],
            'pembelian'   => ['jumlah' => $pembelian->jumlah,   'total' => $pembelian->total],
            'penerimaan'  => ['jumlah' => $penerimaan->jumlah,  'total' => $penerimaan->total],
            'retur'       => ['jumlah' => $retur->jumlah],
            'adjustment'  => ['jumlah' => $adjustment->jumlah],
            'stockopname' => ['jumlah' => $stockopname->jumlah],
            'expense'     => ['jumlah' => $expense->jumlah,     'total' => $expense->total],
        ]);
    }
}
