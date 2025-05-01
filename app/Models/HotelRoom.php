<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    protected $fillable = ['user_id', 'room_type', 'description', 'total_rooms', 'price_per_room'];

    protected $casts = [
        'price_per_room' => 'decimal:2'
    ];

    protected $table = 'hotel_rooms';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    
}
