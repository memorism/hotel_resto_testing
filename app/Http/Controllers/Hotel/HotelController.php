<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HotelController extends Controller
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

                $daysInRange = $start->diffInDays($end) + 1;
            } catch (\Exception $e) {
                return back()->withErrors(['Tanggal tidak valid.']);
            }
        } else {
            $daysInRange = 30; // default untuk perhitungan RevPAR jika range tidak diberikan
        }

        $bookings = $query->get();

        // Key Metrics
        $totalRevenue = $bookings->where('booking_status', 'Not_Canceled')->sum(fn($b) =>
            ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room
        );
        $totalExpenses = 0; // Dummy sementara
        $profit = $totalRevenue - $totalExpenses;
        $totalNightsSold = $bookings->where('booking_status', 'Not_Canceled')->sum(fn($b) =>
            $b->no_of_weekend_nights + $b->no_of_week_nights
        );
        $roomsSold = $bookings->where('booking_status', 'Not_Canceled')->count();
        $adr = ($roomsSold > 0) ? $totalRevenue / $roomsSold : 0;
        $totalRooms = $user->rooms()->sum('total_rooms');
        $revPAR = ($totalRooms > 0 && $daysInRange > 0) ? ($totalRevenue / ($totalRooms * $daysInRange)) : 0;
        $cancellationLoss = $bookings->where('booking_status', 'Canceled')->sum(fn($b) =>
            ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room
        );

        // Pendapatan per bulan
        $monthlyRevenue = $bookings->groupBy('arrival_month')->map(fn($group) =>
            $group->sum(fn($b) =>
                ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room
            )
        )->toArray();
        ksort($monthlyRevenue);

        // Biaya operasional dummy
        $monthlyExpenses = array_fill_keys(array_keys($monthlyRevenue), 0);

        // Segmentasi pasar
        $marketSegmentRevenue = $bookings->groupBy('market_segment_type')->map(fn($group) =>
            $group->sum(fn($b) =>
                ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room
            )
        )->toArray();
        $marketSegmentBookings = $bookings->groupBy('market_segment_type')->map(fn($group) => count($group))->toArray();

        // Top performing rooms
        $roomRevenue = $bookings->groupBy('room_type_reserved')->map(fn($group) =>
            $group->sum(fn($b) =>
                ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room
            )
        )->toArray();
        $roomBookings = $bookings->groupBy('room_type_reserved')->map(fn($group) => count($group))->toArray();

        return view('hotel.dashboard', compact(
            'totalRevenue', 'totalExpenses', 'profit', 'revPAR', 'adr',
            'cancellationLoss', 'monthlyRevenue', 'monthlyExpenses',
            'roomRevenue', 'roomBookings', 'marketSegmentRevenue',
            'marketSegmentBookings', 'startDate', 'endDate'
        ));
    }
}
