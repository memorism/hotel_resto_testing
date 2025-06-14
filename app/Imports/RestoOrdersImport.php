<?php

namespace App\Imports;

use App\Models\RestoOrder;
use App\Models\SharedCustomer;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RestoOrdersImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    protected $uploadLogId;
    protected $restoId;
    protected $userId;

    public function sheets(): array
    {
        return [
            'DATA' => $this,
        ];
    }

    public function __construct($uploadLogId, $restoId, $userId)
    {
        $this->uploadLogId = $uploadLogId;
        $this->restoId = $restoId;
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        $customerId = null;
        if (!empty($row['customer_name'])) {
            $customer = SharedCustomer::firstOrCreate(
                ['name' => $row['customer_name']],
                ['created_by' => $this->userId] // opsional
            );
            $customerId = $customer->id;
        }

        return new RestoOrder([
            'resto_upload_log_id' => $this->uploadLogId,
            'resto_id' => $this->restoId,
            'user_id' => $this->userId,
            'customer_id' => $customerId,

            'order_date' => isset($row['order_date'])
                ? $this->parseExcelDate($row['order_date'])
                : null,

            'time_order' => isset($row['time_order'])
                ? $this->parseExcelTime($row['time_order'])
                : null,

            'item_name' => $row['item_name'] ?? null,
            'item_type' => $row['item_type'] ?? null,
            'item_price' => is_numeric($row['item_price']) ? (int) $row['item_price'] : 0,
            'quantity' => is_numeric($row['quantity']) ? (int) $row['quantity'] : 0,
            'transaction_amount' => is_numeric($row['transaction_amount']) ? (int) $row['transaction_amount'] : 0,
            'transaction_type' => $row['transaction_type'] ?? 'Cash',
            'received_by' => $customer ? ($customer->gender ?? 'Unknown') : 'Unknown',
            'type_of_order' => $row['type_of_order'] ?? 'Dine In',
            'approval_status' => 'pending',
        ]);
    }

    protected function parseExcelDate($value)
    {
        if (is_numeric($value)) {
            try {
                return Carbon::instance(Date::excelToDateTimeObject((float) $value))->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function parseExcelTime($value)
    {
        if (is_numeric($value)) {
            try {
                return Carbon::instance(Date::excelToDateTimeObject((float) $value))->format('H:i:s');
            } catch (\Exception $e) {
                return null;
            }
        }

        try {
            return Carbon::createFromFormat('H:i', $value)->format('H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
}
