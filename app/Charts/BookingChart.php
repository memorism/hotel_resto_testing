<?php


namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingChart extends Chart
{
    // Deklarasi chart yang akan digunakan
    public $bookingStatusChart;
    public $typeMealChart;
    public $arrivalYearChart;
    public $arrivalMonthChart;
    public $roomTypeChart;
    public $marketSegmentChart;
    public $occupancyChart;
    public $leadTimeChart;
    public $specialRequestsChart;
    public $pricePerRoomChart;
    public $BookingStatusByYearChart;

    public function __construct()
    {
        parent::__construct();

        // Inisialisasi chart
        $this->bookingStatusChart = $this->createBookingStatusChart();
        $this->typeMealChart = $this->createTypeMealChart();
        $this->arrivalYearChart = $this->createArrivalYearChart();
        $this->arrivalMonthChart = $this->createArrivalMonthChart();
        $this->roomTypeChart = $this->createRoomTypeChart();
        $this->marketSegmentChart = $this->createMarketSegmentChart();
        // $this->occupancyChart = $this->createOccupancyChart();
        // $this->leadTimeChart = $this->createLeadTimeChart();
        // $this->specialRequestsChart = $this->createSpecialRequestsChart();
        // $this->pricePerRoomChart = $this->createPricePerRoomChart();
        // $this->BookingStatusByYearChart = $this->createBookingStatusByYearChart();
    }

    private function getUserData()
    {
        $userId = Auth::id(); // Dapatkan user_id yang sedang login
        return Booking::where('user_id', $userId)->get(); // Ambil data hanya untuk user yang sedang login
    }

    // 1️⃣ Booking Status Distribution (Pie Chart)
    private function createBookingStatusChart()
    {
        $data = $this->getUserData()
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
    private function createTypeMealChart()
    {
        $data = $this->getUserData()
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
    private function createArrivalYearChart()
    {
        $data = $this->getUserData()
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
    private function createArrivalMonthChart()
    {
        $data = $this->getUserData()
        ->groupBy('arrival_month')
        ->map(fn($row) => count($row))
        ->all();

    // Urutkan data berdasarkan urutan bulan
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];

    // Mengurutkan data berdasarkan bulan (dari 1 hingga 12)
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
    private function createRoomTypeChart()
    {
        $data = $this->getUserData()
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
    private function createMarketSegmentChart()
    {
        $data = $this->getUserData()
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

    // // 7️⃣ Occupancy (Pie Chart)
    // private function createOccupancyChart()
    // {
    //     $totalRooms = 100; // Asumsikan total kamar tetap 100
    //     $occupiedRooms = $this->getUserData()
    //         ->where('booking_status', 'Confirmed')
    //         ->sum('no_of_adults'); // Menggunakan jumlah tamu sebagai perkiraan kamar terisi

    //     $availableRooms = max(0, $totalRooms - $occupiedRooms);
    //     $occupancyRate = ($occupiedRooms / $totalRooms) * 100;

    //     $chart = new Chart;
    //     $chart->labels(['Occupied', 'Available']);
    //     $chart->dataset('Hotel Occupancy', 'pie', [$occupiedRooms, $availableRooms])
    //         ->backgroundColor(['#ff6384', '#36a2eb']);

    //     return [
    //         'chart' => $chart,
    //         'occupancyRate' => $occupancyRate
    //     ];
    // }

    // // 8️⃣ Lead Time vs Booking Status (Bar Chart)
    // private function createLeadTimeChart()
    // {
    //     $data = $this->getUserData()
    //         ->groupBy('booking_status')
    //         ->map(fn($row) => $row->avg('lead_time'))
    //         ->all();

    //     $chart = new Chart;
    //     $chart->labels(array_keys($data));
    //     $chart->dataset('Lead Time vs Booking Status', 'bar', array_values($data))
    //         ->backgroundColor('#ffce56');

    //     return $chart;
    // }

    // // 9️⃣ Room Type vs Booking Status (Bar Chart)
    // private function createRoomTypeBookingStatusChart()
    // {
    //     $data = $this->getUserData()
    //         ->groupBy(['room_type_reserved', 'booking_status'])
    //         ->map(fn($row) => count($row))
    //         ->all();

    //     $chart = new Chart;
    //     $chart->labels(array_keys($data));
    //     $chart->dataset('Room Type vs Booking Status', 'bar', array_values($data))
    //         ->backgroundColor('#4bc0c0');

    //     return $chart;
    // }

    // // 🔟 Market Segment vs Booking Status (Bar Chart)
    // private function createMarketSegmentBookingStatusChart()
    // {
    //     $data = $this->getUserData()
    //         ->groupBy(['market_segment_type', 'booking_status'])
    //         ->map(fn($row) => count($row))
    //         ->all();

    //     $chart = new Chart;
    //     $chart->labels(array_keys($data));
    //     $chart->dataset('Market Segment vs Booking Status', 'bar', array_values($data))
    //         ->backgroundColor('#9966ff');

    //     return $chart;
    // }

    // // 1️⃣1️⃣ Special Requests vs Booking Status (Scatter Plot)
    // private function createSpecialRequestsChart()
    // {
    //     $data = $this->getUserData()
    //         ->groupBy('no_of_special_requests')
    //         ->map(fn($row) => count($row))
    //         ->all();

    //     $chart = new Chart;
    //     $chart->labels(array_keys($data));
    //     $chart->dataset('Special Requests vs Booking Status', 'scatter', array_values($data))
    //         ->backgroundColor('#ff9f40');

    //     return $chart;
    // }

    // // 1️⃣2️⃣ Average Price per Room vs Booking Status (Boxplot)
    // private function createPricePerRoomChart()
    // {
    //     $data = $this->getUserData()
    //         ->groupBy('booking_status')
    //         ->map(fn($row) => $row->avg('avg_price_per_room'))
    //         ->all();

    //     $chart = new Chart;
    //     $chart->labels(array_keys($data));
    //     $chart->dataset('Average Price per Room vs Booking Status', 'bar', array_values($data))
    //         ->backgroundColor('#ff6384');

    //     return $chart;
    // }

    // // 1️⃣3️⃣ Arrival Month vs Booking Status (Line Chart)
    // private function createBookingStatusByYearChart()
    // {
    //     $data = $this->getUserData()
    //         ->groupBy(['arrival_month', 'booking_status'])
    //         ->map(fn($row) => count($row))
    //         ->all();

    //     $chart = new Chart;
    //     $chart->labels(array_keys($data));
    //     $chart->dataset('Arrival Month vs Booking Status', 'line', array_values($data))
    //         ->backgroundColor('#36a2eb');

    //     return $chart;
    // }

    
}
