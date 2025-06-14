<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelSupply extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'user_id',
        'name',
        'unit',
        'quantity',
        'category'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(HotelSupplyTransaction::class, 'supply_id');
    }


}
