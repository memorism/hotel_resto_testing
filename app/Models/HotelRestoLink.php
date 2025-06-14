<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelRestoLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'resto_id',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function resto()
    {
        return $this->belongsTo(Resto::class);
    }
}

