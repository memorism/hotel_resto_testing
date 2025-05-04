<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestoFinance extends Model
{
    use HasFactory;
    protected $fillable = [
        'resto_id',
        'tanggal',
        'jenis',
        'keterangan',
        'nominal',
    ];

    public function resto()
    {
        return $this->belongsTo(Resto::class);
    }
}
