<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HotelBooking;
use App\Models\HotelFinance;
use App\Models\RestoOrder;
use App\Models\RestoFinance;
use Carbon\Carbon;

class SyncDailyIncomeToFinances extends Command
{
    protected $signature = 'sync:income-finances';
    protected $description = 'Sinkronisasi otomatis pendapatan harian hotel dan resto ke tabel finances';

    public function handle()
    {
        $today = now()->toDateString(); // yyyy-mm-dd

        // ===================== HOTEL =====================
        $hotelBookings = HotelBooking::whereRaw("
            STR_TO_DATE(CONCAT(arrival_year, '-', LPAD(arrival_month, 2, '0'), '-', LPAD(arrival_date, 2, '0')), '%Y-%m-%d') = ?
        ", [$today])->get();

        foreach ($hotelBookings as $booking) {
            $total = $booking->avg_price_per_room * ($booking->no_of_week_nights + $booking->no_of_weekend_nights);

            HotelFinance::firstOrCreate([
                'hotel_id'         => $booking->hotel_id,
                'transaction_date' => $today,
                'transaction_type' => 'income',
                'amount'           => $total,
                'category'         => 'booking',
                'description'      => 'Pendapatan Booking Hotel',
                'payment_method' => 'System',
            ]);
        }

        // ===================== RESTO =====================
        $restoOrders = RestoOrder::whereDate('order_date', $today)->get();

        foreach ($restoOrders as $order) {
            RestoFinance::firstOrCreate([
                'resto_id'         => $order->resto_id,
                'tanggal'          => $today, // Pastikan `tanggal` memang ada di `resto_finances`
                'jenis'            => 'pemasukan',
                'nominal'          => $order->transaction_amount,
                'keterangan'       => 'Pendapatan Order Resto',
            ]);
        }

        $this->info('Pendapatan hotel & resto berhasil disinkronisasi berdasarkan tanggal transaksi.');
    }
}
