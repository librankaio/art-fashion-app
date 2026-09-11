<?php

namespace App\Imports;

use App\Services\StockCounterService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Upload stok per counter. Nilai di file Excel MENGGANTI stok yang ada.
 *
 * Versi sebelumnya memakai UPDATE polos. Kalau pasangan item x counter belum
 * punya baris, UPDATE mengembalikan 0 tanpa error dan user tetap melihat
 * "Imported Successfully" padahal tidak ada yang berubah. Sekarang barisnya
 * dibuat dulu lewat ensureRow, dan baris yang tidak bisa diproses dihitung.
 */
class MitemCountersImport implements ToCollection, WithHeadingRow
{
    public int $applied = 0;
    public int $skipped = 0;

    /** @var string[] alasan per baris yang dilewati, untuk ditampilkan ke user */
    public array $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            $lineNo = $i + 2; // +1 header, +1 karena index mulai dari 0

            $code    = StockCounterService::normalizeCode($row['code'] ?? null);
            $counter = StockCounterService::resolveCounter($row['kode_counter'] ?? null);

            if ($code === '') {
                $this->skipped++;
                $this->errors[] = "Baris $lineNo: kode item kosong.";
                continue;
            }

            if (!$counter) {
                $this->skipped++;
                $this->errors[] = "Baris $lineNo: counter '" . ($row['kode_counter'] ?? '') . "' tidak ada di master lokasi.";
                continue;
            }

            $rowModel = StockCounterService::ensureRow($code, $counter);
            $rowModel->update(['stock' => (int) $row['stock']]);

            $this->applied++;
        }
    }
}
