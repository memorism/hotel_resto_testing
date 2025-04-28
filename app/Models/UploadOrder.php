<?php

// app/Models/UploadOrder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_name',
        'description',
        'hotel_id',  
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(User::class, 'hotel_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'upload_order_id');
    }

}

