<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\HotelBooking;

class AdminHotelController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $hotelId = $request->input('hotel_id');

        $start = $startDate ? Carbon::parse($startDate) : null;
        $end = $endDate ? Carbon::parse($endDate) : null;
        $daysInRange = ($start && $end) ? $start->diffInDays($end) + 1 : 1;

        $query = HotelBooking::query();

        if ($start && $end) {
            $query->whereRaw("STR_TO_DATE(CONCAT(arrival_year, '-', arrival_month, '-', arrival_date), '%Y-%m-%d') BETWEEN ? AND ?", [
                $start->format('Y-m-d'), $end->format('Y-m-d')
            ]);
        }

        if ($hotelId) {
            $query->where('hotel_id', $hotelId);
        }

        $bookings = $query->get();

        $totalRooms = $hotelId
            ? HotelRoom::where('hotel_id', $hotelId)->sum('total_rooms')
            : HotelRoom::sum('total_rooms');

        $totalRevenue = $bookings->where('booking_status', 'Not_Canceled')->sum(function ($booking) {
            $nights = $booking->no_of_weekend_nights + $booking->no_of_week_nights;
            return $nights * $booking->avg_price_per_room;
        });

        $totalExpenses = 0; // Dummy
        $profit = $totalRevenue - $totalExpenses;

        $totalNightsSold = $bookings->where('booking_status', 'Not_Canceled')->sum(fn($b) => $b->no_of_weekend_nights + $b->no_of_week_nights);
        $roomsSold = $bookings->where('booking_status', 'Not_Canceled')->count();
        $adr = $roomsSold > 0 ? $totalRevenue / $roomsSold : 0;

        $revPAR = ($totalRooms > 0 && $daysInRange > 0)
            ? ($totalRevenue / ($totalRooms * $daysInRange))
            : 0;

        $cancellationLoss = $bookings->where('booking_status', 'Canceled')->sum(fn($booking) =>
            ($booking->no_of_weekend_nights + $booking->no_of_week_nights) * $booking->avg_price_per_room
        );

        $monthlyRevenue = $bookings->groupBy('arrival_month')->map(fn($row) =>
            $row->sum(fn($b) => ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room)
        )->toArray();
        ksort($monthlyRevenue);

        $monthlyExpenses = array_fill_keys(array_keys($monthlyRevenue), 0); // Dummy

        $marketSegmentRevenue = $bookings->groupBy('market_segment_type')->map(fn($row) =>
            $row->sum(fn($b) => ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room)
        )->toArray();

        $marketSegmentBookings = $bookings->groupBy('market_segment_type')->map(fn($row) => count($row))->toArray();

        $roomRevenue = $bookings->groupBy('room_type_reserved')->map(fn($row) =>
            $row->sum(fn($b) => ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room)
        )->toArray();

        $roomBookings = $bookings->groupBy('room_type_reserved')->map(fn($row) => count($row))->toArray();

        $hotels = Hotel::all();

        return view('admin.hotel', compact(
            'hotels', 'totalRevenue', 'totalExpenses', 'profit', 'revPAR', 'adr', 'cancellationLoss',
            'monthlyRevenue', 'monthlyExpenses', 'roomRevenue', 'roomBookings',
            'marketSegmentRevenue', 'marketSegmentBookings',
            'startDate', 'endDate', 'hotelId'
        ));
    }
}
