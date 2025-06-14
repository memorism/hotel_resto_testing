<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestoSupplyTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'resto_supply_id',
        'tanggal',
        'jenis_transaksi',
        'jumlah',
        'keterangan',
        'resto_id',
        'created_by',
    ];

    public function supply()
    {
        return $this->belongsTo(RestoSupply::class, 'resto_supply_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function resto()
    {
        return $this->belongsTo(Resto::class, 'resto_id');
    }
}
