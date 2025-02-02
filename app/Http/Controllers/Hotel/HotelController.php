<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Charts\BookingChart;

class HotelController extends Controller
{
    public function index(BookingChart $bookingChart)
    {
        $occupancyData = $bookingChart->occupancyChart;

        return view('hotel.dashboard', [
            'bookingStatusChart' => $bookingChart->bookingStatusChart,
            'leadTimeChart' => $bookingChart->leadTimeChart,
            'typeMealChart' => $bookingChart->typeMealChart,
            'arrivalYearChart' => $bookingChart->arrivalYearChart,
            'arrivalMonthChart' => $bookingChart->arrivalMonthChart,
            'roomTypeChart' => $bookingChart->roomTypeChart,
            'marketSegmentChart' => $bookingChart->marketSegmentChart,
            // 'occupancyChart' => $occupancyData['chart'],
            // 'occupancyRate' => $occupancyData['occupancyRate'],
            // 'specialRequestsChart' => $bookingChart->specialRequestsChart,
            // 'pricePerRoomChart' => $bookingChart->pricePerRoomChart,
            // 'BookingStatusByYearChart' => $bookingChart->BookingStatusByYearChart
        ]);
    }
}
