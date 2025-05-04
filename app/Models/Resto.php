<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resto extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'logo',
        'street',
        'village',
        'district',
        'city',
        'province',
        'postal_code'
    ];

    public function orders()
    {
        return $this->hasMany(RestoOrder::class);
    }

    public function uploadLogs()
    {
        return $this->hasMany(RestoUploadLog::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function linkedHotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_resto_links');
    }

    public function tables()
    {
        return $this->hasMany(RestoTable::class);
    }

}
