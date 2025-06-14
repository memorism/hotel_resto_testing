<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Hotel;
use App\Models\Resto;
use App\Models\HotelBooking;
use App\Models\RestoOrder;
use App\Models\HotelRoom;
use App\Models\CombinedReport;
use App\Models\RestoTable;
use App\Models\HotelFinance;
use App\Models\RestoFinance;
use Carbon\Carbon;

class SyncCombinedReports extends Command
{
    protected $signature = 'sync:combined-reports';
    protected $description = 'Sinkronisasi laporan gabungan hotel dan resto per bulan.';

    public function handle()
    {
        $bulan = now()->format('Y-m');
        $tanggal = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth()->toDateString();
        $this->info("🗕️ Sinkronisasi data untuk bulan: $bulan");

        // === 1. Semua Hotel ===
        foreach (Hotel::all() as $hotel) {
            $this->info("🏨 Proses hotel: {$hotel->name}");

            $bookings = HotelBooking::where('hotel_id', $hotel->id)
                ->where('approval_status', 'approved')
                ->whereRaw("DATE_FORMAT(STR_TO_DATE(CONCAT(arrival_year, '-', LPAD(arrival_month, 2, '0'), '-', LPAD(arrival_date, 2, '0')), '%Y-%m-%d'), '%Y-%m') = ?", [$bulan])
                ->get();

            $totalBooking = $bookings->count();
            $totalTamu = $bookings->sum(fn($b) => $b->no_of_adults + $b->no_of_children);
            $totalKamar = HotelRoom::where('hotel_id', $hotel->id)->count();
            $hotelIncome = $bookings->sum(fn($b) => $b->avg_price_per_room * ($b->no_of_week_nights + $b->no_of_weekend_nights));
            $hotelExpense = HotelFinance::where('hotel_id', $hotel->id)
                ->whereRaw("DATE_FORMAT(transaction_date, '%Y-%m') = ?", [$bulan])
                ->where('transaction_type', 'pengeluaran')
                ->sum('amount');

            $okupansi = $totalKamar > 0 ? min(100, round(($totalBooking / $totalKamar) * 100, 2)) : 0;

            CombinedReport::updateOrCreate([
                'tanggal' => $tanggal,
                'hotel_id' => $hotel->id,
                'resto_id' => null,
            ], [
                'total_booking' => $totalBooking,
                'total_tamu' => $totalTamu,
                'total_okupansi' => $okupansi,
                'hotel_income' => $hotelIncome,
                'hotel_expense' => $hotelExpense,
                'total_income' => $hotelIncome,
                'total_expense' => $hotelExpense,
                'net_profit' => $hotelIncome - $hotelExpense,
                'table_utilization_rate' => null,
                'created_by' => null,
            ]);
        }

        // === 2. Semua Resto ===
        foreach (Resto::all() as $resto) {
            $this->info("🍽️ Proses resto: {$resto->name}");

            $approvedOrders = RestoOrder::where('resto_id', $resto->id)
                ->where('approval_status', 'approved')
                ->whereRaw("DATE_FORMAT(order_date, '%Y-%m') = ?", [$bulan]);

            $restoIncome = $approvedOrders->sum('transaction_amount');

            $restoExpense = RestoFinance::where('resto_id', $resto->id)
                ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulan])
                ->where('jenis', 'pengeluaran')
                ->sum('nominal');

            $totalTransaksiResto = $approvedOrders->count();
            $totalMeja = RestoTable::where('resto_id', $resto->id)->count();
            $utilRate = $totalMeja > 0 ? min(100, round(($totalTransaksiResto / $totalMeja) * 100, 2)) : 0;

            $existing = CombinedReport::where('tanggal', $tanggal)->where('resto_id', $resto->id)->first();
            if ($existing) {
                $existing->update([
                    'resto_income' => $restoIncome,
                    'resto_expense' => $restoExpense,
                    'total_income' => ($existing->hotel_income ?? 0) + $restoIncome,
                    'total_expense' => ($existing->hotel_expense ?? 0) + $restoExpense,
                    'net_profit' => (($existing->hotel_income ?? 0) + $restoIncome) - (($existing->hotel_expense ?? 0) + $restoExpense),
                    'table_utilization_rate' => $utilRate,
                ]);
            } else {
                CombinedReport::updateOrCreate([
                    'tanggal' => $tanggal,
                    'hotel_id' => null,
                    'resto_id' => $resto->id,
                ], [
                    'resto_income' => $restoIncome,
                    'resto_expense' => $restoExpense,
                    'total_income' => $restoIncome,
                    'total_expense' => $restoExpense,
                    'net_profit' => $restoIncome - $restoExpense,
                    'table_utilization_rate' => $utilRate,
                    'created_by' => null,
                ]);
            }
        }

        $this->info("✅ Sinkronisasi laporan gabungan bulanan selesai!");
    }
}
