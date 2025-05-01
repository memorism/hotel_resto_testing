<?php

// app/Models/UploadOrder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelUploadLog extends Model
{
    protected $fillable = ['hotel_id', 'user_id', 'file_name', 'description'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(HotelBooking::class, 'hotel_upload_log_id');
    }

}

