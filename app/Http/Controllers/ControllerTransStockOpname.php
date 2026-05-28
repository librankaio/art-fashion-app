<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use App\Models\Tstockopname_d;
use App\Models\Tstockopname_h;
use App\Services\MitemExistTransService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    public function postDraft(Request $request)
    {
        DB::beginTransaction();

        try {
            $notrans = DB::select("select fgetcode('tstockopname') as codetrans");
            foreach ($notrans as $notran) {
                $no = $notran->codetrans;
            }

            $header = Tstockopname_h::create([
                'no'      => $no,
                'tanggal' => $request->dt,
                'counter' => $request->counter,
                'note'    => $request->note,
                'status'  => 'DRAFT',
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
                // Insert item into existing in transaction
                \App\Models\Mitem::where('code', '=', $request->kode_d[$i])->update([
                    'exist_trans' => "Y",
                ]);
            }

            DB::commit();
            return redirect()->route('tstockopnamelist')->with('success', 'Data berhasil disimpan sebagai Draft');
        } catch (\Throwable $err) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan draft! ' . $err->getMessage());
        }
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
                'no' => $no,
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

                // Insert item into existing in transaction
                \App\Models\Mitem::where('code', '=', $request->kode_d[$i])->update([
                    'exist_trans' => "Y",
                ]);
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

    public function printView(Tstockopname_h $tstockopname_h)
    {
        $details = Tstockopname_d::where('idh', $tstockopname_h->id)->get();
        return view('pages.Print.tstockopnameprint', [
            'header'  => $tstockopname_h,
            'details' => $details,
        ]);
    }

    public function printPdf(Tstockopname_h $tstockopname_h)
    {
        $details = Tstockopname_d::where('idh', $tstockopname_h->id)->get();
        $pdf = Pdf::loadView('pages.Print.tstockopnameprintpdf', [
            'header'  => $tstockopname_h,
            'details' => $details,
        ])->setPaper('a4', 'portrait');
        return $pdf->stream('stockopname-' . $tstockopname_h->no . '.pdf');
    }

    public function exportExcel(Tstockopname_h $tstockopname_h)
    {
        $details = Tstockopname_d::where('idh', $tstockopname_h->id)->get();

        $counter_name = Mcounter::where('code', $tstockopname_h->counter)->first();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Stock Opname');

        // Info header transaksi
        $sheet->setCellValue('A1', 'No Trans');
        $sheet->setCellValue('B1', $tstockopname_h->no);
        $sheet->setCellValue('A2', 'Tanggal');
        $sheet->setCellValue('B2', $tstockopname_h->tanggal ? date('Y-m-d', strtotime($tstockopname_h->tanggal)) : '');
        $sheet->setCellValue('A3', 'Counter');
        $sheet->setCellValue('B3', $counter_name->name);
        // $sheet->setCellValue('A4', 'Status');
        // $sheet->setCellValue('B4', $tstockopname_h->status ?? '-');
        $sheet->setCellValue('A4', 'Catatan');
        $sheet->setCellValue('B4', $tstockopname_h->note ? $tstockopname_h->note : '-');

        $sheet->getStyle('A1:A5')->applyFromArray(['font' => ['bold' => true]]);

        // Header tabel detail
        $headerRow = 5;
        $sheet->setCellValue('A' . $headerRow, 'No');
        $sheet->setCellValue('B' . $headerRow, 'Kode Barang');
        $sheet->setCellValue('C' . $headerRow, 'Nama Barang');
        $sheet->setCellValue('D' . $headerRow, 'Stock Sistem');
        $sheet->setCellValue('E' . $headerRow, 'Harga');
        $sheet->setCellValue('F' . $headerRow, 'Hasil Opname');
        $sheet->setCellValue('G' . $headerRow, 'Adjustment');

        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD9EAD3']],
        ];
        $sheet->getStyle('A' . $headerRow . ':G' . $headerRow)->applyFromArray($headerStyle);

        $no = 1;
        $row = $headerRow + 1;
        foreach ($details as $d) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $d->kode_barang);
            $sheet->setCellValue('C' . $row, $d->nama_barang);
            $sheet->setCellValue('D' . $row, $d->stock);
            // $sheet->setCellValue('E' . $row, $d->harga);
            $sheet->setCellValue('E' . $row, number_format($d->harga, 2, '.', ','));
            $sheet->setCellValue('F' . $row, $d->hasil_opname);
            $sheet->setCellValue('G' . $row, $d->adjustment);
            $row++;
        }

        // Total row
        $sheet->setCellValue('A' . $row, '');
        $sheet->setCellValue('B' . $row, '');
        $sheet->setCellValue('C' . $row, 'TOTAL');
        $sheet->setCellValue('D' . $row, $details->sum('stock'));
        $sheet->setCellValue('E' . $row, '');
        $sheet->setCellValue('F' . $row, $details->sum('hasil_opname'));
        $sheet->setCellValue('G' . $row, $details->sum('adjustment'));
        $sheet->getStyle('C' . $row . ':G' . $row)->applyFromArray(['font' => ['bold' => true]]);

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'stock_opname_' . $tstockopname_h->no . '_' . date('Ymd_His') . '.xlsx';

        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }

    // public function exportExcelAll()
    // {
    //     $data = Tstockopname_h::orderBy('created_at', 'desc')->get();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setTitle('Stock Opname');

    //     $sheet->setCellValue('A1', 'No');
    //     $sheet->setCellValue('B1', 'No Trans');
    //     $sheet->setCellValue('C1', 'Tanggal');
    //     $sheet->setCellValue('D1', 'Counter');
    //     $sheet->setCellValue('E1', 'Catatan');
    //     $sheet->setCellValue('F1', 'Status');

    //     $sheet->getStyle('A1:F1')->applyFromArray([
    //         'font' => ['bold' => true],
    //         'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD9EAD3']],
    //     ]);

    //     $no = 1;
    //     $row = 2;
    //     foreach ($data as $item) {
    //         $sheet->setCellValue('A' . $row, $no++);
    //         $sheet->setCellValue('B' . $row, $item->no);
    //         $sheet->setCellValue('C' . $row, $item->tanggal ? date('Y-m-d', strtotime($item->tanggal)) : '');
    //         $sheet->setCellValue('D' . $row, $item->counter);
    //         $sheet->setCellValue('E' . $row, $item->note);
    //         $sheet->setCellValue('F' . $row, $item->status ?? '-');
    //         $row++;
    //     }

    //     foreach (range('A', 'F') as $col) {
    //         $sheet->getColumnDimension($col)->setAutoSize(true);
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'stock_opname_all_' . date('Ymd_His') . '.xlsx';

    //     return response()->stream(function () use ($writer) {
    //         $writer->save('php://output');
    //     }, 200, [
    //         'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    //         'Cache-Control'       => 'max-age=0',
    //     ]);
    // }

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

    public function updateDraft(Request $request, Tstockopname_h $tstockopname_h)
    {
        DB::beginTransaction();

        try {
            // If previously POSTED, reverse the stock adjustments first
            if ($tstockopname_h->status === 'POSTED') {
                $oldDetails = Tstockopname_d::where('idh', $tstockopname_h->id)->get();
                foreach ($oldDetails as $old) {
                    DB::table('mitems_counters')
                        ->where('code_mcounters', $tstockopname_h->counter)
                        ->where('code_mitem', $old->kode_barang)
                        ->update(['stock' => DB::raw('stock - ' . (int)$old->hasil_opname)]);
                }
            }

            $tstockopname_h->update([
                'tanggal' => $request->dt,
                'counter' => $request->counter,
                'note'    => $request->note,
                'status'  => 'DRAFT',
            ]);

            Tstockopname_d::where('idh', $tstockopname_h->id)->delete();

            for ($i = 0; $i < count($request->kode_d); $i++) {
                Tstockopname_d::create([
                    'idh'          => $tstockopname_h->id,
                    'no_opname'    => $tstockopname_h->no,
                    'no'           => $i + 1,
                    'kode_barang'  => $request->kode_d[$i],
                    'nama_barang'  => $request->nama_d[$i],
                    'stock'        => $request->stock_d[$i],
                    'harga'        => $request->harga_d[$i],
                    'hasil_opname' => $request->hasil_opname_d[$i],
                    'adjustment'   => $request->adjustment_d[$i],
                ]);
            }

            DB::commit();
            return redirect()->route('tstockopnamelist')->with('success', 'Data berhasil disimpan sebagai Draft');
        } catch (\Throwable $err) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan draft! ' . $err->getMessage());
        }
    }

    public function update(Request $request, Tstockopname_h $tstockopname_h)
    {
        DB::beginTransaction();

        try {
            // If previously POSTED, reverse old stock. If DRAFT, no reversal needed.
            if ($tstockopname_h->status === 'POSTED') {
                $oldDetails = Tstockopname_d::where('idh', $tstockopname_h->id)->get();
                foreach ($oldDetails as $old) {
                    DB::table('mitems_counters')
                        ->where('code_mcounters', $tstockopname_h->counter)
                        ->where('code_mitem', $old->kode_barang)
                        ->update(['stock' => DB::raw('stock - ' . (int)$old->hasil_opname)]);
                }
            }

            $tstockopname_h->update([
                'tanggal' => $request->dt,
                'counter' => $request->counter,
                'note'    => $request->note,
                'status'  => 'POSTED',
            ]);

            // Delete old details
            Tstockopname_d::where('idh', $tstockopname_h->id)->delete();

            // Re-insert details & update stock
            for ($i = 0; $i < count($request->kode_d); $i++) {
                Tstockopname_d::create([
                    'idh'          => $tstockopname_h->id,
                    'no_opname'    => $tstockopname_h->no,
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
            $details = Tstockopname_d::where('idh', $tstockopname_h->id)->get();
            // Kumpulkan semua kode SEBELUM delete
            $affected_kodes = $details->pluck('kode_barang')->toArray();

            // Kurangi stock hanya jika status POSTED
            if ($tstockopname_h->status === 'POSTED') {
                foreach ($details as $d) {
                    DB::table('mitems_counters')
                        ->where('code_mcounters', $tstockopname_h->counter)
                        ->where('code_mitem', $d->kode_barang)
                        ->update(['stock' => DB::raw('stock - ' . (int)$d->hasil_opname)]);
                }
            }

            Tstockopname_d::where('idh', $tstockopname_h->id)->delete();
            $tstockopname_h->delete();

            // Recheck exist_trans untuk semua item yang terdampak
            MitemExistTransService::recheckMany($affected_kodes);

            DB::commit();
            return redirect()->route('tstockopnamelist')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $err) {
            DB::rollBack();
            return redirect()->route('tstockopnamelist')->with('error', 'Gagal menghapus data! ' . $err->getMessage());
        }
    }
}