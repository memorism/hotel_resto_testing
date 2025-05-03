<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SharedCustomer extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'birth_date',
        'address',
    ];

    public function hotelBookings()
    {
        return $this->hasMany(HotelBooking::class, 'customer_id');
    }

    public function restoOrders()
    {
        return $this->hasMany(RestoOrder::class, 'customer_id');
    }

    public function hotelOrders()
    {
        return $this->hasMany(HotelBooking::class, 'customer_id');
    }

}
