<?php

namespace App\Imports;

use App\Models\RestoFinance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class RestoFinancesImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    protected $restoId;
    protected $uploadLogId;

    public function sheets(): array
    {
        return [
            'DATA' => $this,
        ];
    }

    public function __construct($restoId, $uploadLogId)
    {
        $this->restoId = $restoId;
        $this->uploadLogId = $uploadLogId;
    }

    public function model(array $row)
    {
        return new RestoFinance([
            'resto_id' => $this->restoId,
            'resto_upload_log_id' => $this->uploadLogId, // <--- ini penting
            'tanggal' => $row['tanggal'] ?? now(),
            'jenis' => $row['jenis'] ?? 'pemasukan',
            'keterangan' => $row['keterangan'] ?? null,
            'nominal' => $row['nominal'] ?? 0,
            'approval_status' => 'pending',
        ]);
    }
}

