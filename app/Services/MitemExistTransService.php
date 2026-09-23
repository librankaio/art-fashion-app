<?php

namespace App\Services;

use App\Models\Mitem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MitemExistTransService
{
    /**
     * Map: [table => column_kode]
     * Semua tabel detail transaksi yang mereferensikan kode item
     */
    private static array $transactionTables = [
        'tsob_ds'          => 'code',
        'tpembelian_ds'    => 'code',
        'tsj_ds'           => 'code',
        'tpenerimaan_ds'   => 'code',
        'tpenjualan_ds'    => 'code',
        'tstockopname_d'   => 'kode_barang',
        'tadj_ds'          => 'code',
        'tretur_ds'        => 'code',
        'trcv_ds'          => 'code',
    ];

    private static ?array $existingTables = null;

    /**
     * Daftar tabel transaksi yang benar-benar ada di database.
     * Dipakai ulang oleh MitemRenameService supaya daftarnya tidak dobel.
     */
    public static function transactionTables(): array
    {
        if (self::$existingTables === null) {
            self::$existingTables = array_filter(
                self::$transactionTables,
                fn($column, $table) => Schema::hasTable($table),
                ARRAY_FILTER_USE_BOTH
            );
        }

        return self::$existingTables;
    }

    /**
     * Apakah kode dipakai di salah satu tabel transaksi.
     */
    public static function isUsed(string $kode): bool
    {
        $kode = StockCounterService::normalizeCode($kode);
        if ($kode === '') return false;

        foreach (self::transactionTables() as $table => $column) {
            // Cocokkan kode utuh, atau kode yang diikuti spasi karena sebagian
            // data lama menyimpan "KODE NAMA ITEM" di kolom yang sama.
            // LIKE 'kode%' polos salah: item AF1 ikut kena baris milik AF10.
            $exists = DB::table($table)
                ->where(function ($q) use ($column, $kode) {
                    $q->where($column, $kode)
                      ->orWhere($column, 'LIKE', self::escapeLike($kode) . ' %');
                })
                ->exists();

            if ($exists) {
                return true;
            }
        }

        return false;
    }

    /**
     * Recheck satu item, update exist_trans Y/N
     */
    public static function recheck(string $kode): void
    {
        $kode = StockCounterService::normalizeCode($kode);
        if ($kode === '') return;

        Mitem::where('code', $kode)
            ->update(['exist_trans' => self::isUsed($kode) ? 'Y' : 'N']);
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

    /**
     * Escape karakter wildcard LIKE supaya kode seperti "AF_1" tidak
     * ikut cocok dengan "AFX1".
     */
    public static function escapeLike(string $value): string
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $value);
    }
}
