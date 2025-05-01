<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelSupplyTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'supply_id',
        'user_id',
        'type',
        'quantity',
        'note',
        'transaction_date',
        'hotel_id',
        
    ];

    public function supply()
    {
        return $this->belongsTo(HotelSupply::class, 'supply_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
