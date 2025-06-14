<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestoFinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'resto_id',
        'resto_upload_log_id',
        'tanggal',
        'jenis',
        'keterangan',
        'nominal',
        'approval_status',
        'approved_by',
        'approved_at',
        'rejection_note'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
        'approved_at' => 'datetime'
    ];

    public function resto()
    {
        return $this->belongsTo(Resto::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function uploadLog()
    {
        return $this->belongsTo(RestoUploadLog::class, 'resto_upload_log_id');
    }
}
