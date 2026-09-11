<?php

namespace App\Services;

use App\Models\Mcounter;
use App\Models\Mitem;
use App\Models\MitemCounters;
use App\Models\MutasiAF;
use Illuminate\Support\Facades\DB;

/**
 * Satu-satunya pintu untuk membaca dan mengubah stok per counter.
 *
 * Dibuat untuk menutup penyebab error "Attempt to read property stock on null":
 * setiap controller dulu punya aturan normalisasi kode dan kunci counter
 * sendiri-sendiri, sehingga baris yang ada di mitems_counters tetap tidak
 * ketemu saat di-WHERE. Semua pencarian di sini memakai code_mcounters,
 * bukan name_mcounters, karena kode counter stabil sedangkan namanya bisa
 * diubah kapan saja lewat Master Data Lokasi.
 */
class StockCounterService
{
    /**
     * Aturan tunggal normalisasi kode item untuk seluruh aplikasi.
     *
     * Trim lalu rapatkan spasi ganda. Spasi di tengah kode DIPERTAHANKAN,
     * berbeda dengan strtok($code, " ") yang memotong di spasi pertama dan
     * dengan preg_replace di Imports yang menghapus semua spasi.
     */
    public static function normalizeCode(?string $raw): string
    {
        return trim(preg_replace('/\s+/u', ' ', (string) $raw));
    }

    /**
     * Cari counter dari nama ATAU kode. Mengembalikan null kalau tidak ketemu,
     * supaya pemanggil bisa memberi pesan yang jelas alih-alih fatal error.
     */
    public static function resolveCounter(?string $nameOrCode): ?Mcounter
    {
        $key = self::normalizeCode($nameOrCode);
        if ($key === '') {
            return null;
        }

        // Cocokkan persis dulu: ini perilaku yang sudah dipakai controller lama.
        $counter = Mcounter::where('name', $key)->first();
        if ($counter) {
            return $counter;
        }

        $counter = Mcounter::where('code', $key)->first();
        if ($counter) {
            return $counter;
        }

        // Fallback: nama di master masih menyimpan spasi berlebih.
        return Mcounter::whereRaw('TRIM(name) = ?', [$key])->first();
    }

    /**
     * Pastikan baris mitems_counters untuk pasangan item x counter ini ada.
     *
     * Baris baru selalu dibuat dengan stok 0. Menggantikan auto-heal ad-hoc
     * yang dulu memakai stok 10 hardcoded di Bon Penjualan, dan stok negatif
     * di jalur update-nya.
     */
    public static function ensureRow(string $code, Mcounter $counter, ?string $itemName = null): MitemCounters
    {
        $code = self::normalizeCode($code);

        $row = MitemCounters::where('code_mitem', $code)
            ->where('code_mcounters', $counter->code)
            ->first();

        if ($row) {
            return $row;
        }

        if (empty($itemName)) {
            $itemName = optional(Mitem::where('code', $code)->first())->name;
        }

        date_default_timezone_set('Asia/Jakarta');

        return MitemCounters::create([
            'code_mitem'     => $code,
            'name_mitem'     => $itemName,
            'code_mcounters' => $counter->code,
            'name_mcounters' => $counter->name,
            'stock'          => 0,
            // Kolomnya bertipe timestamp. Format lama 'd-m-Y H:i:s' tidak valid
            // untuk MySQL dan diam-diam tersimpan sebagai nol.
            'datein'         => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Stok saat ini untuk pasangan item x counter. 0 kalau barisnya belum ada.
     * Dipakai untuk pengecekan kecukupan stok, bukan untuk menghitung nilai baru.
     */
    public static function currentStock(string $code, Mcounter $counter): int
    {
        $code = self::normalizeCode($code);

        return (int) (MitemCounters::where('code_mitem', $code)
            ->where('code_mcounters', $counter->code)
            ->value('stock') ?? 0);
    }

    /**
     * Ubah stok counter dan catat mutasinya.
     *
     * $delta positif menambah, negatif mengurangi. Perubahan dilakukan lewat
     * SQL "stock = stock + ?" sehingga aman dari race condition, menggantikan
     * pola baca-lalu-tulis yang dipakai semua controller lama.
     *
     * $mutasi mengisi baris MutasiAF. Kosongkan kalau tidak perlu dicatat.
     * Kunci yang dipakai: notrans, doctype, jenis, action, name_mitem, user.
     */
    public static function adjust(string $code, Mcounter $counter, int $delta, array $mutasi = []): void
    {
        $code = self::normalizeCode($code);

        self::ensureRow($code, $counter, $mutasi['name_mitem'] ?? null);

        MitemCounters::where('code_mitem', $code)
            ->where('code_mcounters', $counter->code)
            ->update(['stock' => DB::raw('stock + ' . (int) $delta)]);

        if ($delta !== 0 && !empty($mutasi)) {
            self::logMutasi($code, $counter, $delta, $mutasi);
        }
    }

    /**
     * Tulis satu baris riwayat mutasi. Arah PLUS/MINUS diturunkan dari $delta
     * kecuali pemanggil menentukan sendiri lewat $mutasi['jenis'].
     */
    private static function logMutasi(string $code, Mcounter $counter, int $delta, array $mutasi): void
    {
        MutasiAF::create([
            'code_mitem'     => $code,
            'code_mcounters' => $counter->code,
            'qty'            => abs($delta),
            'notrans'        => $mutasi['notrans'] ?? null,
            'doctype'        => $mutasi['doctype'] ?? null,
            'jenis'          => $mutasi['jenis'] ?? ($delta > 0 ? 'PLUS' : 'MINUS'),
            'action'         => $mutasi['action'] ?? null,
            'user'           => $mutasi['user'] ?? session('nik'),
        ]);
    }
}
