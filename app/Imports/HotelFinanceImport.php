<?php

namespace App\Imports;

use App\Models\HotelFinance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class HotelFinanceImport implements ToCollection, WithHeadingRow,  WithMultipleSheets
{
    protected $uploadId, $hotelId, $userId;

    public function sheets(): array
    {
        return [
            'DATA' => $this,
        ];
    }
    public function __construct($uploadId, $hotelId, $userId)
    {
        $this->uploadId = $uploadId;
        $this->hotelId = $hotelId;
        $this->userId = $userId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Lewati baris jika transaction_date kosong
            if (empty($row['transaction_date']))
                continue;

            // Handle tanggal
            try {
                $transactionDate = is_numeric($row['transaction_date'])
                    ? Carbon::instance(Date::excelToDateTimeObject($row['transaction_date']))->format('Y-m-d')
                    : Carbon::parse($row['transaction_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                continue; // skip baris error
            }

            // Handle waktu (jika ada)
            $transactionTime = '00:00:00';
            if (!empty($row['transaction_time'])) {
                try {
                    $transactionTime = is_numeric($row['transaction_time'])
                        ? Date::excelToDateTimeObject($row['transaction_time'])->format('H:i:s')
                        : Carbon::parse($row['transaction_time'])->format('H:i:s');
                } catch (\Exception $e) {
                    $transactionTime = '00:00:00'; // fallback
                }
            }

            HotelFinance::create([
                'hotel_id' => $this->hotelId,
                'user_id' => $this->userId,
                'hotel_upload_log_id' => $this->uploadId,
                'transaction_code' => $row['transaction_code'],
                'transaction_date' => $transactionDate,
                'transaction_time' => $transactionTime,
                'transaction_type' => $row['transaction_type'],
                'amount' => $row['amount'] ?? 0,
                'payment_method' => $row['payment_method'],
                'category' => $row['category'],
                'subcategory' => $row['subcategory'],
                'source_or_target' => $row['source_or_target'],
                'reference_number' => $row['reference_number'],
                'description' => $row['description'],
            ]);
        }
    }
}
