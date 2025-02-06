<?php

// app/Imports/RestoOrdersImport.php

namespace App\Imports;

use App\Models\RestoOrder;
use App\Models\ExcelUpload;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RestoOrdersImport implements ToModel, WithHeadingRow
{
    protected $upload;

    public function __construct(ExcelUpload $upload)
    {
        $this->upload = $upload;
    }

    public function model(array $row)
    {
        return new RestoOrder([
            'user_id' => $this->upload->user_id,
            'excel_upload_id' => $this->upload->id,
            'order_date' => $row['order_date'],
            'time_order' => $row['time_order'],
            'item_name' => $row['item_name'],
            'item_type' => $row['item_type'],
            'item_price' => $row['item_price'],
            'quantity' => $row['quantity'],
            'transaction_amount' => $row['transaction_amount'],
            'transaction_type' => $row['transaction_type'],
            'received_by' => $row['received_by'],
            'type_of_order' => $row['type_of_order'],
        ]);
    }
}

