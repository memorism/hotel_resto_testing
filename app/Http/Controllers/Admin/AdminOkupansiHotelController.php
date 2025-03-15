<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
class AdminOkupansiHotelController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $hotelId = $request->input('hotel_id'); // 🔹 Filter berdasarkan user hotel
    
        // 🔹 Ubah format tanggal filter ke bentuk year-month-day
        $startDateFormatted = $startDate ? date('Y-m-d', strtotime($startDate)) : null;
        $endDateFormatted = $endDate ? date('Y-m-d', strtotime($endDate)) : null;
    
        // 🔹 Mulai query dengan filter
        $query = Booking::query();
    
        // 🔹 Filter berdasarkan tanggal dengan format dari `arrival_year`, `arrival_month`, `arrival_date`
        if ($startDateFormatted && $endDateFormatted) {
            $query->whereRaw("STR_TO_DATE(CONCAT(arrival_year, '-', arrival_month, '-', arrival_date), '%Y-%m-%d') BETWEEN ? AND ?", [$startDateFormatted, $endDateFormatted]);
        }
    
        if ($hotelId) { // 🔹 Jika admin memilih hotel tertentu, hanya ambil data dari hotel itu
            $query->where('user_id', $hotelId);
        }
    
        $bookings = $query->get();
    
        // 🔹 Key Metrics
        $totalReservations = $bookings->count();
        $averageStay = $bookings->avg(fn($booking) => $booking->no_of_weekend_nights + $booking->no_of_week_nights);
        $occupancyRate = ($totalReservations > 0) ? ($totalReservations / 100) * 100 : 0;
        $cancellationRate = ($totalReservations > 0) ? ($bookings->where('booking_status', 'Canceled')->count() / $totalReservations) * 100 : 0;
    
        // 🔹 Okupansi Berdasarkan Hari Kedatangan
        $weekdayOccupancy = $bookings->groupBy('arrival_date')->map(fn($row) => count($row))->toArray();
    
        // 🔹 Rata-rata Lama Menginap per Bulan
        $bookings->each(function ($booking) {
            $booking->total_nights = $booking->no_of_weekend_nights + $booking->no_of_week_nights;
        });
        $avgStayPerMonth = $bookings->groupBy('arrival_month')->map(fn($row) => $row->avg('total_nights'))->toArray();
        ksort($avgStayPerMonth);
    
        // 🔹 Okupansi Berdasarkan Segmentasi Pasar
        $topMarketSegments = $bookings->groupBy('market_segment_type')->map(fn($row) => count($row))->sortDesc()->take(5)->toArray();
    
        // 🔹 Rasio Pembatalan per Bulan
        $cancellationRatio = $bookings->groupBy('arrival_month')->map(fn($row) => count($row) > 0 ? $row->where('booking_status', 'Canceled')->count() / count($row) : 0)->toArray();
        ksort($cancellationRatio);
    
        // 🔹 Okupansi Berdasarkan Tipe Kamar
        $roomTypeDistribution = $bookings->where('booking_status', 'Not_Canceled')
            ->groupBy('room_type_reserved')
            ->map(fn($row) => count($row))
            ->sortDesc()
            ->toArray();
    
        // 🔹 Okupansi per Bulan
        $monthlyOccupancy = $bookings->where('booking_status', 'Not_Canceled')
            ->groupBy('arrival_month')
            ->map(fn($row) => count($row))
            ->toArray();
        ksort($monthlyOccupancy);
    
        // 🔹 Persentase Okupansi per Bulan
        $occupancyRatePerMonth = $bookings->groupBy('arrival_month')->map(function ($rows) {
            $total = count($rows);
            $notCanceled = $rows->where('booking_status', 'Not_Canceled')->count();
            return $total > 0 ? ($notCanceled / $total) * 100 : 0;
        })->toArray();
        ksort($occupancyRatePerMonth);
    
        // 🔹 Total Malam Menginap (Weekdays & Weekend)
        $totalWeekNights = $bookings->sum('no_of_week_nights');
        $totalWeekendNights = $bookings->sum('no_of_weekend_nights');
    
        // 🔹 Ambil Daftar Hotel untuk Filter
        $hotels = User::where('usertype', 'hotel')->get();
    
        return view('admin.okupansihotel', compact(
            'hotels', 'totalReservations', 'averageStay', 'occupancyRate', 'cancellationRate',
            'weekdayOccupancy', 'avgStayPerMonth', 'monthlyOccupancy', 'topMarketSegments',
            'cancellationRatio', 'roomTypeDistribution', 'occupancyRatePerMonth',
            'totalWeekNights', 'totalWeekendNights', 'startDate', 'endDate', 'hotelId'
        ));
    }
    
}
