<?php

// app/Models/ExcelUpload.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestoUploadLog extends Model
{
    protected $fillable = ['user_id', 'file_name', 'description','resto_id','type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(RestoOrder::class, 'excel_upload_id');
    }

    public function resto()
    {
        return $this->belongsTo(Resto::class, 'resto_id');
    }

    public function finances()
    {
        return $this->hasMany(RestoFinance::class);
    }

}

