<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Mengganti kode item di seluruh tabel yang menyimpan kode item.
 *
 * Harus dipanggil di dalam DB::transaction milik pemanggil, supaya rename
 * tidak berhenti setengah jalan kalau salah satu UPDATE gagal.
 */
class MitemRenameService
{
    /**
     * Tabel non-transaksi yang juga menyimpan kode item.
     * Tabel transaksi diambil dari MitemExistTransService.
     */
    private static array $otherTables = [
        'tstockopname_draft_d'  => 'kode_barang',
        'mitems_counters'       => 'code_mitem',
        'mutasiaf'              => 'code_mitem',
        'mitem_counter_uploads' => 'code_mitem',
    ];

    /**
     * @return int jumlah baris transaksi yang ikut diganti kodenya
     */
    public static function rename(string $oldKode, string $newKode): int
    {
        $oldKode = StockCounterService::normalizeCode($oldKode);
        $newKode = StockCounterService::normalizeCode($newKode);
        if ($oldKode === '' || $newKode === '' || $oldKode === $newKode) {
            return 0;
        }

        $transRows = 0;
        foreach (MitemExistTransService::transactionTables() as $table => $column) {
            $transRows += self::renameIn($table, $column, $oldKode, $newKode);
        }

        foreach (self::$otherTables as $table => $column) {
            if (Schema::hasTable($table)) {
                self::renameIn($table, $column, $oldKode, $newKode);
            }
        }

        return $transRows;
    }

    private static function renameIn(string $table, string $column, string $oldKode, string $newKode): int
    {
        $affected = DB::table($table)
            ->where($column, $oldKode)
            ->update([$column => $newKode]);

        // Data lama yang menyimpan "KODE NAMA ITEM": ganti prefiks kodenya saja.
        // SUBSTRING MySQL berbasis karakter, jadi pakai mb_strlen.
        $affected += DB::table($table)
            ->where($column, 'LIKE', MitemExistTransService::escapeLike($oldKode) . ' %')
            ->update([
                $column => DB::raw(
                    'CONCAT(' . DB::getPdo()->quote($newKode) . ', SUBSTRING(`' . $column . '`, ' . (mb_strlen($oldKode) + 1) . '))'
                ),
            ]);

        return $affected;
    }
}
