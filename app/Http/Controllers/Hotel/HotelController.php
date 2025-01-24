<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Booking; // Model Booking kamu
use App\Charts\BookingChart;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Http\Request;

class HotelController extends Controller
{
        // Menambahkan metode index untuk menampilkan data
        public function index()
        {
            $userId = auth()->id();
            $bookings = Booking::where('user_id', $userId)->get();
    
            // Data numerik untuk perhitungan persentase
            $bookingStatuses = $bookings->groupBy('booking_status')->map(function ($group) use ($bookings) {
                return ($group->count() / $bookings->count()) * 100; // Persentase per status
            });
    
            $noOfAdultsData = $bookings->pluck('no_of_adults')->countBy()->map(function ($count, $key) use ($bookings) {
                return ($count / $bookings->count()) * 100; // Persentase per no_of_adults
            });
    
            $noOfChildrenData = $bookings->pluck('no_of_children')->countBy()->map(function ($count, $key) use ($bookings) {
                return ($count / $bookings->count()) * 100; // Persentase per no_of_children
            });
    
            // Siapkan data untuk view
            $data = [
                'booking_status' => $bookingStatuses,
                'no_of_adults' => $noOfAdultsData,
                'no_of_children' => $noOfChildrenData,
                'no_of_weekend_nights' => $bookings->pluck('no_of_weekend_nights')->countBy()->map(function ($count, $key) use ($bookings) {
                    return ($count / $bookings->count()) * 100; // Persentase per no_of_weekend_nights
                }),
                'lead_time' => $bookings->pluck('lead_time')->countBy()->map(function ($count, $key) use ($bookings) {
                    return ($count / $bookings->count()) * 100; // Persentase per lead_time
                }),
                // Data lainnya juga bisa dihitung persentasenya dengan cara serupa
            ];
    
            return view('hotel.dashboard', compact('data'));
        }
    
}
