<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_type', 'description', 'total_rooms', 'price_per_room', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
