<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OkupansiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $hotelId = $user->hotel_id;

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $query = HotelBooking::where('hotel_id', $hotelId);

        if ($status) {
            $query->where('approval_status', $status);
        }


        if ($startDate && $endDate) {
            try {
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();
                $query->whereRaw("
                STR_TO_DATE(CONCAT(arrival_year, '-', LPAD(arrival_month, 2, '0'), '-', LPAD(arrival_date, 2, '0')), '%Y-%m-%d')
                BETWEEN ? AND ?
            ", [$start->format('Y-m-d'), $end->format('Y-m-d')]);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['Tanggal tidak valid.']);
            }
        }

        $bookings = $query->get();
        $totalRooms = $user->rooms()->sum('total_rooms');

        // Filter data
        $confirmedBookings = $bookings->where('booking_status', 'Not_Canceled');
        $canceledBookings = $bookings->where('booking_status', 'Canceled');
        $totalReservations = $bookings->count();
        $confirmedCount = $confirmedBookings->count();

        //  Key Metrics
        $averageStay = $confirmedBookings->avg(fn($b) => $b->no_of_weekend_nights + $b->no_of_week_nights) ?? 0;
        $occupancyRate = ($totalRooms > 0) ? ($confirmedCount / $totalRooms) * 100 : 0;
        $cancellationRate = ($totalReservations > 0) ? ($canceledBookings->count() / $totalReservations) * 100 : 0;

        //  Okupansi per hari (by arrival_date)
        $weekdayOccupancy = $confirmedBookings->groupBy('arrival_date')
            ->map(fn($group) => $group->count())->toArray();
        ksort($weekdayOccupancy);

        //  Hitung total_nights untuk avg stay per month
        $bookings->each(function ($b) {
            $b->total_nights = $b->no_of_weekend_nights + $b->no_of_week_nights;
        });

        //  Lama menginap rata-rata per bulan
        $avgStayPerMonth = $confirmedBookings
            ->groupBy('arrival_month')
            ->map(fn($rows) => $rows->avg('total_nights'))
            ->toArray();
        ksort($avgStayPerMonth);

        //  Segmentasi pasar (Top 5)
        $topMarketSegments = $confirmedBookings
            ->groupBy('market_segment_type')
            ->map(fn($rows) => count($rows))
            ->sortDesc()
            ->take(5)
            ->toArray();

        //  Rasio pembatalan per bulan
        $cancellationRatio = $bookings
            ->groupBy('arrival_month')
            ->map(
                fn($rows) => count($rows) > 0
                ? ($rows->where('booking_status', 'Canceled')->count() / count($rows)) * 100
                : 0
            )->toArray();
        ksort($cancellationRatio);

        // Distribusi tipe kamar
        $roomTypeDistribution = $confirmedBookings
            ->groupBy('room_type_reserved')
            ->map(fn($rows) => count($rows))
            ->sortDesc()
            ->toArray();

        //  Jumlah booking per bulan
        $monthlyOccupancy = $confirmedBookings
            ->groupBy('arrival_month')
            ->map(fn($rows) => count($rows))
            ->toArray();
        ksort($monthlyOccupancy);

        //  Tingkat okupansi per bulan (dalam persen)
        $occupancyRatePerMonth = $bookings
            ->groupBy('arrival_month')
            ->map(function ($rows) {
                $total = count($rows);
                $confirmed = $rows->where('booking_status', 'Not_Canceled')->count();
                return $total > 0 ? ($confirmed / $total) * 100 : 0;
            })->toArray();
        ksort($occupancyRatePerMonth);

        //  Total malam weekday & weekend
        $totalWeekNights = $confirmedBookings->sum('no_of_week_nights');
        $totalWeekendNights = $confirmedBookings->sum('no_of_weekend_nights');

        return view('hotel.okupansi', [
            'startDate' => $startDate,
            'endDate' => $endDate,
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
            'status' => $status,
        ]);
    }

}
