<?php

namespace App\Imports;

use App\Models\RestoOrder;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RestoOrdersImport implements ToModel, WithHeadingRow
{
    protected $uploadLogId;
    protected $restoId;
    protected $userId;

    public function __construct($uploadLogId, $restoId, $userId)
    {
        $this->uploadLogId = $uploadLogId;
        $this->restoId = $restoId;
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        return new RestoOrder([
            'resto_upload_log_id' => $this->uploadLogId,
            'resto_id' => $this->restoId,
            'user_id' => $this->userId,
            'order_date' => isset($row['order_date']) ? Carbon::instance(Date::excelToDateTimeObject($row['order_date']))->format('Y-m-d') : null,
            'time_order' => isset($row['time_order']) ? Carbon::instance(Date::excelToDateTimeObject($row['time_order']))->format('H:i:s') : null,
            'item_name' => $row['item_name'] ?? null,
            'item_type' => $row['item_type'] ?? null,
            'item_price' => $row['item_price'] ?? null,
            'quantity' => $row['quantity'] ?? null,
            'transaction_amount' => $row['transaction_amount'] ?? null,
            'transaction_type' => $row['transaction_type'] ?? null,
            'received_by' => $row['received_by'] ?? null,
            'type_of_order' => $row['type_of_order'] ?? null,
        ]);
    }
}
