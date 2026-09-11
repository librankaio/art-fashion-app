<?php

namespace App\Imports;

use App\Models\Mitem;
use App\Models\MitemCounterUpload;
use App\Services\StockCounterService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Upload tambah stok. Qty di file Excel DITAMBAHKAN ke stok yang ada.
 *
 * Dua perubahan penting dari versi sebelumnya:
 * 1. Kode item dinormalisasi dengan aturan yang sama seperti seluruh aplikasi
 *    (trim + rapatkan spasi). Dulu memakai preg_replace('/[^A-Za-z0-9]/','')
 *    yang ikut membuang tanda hubung dan titik, sehingga kode seperti AF-001
 *    tidak pernah cocok dengan yang tersimpan di database.
 * 2. Query UPDATE polos diganti pemanggilan service, jadi baris yang belum ada
 *    dibuat dulu dan kegagalan tidak lagi tertelan diam-diam.
 */
class MitemAddStockImport implements ToCollection, WithHeadingRow
{
    public int $applied = 0;
    public int $skipped = 0;

    /** @var string[] alasan per baris yang dilewati, untuk ditampilkan ke user */
    public array $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            $lineNo = $i + 2; // +1 header, +1 karena index mulai dari 0

            $code    = StockCounterService::normalizeCode($row['code_mitem'] ?? null);
            $counter = StockCounterService::resolveCounter($row['code_mcounter'] ?? null);
            $qty     = (int) ($row['qty'] ?? 0);

            if ($code === '') {
                $this->skipped++;
                $this->errors[] = "Baris $lineNo: kode item kosong.";
                continue;
            }

            if (!$counter) {
                $this->skipped++;
                $this->errors[] = "Baris $lineNo: counter '" . ($row['code_mcounter'] ?? '') . "' tidak ada di master lokasi.";
                continue;
            }

            // Catat baris yang kodenya belum terdaftar di master item, supaya
            // ketahuan dan bisa ditindaklanjuti.
            if (!Mitem::where('code', $code)->exists()) {
                MitemCounterUpload::create([
                    'tgl'           => $this->excelDate($row['tgl'] ?? null),
                    'code_mitem'    => $code,
                    'name_mitem'    => $row['name_mitem'] ?? null,
                    'code_mcounter' => $counter->code,
                    'name_mcounter' => $counter->name,
                    'qty'           => $qty,
                ]);
            }

            StockCounterService::adjust($code, $counter, $qty, [
                'name_mitem' => $row['name_mitem'] ?? null,
                'notrans'    => 'UPLOAD-TBH-STOCK',
                'doctype'    => 'UPLOAD',
                'jenis'      => $qty >= 0 ? 'PLUS' : 'MINUS',
                'action'     => 'CREATE',
            ]);

            $this->applied++;
        }
    }

    /**
     * Tanggal Excel tersimpan sebagai angka serial, bukan string.
     */
    private function excelDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int) $value)
                ->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
