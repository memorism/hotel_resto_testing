<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBooking extends Model
{
    protected $fillable = [
        'hotel_id',
        'user_id',
        'booking_id',
        'no_of_adults',
        'no_of_children',
        'no_of_weekend_nights',
        'no_of_week_nights',
        'type_of_meal_plan',
        'required_car_parking_space',
        'room_type_reserved',
        'lead_time',
        'arrival_year',
        'arrival_month',
        'arrival_date',
        'market_segment_type',
        'avg_price_per_room',
        'no_of_special_requests',
        'booking_status',
        'hotel_upload_log_id',
        'customer_id',
    ];

    protected $casts = [
        'avg_price_per_room' => 'float'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uploadLog()
    {
        return $this->belongsTo(HotelUploadLog::class, 'hotel_upload_log_id');
    }

    public function customer()
    {
        return $this->belongsTo(SharedCustomer::class, 'customer_id');
    }


}
