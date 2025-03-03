<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OkupansiController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Filter data berdasarkan user login & tanggal
        $query = Booking::where('user_id', $userId);
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        $bookings = $query->get();

        // 1️⃣ Key Metrics
        $totalReservations = $bookings->count();
        $averageStay = $bookings->avg(fn($booking) => $booking->no_of_weekend_nights + $booking->no_of_week_nights);
        $occupancyRate = ($totalReservations > 0) ? ($totalReservations / 100) * 100 : 0;
        $cancellationRate = ($totalReservations > 0) ? ($bookings->where('booking_status', 'Canceled')->count() / $totalReservations) * 100 : 0;

        // 2️⃣ Okupansi Berdasarkan Hari Kedatangan
        $weekdayOccupancy = $bookings->groupBy('arrival_date')->map(fn($row) => count($row))->toArray();

        // 3️⃣ Rata-rata Lama Menginap per Bulan
        $bookings->each(function ($booking) {
            $booking->total_nights = $booking->no_of_weekend_nights + $booking->no_of_week_nights;
        });
        $avgStayPerMonth = $bookings->groupBy('arrival_month')->map(fn($row) => $row->avg('total_nights'))->toArray();
        ksort($avgStayPerMonth); // Urutkan bulan

        // 4️⃣ Okupansi Berdasarkan Segmentasi Pasar
        $topMarketSegments = $bookings->groupBy('market_segment_type')->map(fn($row) => count($row))->sortDesc()->take(5)->toArray();

        // 5️⃣ Rasio Pembatalan per Bulan
        $cancellationRatio = $bookings->groupBy('arrival_month')->map(fn($row) => count($row) > 0 ? $row->where('booking_status', 'Canceled')->count() / count($row) : 0)->toArray();
        ksort($cancellationRatio);

        // 4️⃣ Okupansi Berdasarkan Tipe Kamar
        $roomTypeDistribution = $bookings->where('booking_status', 'Not_Canceled')
            ->groupBy('room_type_reserved')
            ->map(fn($row) => count($row))
            ->sortDesc()
            ->toArray();

        $monthlyOccupancy = $bookings->where('booking_status', 'Not_Canceled')
            ->groupBy('arrival_month')
            ->map(fn($row) => count($row))
            ->toArray();
        ksort($monthlyOccupancy);

        $occupancyRatePerMonth = $bookings->groupBy('arrival_month')->map(function ($rows) {
            $total = count($rows);
            $notCanceled = $rows->where('booking_status', 'Not_Canceled')->count();
            return $total > 0 ? ($notCanceled / $total) * 100 : 0;
        })->toArray();
        ksort($occupancyRatePerMonth);

        $totalWeekNights = $bookings->sum('no_of_week_nights');
        $totalWeekendNights = $bookings->sum('no_of_weekend_nights');

        return view('hotel.okupansi', [
            'totalReservations' => $totalReservations,
            'averageStay' => $averageStay,
            'occupancyRate' => $occupancyRate,
            'cancellationRate' => $cancellationRate,
            'weekdayOccupancy' => $weekdayOccupancy,
            'avgStayPerMonth' => $avgStayPerMonth,
            'monthlyOccupancy' => $monthlyOccupancy,
            'topMarketSegments' => $topMarketSegments,
            'cancellationRatio' => $cancellationRatio,
            'roomTypeDistributionData' => $roomTypeDistribution,
            'occupancyRatePerMonth' => $occupancyRatePerMonth,
            'totalWeekNights' => $totalWeekNights,
            'totalWeekendNights' => $totalWeekendNights,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }
}

