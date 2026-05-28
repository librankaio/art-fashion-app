<?php

namespace App\Services;

use App\Models\Mitem;
use Illuminate\Support\Facades\DB;

class MitemExistTransService
{
    /**
     * Map: [table => column_kode]
     * Semua tabel detail transaksi yang mereferensikan kode item
     */
    private static array $transactionTables = [
        'tsob_ds'          => 'code',
        'tsj_ds'           => 'code',
        'tpenerimaan_ds'   => 'code',
        'tpenjualan_ds'    => 'code',
        'tstockopname_d'   => 'kode_barang',
        'tadj_ds'          => 'code',
        'tretur_ds'        => 'code',
    ];

    /**
     * Recheck satu item, update exist_trans Y/N
     */
    public static function recheck(string $kode): void
    {
        if (empty(trim($kode))) return;

        // Bersihkan suffix spasi jika kode disimpan dengan trailing text
        $kode = strtok(trim($kode), " ");

        $existsInAny = false;
        foreach (self::$transactionTables as $table => $column) {
            if (DB::table($table)->where($column, 'LIKE', $kode . '%')->exists()) {
                $existsInAny = true;
                break;
            }
        }

        Mitem::where('code', $kode)
            ->update(['exist_trans' => $existsInAny ? 'Y' : 'N']);
    }

    /**
     * Recheck banyak item sekaligus (gunakan saat delete header)
     */
    public static function recheckMany(array $kodes): void
    {
        foreach (array_unique(array_filter($kodes)) as $kode) {
            self::recheck($kode);
        }
    }

    /**
     * Recheck semua item (untuk Artisan fix data lama)
     */
    public static function recheckAll(): void
    {
        Mitem::pluck('code')->each(fn($kode) => self::recheck($kode));
    }
}
