<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'upload_order_id',
        'hotel_id',
        'user_id'
    ];



    public function hotel()
    {
        return $this->belongsTo(User::class, 'hotel_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function uploadOrder()
    {
        return $this->belongsTo(UploadOrder::class, 'upload_order_id');
    }


}
