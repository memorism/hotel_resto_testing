<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Models\Booking;

class AdminDashboardChart extends Chart
{
    public $bookingStatusChart;
    public $typeMealChart;
    public $arrivalYearChart;
    public $arrivalMonthChart;
    public $roomTypeChart;
    public $marketSegmentChart;

    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk mengambil data berdasarkan user_id
    public function getUserData($userId = null)
    {
        // Cek jika user_id disertakan
        if ($userId) {
            // Ambil data hanya untuk user tertentu
            return Booking::where('user_id', $userId)->get();
        }
        // Jika tidak ada user_id, ambil data untuk semua user
        return Booking::all();
    }

    // 1️⃣ Booking Status Distribution (Pie Chart)
    public function createBookingStatusChart($userId = null)
    {
        $data = $this->getUserData($userId)
            ->groupBy('booking_status')
            ->map(fn($row) => count($row))
            ->all();

        $chart = new Chart;
        $chart->labels(array_keys($data));
        $chart->dataset('Booking Status Distribution', 'pie', array_values($data))
            ->backgroundColor(['#ff6384', '#36a2eb']);

        return $chart;
    }

    // 2️⃣ Type of Meal Plan (Bar Chart)
    public function createTypeMealChart($userId = null)
    {
        $data = $this->getUserData($userId)
            ->groupBy('type_of_meal_plan')
            ->map(fn($row) => count($row))
            ->sort()
            ->all();

        $chart = new Chart;
        $chart->labels(array_keys($data));
        $chart->dataset('Type of Meal Plan', 'bar', array_values($data))
            ->backgroundColor('#ffce56');

        return $chart;
    }

    // 3️⃣ Yearly Distribution (Line Chart)
    public function createArrivalYearChart($userId = null)
    {
        $data = $this->getUserData($userId)
            ->groupBy('arrival_year')
            ->map(fn($row) => count($row))
            ->sort()
            ->all();

        $chart = new Chart;
        $chart->labels(array_keys($data));
        $chart->dataset('Yearly Distribution', 'line', array_values($data))
            ->backgroundColor('#4bc0c0')
            ->fill(false);

        return $chart;
    }

    // 4️⃣ Monthly Distribution (Bar Chart)
    public function createArrivalMonthChart($userId = null)
    {
        $data = $this->getUserData($userId)
            ->groupBy('arrival_month')
            ->map(fn($row) => count($row))
            ->all();

        // Urutkan data berdasarkan urutan bulan
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        ksort($data);

        $chart = new Chart;
        $chart->labels(array_map(function ($month) use ($months) {
            return $months[$month];
        }, array_keys($data)));

        $chart->dataset('Monthly Distribution', 'line', array_values($data))
            ->backgroundColor('#9966ff')
            ->fill(false);

        return $chart;
    }

    // 5️⃣ Room Type Reserved (Doughnut Chart)
    public function createRoomTypeChart($userId = null)
    {
        $data = $this->getUserData($userId)
            ->groupBy('room_type_reserved')
            ->map(fn($row) => count($row))
            ->all();

        $chart = new Chart;
        $chart->labels(array_keys($data));
        $chart->dataset('Room Type Reserved', 'doughnut', array_values($data))
            ->backgroundColor(['#ff9f40', '#ffcd56', '#36a2eb', '#4bc0c0']);

        return $chart;
    }

    // 6️⃣ Market Segment Type (Bar Chart)
    public function createMarketSegmentChart($userId = null)
    {
        $data = $this->getUserData($userId)
            ->groupBy('market_segment_type')
            ->map(fn($row) => count($row))
            ->sort()
            ->all();

        $chart = new Chart;
        $chart->labels(array_keys($data));
        $chart->dataset('Market Segment Type', 'bar', array_values($data))
            ->backgroundColor('#ff6384');

        return $chart;
    }
}
