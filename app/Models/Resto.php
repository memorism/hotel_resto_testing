<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resto extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'street',
        'village',
        'district',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'logo'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
