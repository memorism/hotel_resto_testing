<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelFinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'user_id',
        'transaction_code',
        'transaction_date',
        'transaction_time',
        'transaction_type',
        'amount',
        'payment_method',
        'category',
        'subcategory',
        'source_or_target',
        'reference_number',
        'description',
        'hotel_upload_log_id',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
