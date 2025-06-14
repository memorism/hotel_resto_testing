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

        // Ambil tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');


        // Mulai query dasar
        $query = HotelBooking::where('hotel_id', $hotelId);


        if ($status) {
            $query->where('approval_status', $status);
        }

        // Filter berdasarkan range tanggal (arrival)
        if ($startDate && $endDate) {
            try {
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();

                $query->whereRaw("
                STR_TO_DATE(CONCAT(arrival_year, '-', LPAD(arrival_month, 2, '0'), '-', LPAD(arrival_date, 2, '0')), '%Y-%m-%d')
                BETWEEN ? AND ?
            ", [$start->format('Y-m-d'), $end->format('Y-m-d')]);

                $daysInRange = $start->diffInDays($end) + 1;
            } catch (\Exception $e) {
                return back()->withErrors(['Tanggal tidak valid.']);
            }
        } else {
            $daysInRange = 30; // default RevPAR jika tidak ada filter
        }

        // Ambil semua booking sesuai filter
        $bookings = $query->get();

        // Hitung metrik kunci
        $notCanceled = $bookings->where('booking_status', 'Not_Canceled');

        $totalRevenue = $notCanceled->sum(
            fn($b) =>
            ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room
        );

        $totalExpenses = 0; // Placeholder, nanti bisa diganti real cost
        $profit = $totalRevenue - $totalExpenses;

        $roomsSold = $notCanceled->count();
        $totalNightsSold = $notCanceled->sum(
            fn($b) =>
            $b->no_of_weekend_nights + $b->no_of_week_nights
        );

        $adr = $roomsSold > 0 ? $totalRevenue / $roomsSold : 0;
        $totalRooms = $user->rooms()->sum('total_rooms');
        $revPAR = ($totalRooms > 0 && $daysInRange > 0) ? $totalRevenue / ($totalRooms * $daysInRange) : 0;

        $cancellationLoss = $bookings->where('booking_status', 'Canceled')->sum(
            fn($b) =>
            ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room
        );

        // 📊 Grafik: Pendapatan per bulan
        $monthlyRevenue = $notCanceled->groupBy('arrival_month')->map(
            fn($group) =>
            $group->sum(
                fn($b) =>
                ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room
            )
        )->toArray();
        ksort($monthlyRevenue);

        // Dummy biaya operasional
        $monthlyExpenses = array_fill_keys(array_keys($monthlyRevenue), 0);

        // 📊 Segmentasi pasar
        $marketSegmentRevenue = $notCanceled->groupBy('market_segment_type')->map(
            fn($group) =>
            $group->sum(function ($b) {
                $weekendNights = is_numeric($b->no_of_weekend_nights) ? (int) $b->no_of_weekend_nights : 0;
                $weekNights = is_numeric($b->no_of_week_nights) ? (int) $b->no_of_week_nights : 0;
                $avgPrice = is_numeric($b->avg_price_per_room) ? (float) $b->avg_price_per_room : 0;
                return ($weekendNights + $weekNights) * $avgPrice;
            })
        )->toArray();

        $marketSegmentBookings = $notCanceled->groupBy('market_segment_type')->map(
            fn($group) =>
            count($group)
        )->toArray();

        // 📊 Tipe kamar
        $roomRevenue = $notCanceled->groupBy('room_type_reserved')->map(
            fn($group) =>
            $group->sum(
                fn($b) =>
                ($b->no_of_weekend_nights + $b->no_of_week_nights) * $b->avg_price_per_room
            )
        )->toArray();

        $roomBookings = $notCanceled->groupBy('room_type_reserved')->map(
            fn($group) =>
            count($group)
        )->toArray();

        return view('hotel.dashboard', compact(
            'totalRevenue',
            'totalExpenses',
            'profit',
            'revPAR',
            'adr',
            'cancellationLoss',
            'monthlyRevenue',
            'monthlyExpenses',
            'roomRevenue',
            'roomBookings',
            'marketSegmentRevenue',
            'marketSegmentBookings',
            'startDate',
            'endDate',
            'status',
        ));
    }

}
