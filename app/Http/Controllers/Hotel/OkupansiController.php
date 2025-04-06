<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OkupansiController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Filter data berdasarkan user login & tanggal
        $query = Booking::where('user_id', $userId);

        $totalRooms = $user->rooms()->sum('total_rooms');

        if ($startDate && $endDate) {
            $query->whereBetween('arrival_year', [
                Carbon::parse($startDate)->format('Y'),
                Carbon::parse($endDate)->format('Y')
            ])
                ->whereBetween('arrival_month', [
                    Carbon::parse($startDate)->format('m'),
                    Carbon::parse($endDate)->format('m')
                ])
                ->whereBetween('arrival_date', [
                    Carbon::parse($startDate)->format('d'),
                    Carbon::parse($endDate)->format('d')
                ]);
        }

        $bookings = $query->get();

        // 1️⃣ Key Metrics
        $totalReservations = $bookings->count();
        $totalReservations2 = $bookings->where('booking_status', 'Not_Canceled')->count();
        $averageStay = $bookings->where('booking_status', 'Not_Canceled')
        ->avg(fn($booking) => $booking->no_of_weekend_nights + $booking->no_of_week_nights);
        $occupancyRate = ($totalReservations2 > 0 && $totalRooms > 0)
            ? ($totalReservations2 / $totalRooms) * 100
            : 0;
        $cancellationRate = ($totalReservations2 > 0) ? ($bookings->where('booking_status', 'Canceled')->count() / $totalReservations2) * 100 : 0;

        // 2️⃣ Okupansi Berdasarkan Hari Kedatangan
        $weekdayOccupancy = $bookings->groupBy('arrival_date')->map(fn($row) => count($row))->toArray();
        ksort($weekdayOccupancy);
        
        // 3️⃣ Rata-rata Lama Menginap per Bulan
        $bookings->each(function ($booking) {
            $booking->total_nights = $booking->no_of_weekend_nights + $booking->no_of_week_nights;
        });

        $avgStayPerMonth = $bookings->where('booking_status', 'Not_Canceled')
        ->groupBy('arrival_month')
        ->map(fn($row) => $row
        ->avg('total_nights'))
        ->toArray();
        ksort($avgStayPerMonth); // Urutkan bulan

        // 4️⃣ Okupansi Berdasarkan Segmentasi Pasar
        $topMarketSegments = $bookings->where('booking_status', 'Not_Canceled')
            ->groupBy('market_segment_type')
            ->map(fn($row) => count($row))
            ->sortDesc()
            ->take(5)
            ->toArray();

        // 5️⃣ Rasio Pembatalan per Bulan
        $cancellationRatio = $bookings->groupBy('arrival_month')
            ->map(fn($row) => count($row) > 0 ? $row
            ->where('booking_status', 'Canceled')->count() / count($row) : 0)->toArray();
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

        $totalWeekNights = $bookings->where('booking_status', 'Not_Canceled')
            ->sum('no_of_week_nights');
        $totalWeekendNights = $bookings->where('booking_status', 'Not_Canceled')
            ->sum('no_of_weekend_nights');

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

