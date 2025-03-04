<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestoOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_date',
        'time_order',
        'item_name',
        'item_type',
        'item_price',
        'quantity',
        'transaction_amount',
        'transaction_type',
        'received_by',
        'type_of_order',
        'excel_upload_id'
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan ExcelUpload
    public function excelUpload()
    {
        return $this->belongsTo(ExcelUpload::class, 'excel_upload_id');
    }
}
