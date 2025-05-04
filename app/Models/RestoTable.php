<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestoTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'resto_id',
        'table_code',
        'capacity',
        'is_active',
    ];

    public function resto()
    {
        return $this->belongsTo(Resto::class);
    }
}
