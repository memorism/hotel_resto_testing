<?php

// app/Models/ExcelUpload.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelUpload extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'file_name', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function restoOrders()
    {
        return $this->hasMany(RestoOrder::class, 'excel_upload_id');
    }
}

