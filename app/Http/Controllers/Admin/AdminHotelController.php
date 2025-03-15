<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminHotelController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $hotelId = $request->input('hotel_id');

        // Query data booking
        $query = Booking::query();

        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->format('Y-m-d');
            $endDate = Carbon::parse($endDate)->format('Y-m-d');

            // Gabungkan arrival_year, arrival_month, arrival_date ke format tanggal
            $query->whereRaw("STR_TO_DATE(CONCAT(arrival_year, '-', arrival_month, '-', arrival_date), '%Y-%m-%d') BETWEEN ? AND ?", [$startDate, $endDate]);
        }

        if ($hotelId) {
            $query->where('user_id', $hotelId);
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

        // 3️⃣ Biaya Operasional vs Pendapatan (Dummy Data)
        $monthlyExpenses = array_fill_keys(array_keys($monthlyRevenue), rand(5000000, 20000000));

        // 4️⃣ Pendapatan Berdasarkan Segmen Pasar
        $marketSegmentRevenue = $bookings->groupBy('market_segment_type')->map(fn($row) => $row->sum(fn($booking) => ($booking->no_of_weekend_nights + $booking->no_of_week_nights) * $booking->avg_price_per_room))->toArray();
        $marketSegmentBookings = $bookings->groupBy('market_segment_type')->map(fn($row) => count($row))->toArray();

        // 5️⃣ Top Performing Rooms
        $roomRevenue = $bookings->groupBy('room_type_reserved')->map(fn($row) => $row->sum(fn($booking) => ($booking->no_of_weekend_nights + $booking->no_of_week_nights) * $booking->avg_price_per_room))->toArray();
        $roomBookings = $bookings->groupBy('room_type_reserved')->map(fn($row) => count($row))->toArray();

        // Ambil daftar hotel berdasarkan usertype = "hotel"
        $hotels = User::where('usertype', 'hotel')->get();

        return view('admin.hotel', [
            'hotels' => $hotels,
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
            'endDate' => $endDate,
            'hotelId' => $hotelId
        ]);
    }
}
