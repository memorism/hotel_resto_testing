<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestoOrder extends Model
{
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
        'resto_upload_log_id',
        'resto_id',
        'customer_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uploadLog()
    {
        return $this->belongsTo(RestoUploadLog::class, 'excel_upload_id');
    }

    public function resto()
    {
        return $this->belongsTo(Resto::class, 'resto_id');
    }
    public function customer()
    {
        return $this->belongsTo(SharedCustomer::class, 'customer_id');
    }

}
