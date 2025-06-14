<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CombinedReport extends Model
{
    use HasFactory;

    protected $table = 'combined_reports';


    protected $fillable = [
        'tanggal', 'hotel_id', 'resto_id', 'total_booking', 'total_tamu', 'total_okupansi',
        'hotel_income', 'hotel_expense', 'resto_income', 'resto_expense',
        'total_income', 'total_expense', 'net_profit', 'table_utilization_rate',
        'created_by',
    ];
    
    protected $casts = [
        'tanggal' => 'date',
        'total_booking' => 'integer',
        'total_tamu' => 'integer',
        'total_okupansi' => 'float',
        'table_utilization_rate' => 'float',
        'hotel_income' => 'float',
        'hotel_expense' => 'float',
        'resto_income' => 'float',
        'resto_expense' => 'float',
        'total_income' => 'float',
        'total_expense' => 'float',
        'net_profit' => 'float',
    ];
    

    // Relasi ke Hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // Relasi ke Resto
    public function resto()
    {
        return $this->belongsTo(Resto::class);
    }
}
