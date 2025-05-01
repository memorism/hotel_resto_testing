<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',
        'logo',
        'hotel_id',
        'resto_id',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];


    }
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function resto()
    {
        return $this->belongsTo(Resto::class);
    }

    public function hotelBookings()
    {
        return $this->hasMany(HotelBooking::class);
    }

    public function hotelUploadLogs()
    {
        return $this->hasMany(HotelUploadLog::class);
    }

    public function restoOrders()
    {
        return $this->hasMany(RestoOrder::class);
    }

    public function restoUploadLogs()
    {
        return $this->hasMany(RestoUploadLog::class);
    }

    public function hotelRooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    public function rooms()
    {
        return $this->hasMany(\App\Models\HotelRoom::class, 'hotel_id', 'hotel_id');
    }
    

}
