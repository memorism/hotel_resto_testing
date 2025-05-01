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

        $query = HotelBooking::where('hotel_id', $hotelId);

        if ($startDate && $endDate) {
            try {
                $start = Carbon::parse($startDate);
                $end = Carbon::parse($endDate);
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

        // Key Metrics
        $totalReservations = $bookings->count();
        $confirmedBookings = $bookings->where('booking_status', 'Not_Canceled');
        $canceledBookings = $bookings->where('booking_status', 'Canceled');

        $totalReservations2 = $confirmedBookings->count();
        $averageStay = $confirmedBookings->avg(fn($b) => $b->no_of_weekend_nights + $b->no_of_week_nights);
        $occupancyRate = ($totalReservations2 > 0 && $totalRooms > 0) ? ($totalReservations2 / $totalRooms) * 100 : 0;
        $cancellationRate = ($totalReservations > 0) ? ($canceledBookings->count() / $totalReservations) * 100 : 0;

        // Per Hari (arrival_date)
        $weekdayOccupancy = $bookings->groupBy('arrival_date')->map(fn($row) => count($row))->toArray();
        ksort($weekdayOccupancy);

        // Rata-rata lama menginap per bulan
        $bookings->each(function ($b) {
            $b->total_nights = $b->no_of_weekend_nights + $b->no_of_week_nights;
        });
        $avgStayPerMonth = $confirmedBookings
            ->groupBy('arrival_month')
            ->map(fn($row) => $row->avg('total_nights'))
            ->toArray();
        ksort($avgStayPerMonth);

        // Segmentasi pasar
        $topMarketSegments = $confirmedBookings
            ->groupBy('market_segment_type')
            ->map(fn($row) => count($row))
            ->sortDesc()
            ->take(5)
            ->toArray();

        // Rasio pembatalan per bulan
        $cancellationRatio = $bookings
            ->groupBy('arrival_month')
            ->map(fn($row) => count($row) > 0 ? $row->where('booking_status', 'Canceled')->count() / count($row) * 100 : 0)
            ->toArray();
        ksort($cancellationRatio);

        // Okupansi berdasarkan tipe kamar
        $roomTypeDistribution = $confirmedBookings
            ->groupBy('room_type_reserved')
            ->map(fn($row) => count($row))
            ->sortDesc()
            ->toArray();

        // Jumlah booking per bulan
        $monthlyOccupancy = $confirmedBookings
            ->groupBy('arrival_month')
            ->map(fn($row) => count($row))
            ->toArray();
        ksort($monthlyOccupancy);

        // Okupansi per bulan (dalam persen)
        $occupancyRatePerMonth = $bookings
            ->groupBy('arrival_month')
            ->map(function ($rows) {
                $total = count($rows);
                $notCanceled = $rows->where('booking_status', 'Not_Canceled')->count();
                return $total > 0 ? ($notCanceled / $total) * 100 : 0;
            })->toArray();
        ksort($occupancyRatePerMonth);

        $totalWeekNights = $confirmedBookings->sum('no_of_week_nights');
        $totalWeekendNights = $confirmedBookings->sum('no_of_weekend_nights');

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
