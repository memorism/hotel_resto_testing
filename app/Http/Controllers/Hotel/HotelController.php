<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Charts\BookingChart;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HotelController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Booking::where('user_id', $userId);
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        $bookings = $query->get();

        // 1️⃣ Key Metrics
        $totalRevenue = $bookings->sum(fn($booking) => ($booking->no_of_weekend_nights + $booking->no_of_week_nights) * $booking->avg_price_per_room);
        $totalExpenses = 0; // Dummy data, bisa diambil dari database
        $profit = $totalRevenue - $totalExpenses;
        $revPAR = ($bookings->count() > 0) ? $totalRevenue / $bookings->count() : 0;
        $adr = ($bookings->count() > 0) ? $totalRevenue / $bookings->sum('no_of_week_nights') : 0;
        $cancellationLoss = $bookings->where('booking_status', 'Canceled')->sum(fn($booking) => ($booking->no_of_weekend_nights + $booking->no_of_week_nights) * $booking->avg_price_per_room);

        // 2️⃣ Pendapatan Per Bulan
        $monthlyRevenue = $bookings->groupBy('arrival_month')->map(fn($row) => $row->sum(fn($booking) => ($booking->no_of_weekend_nights + $booking->no_of_week_nights) * $booking->avg_price_per_room))->toArray();
        ksort($monthlyRevenue);

        // 3️⃣ Biaya Operasional vs Pendapatan
        $monthlyExpenses = array_fill_keys(array_keys($monthlyRevenue), 0); // Dummy data


        // 5️⃣ Pendapatan Berdasarkan Segmen Pasar
        $marketSegmentRevenue = $bookings->groupBy('market_segment_type')->map(fn($row) => $row->sum(fn($booking) => ($booking->no_of_weekend_nights + $booking->no_of_week_nights) * $booking->avg_price_per_room))->toArray();
        $marketSegmentBookings = $bookings->groupBy('market_segment_type')->map(fn($row) => count($row))->toArray();

        // 5️⃣ **Top Performing Rooms (Kamar dengan Pendapatan Tertinggi)**
        $roomRevenue = $bookings->groupBy('room_type_reserved')->map(fn($row) => $row->sum(fn($booking) => ($booking->no_of_weekend_nights + $booking->no_of_week_nights) * $booking->avg_price_per_room))->toArray();
        $roomBookings = $bookings->groupBy('room_type_reserved')->map(fn($row) => count($row))->toArray();



        return view('hotel.dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalExpenses' => $totalExpenses,
            'profit' => $profit,
            'revPAR' => $revPAR,
            'adr' => $adr,
            'cancellationLoss' => $cancellationLoss,
            'monthlyRevenue' => $monthlyRevenue,
            'monthlyExpenses' => $monthlyExpenses,
            'roomRevenue' => $roomRevenue,
            'roomBookings' => $roomBookings,
            'marketSegmentRevenue' => $marketSegmentRevenue,
            'marketSegmentBookings' => $marketSegmentBookings,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }
}

