<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'street',
        'village',
        'district',
        'city',
        'province',
        'postal_code',
        'phone',
        'email'
    ];

    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    public function bookings()
    {
        return $this->hasMany(HotelBooking::class);
    }

    public function uploadLogs()
    {
        return $this->hasMany(HotelUploadLog::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function linkedRestos()
    {
        return $this->belongsToMany(Resto::class, 'hotel_resto_links');
    }


    public function finances()
    {
        return $this->hasMany(HotelFinance::class);
    }

}
