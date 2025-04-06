<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Charts\BookingChart;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class HotelController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $daysInRange = $start->diffInDays($end) + 1;

        $query = Booking::where('user_id', $userId);

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
        $totalRevenue = $bookings->where('booking_status', 'Not_Canceled')
            ->sum(function ($booking) {
                $nights = $booking->no_of_weekend_nights + $booking->no_of_week_nights;
                $price = $booking->avg_price_per_room;
                return $nights * $price;
            });
        $totalExpenses = 0; // Dummy data, bisa diambil dari database
        $profit = $totalRevenue - $totalExpenses;
        $totalNightsSold = $bookings->where('booking_status', 'Not_Canceled')
            ->sum(fn($b) => $b->no_of_weekend_nights + $b->no_of_week_nights);
        $roomsSold = $bookings->where('booking_status', 'Not_Canceled')->count();
        $adr = ($roomsSold > 0) ? $totalRevenue / $roomsSold : 0;
        $totalRooms = $user->rooms()->sum('total_rooms');
        $revPAR = ($totalRooms > 0 && $daysInRange > 0)
            ? ($totalRevenue / ($totalRooms * $daysInRange))
            : 0;
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

