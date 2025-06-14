<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestoSupply extends Model
{
    use HasFactory;

    protected $table = 'resto_supplies';

    protected $fillable = [
        'nama_barang',
        'kategori',
        'stok',
        'satuan',
        'resto_id',
        'created_by',
    ];

    // (Opsional) Relasi ke user
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // (Opsional) Relasi ke resto
    public function resto()
    {
        return $this->belongsTo(Resto::class, 'resto_id');
    }

    public function transactions()
    {
        return $this->hasMany(RestoSupplyTransaction::class, 'resto_supply_id');
    }

}
