<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingChart extends Chart
{
    public $bookingStatusChart;
    public $typeMealChart;
    public $arrivalYearChart;
    public $arrivalMonthChart;
    public $roomTypeChart;
    public $marketSegmentChart;
    public $leadTimeChart; 
    public $specialRequestsChart; 
    public $pricePerRoomChart;
    public $cancellationByYearChart; 
    public $weekendVsWeekdayChart; 
    public $priceDistributionChart; 

    public function __construct()
    {
        parent::__construct();
        $this->setData(Booking::all()); 
    }

    public function setData($bookings)
    {
        $this->bookingStatusChart = $this->createChart($bookings, 'booking_status', 'Booking Status Distribution', 'pie');
        $this->typeMealChart = $this->createChart($bookings, 'type_of_meal_plan', 'Type of Meal Plan', 'bar');
        $this->arrivalYearChart = $this->createChart($bookings, 'arrival_year', 'Yearly Distribution', 'line');
        $this->arrivalMonthChart = $this->createChart($bookings, 'arrival_month', 'Monthly Distribution', 'bar', true);
        $this->roomTypeChart = $this->createChart($bookings, 'room_type_reserved', 'Room Type Reserved', 'doughnut');
        $this->marketSegmentChart = $this->createChart($bookings, 'market_segment_type', 'Market Segment Type', 'bar');
        $this->leadTimeChart = $this->createLeadTimeChart($bookings); 
        $this->specialRequestsChart = $this->createChart($bookings, 'no_of_special_requests', 'Jumlah Permintaan Khusus', 'bar');
        $this->pricePerRoomChart = $this->createPricePerRoomChart($bookings);
        $this->cancellationByYearChart = $this->createChart($bookings->where('booking_status', 'Canceled'), 'arrival_year', 'Tingkat Pembatalan per Tahun', 'bar');
        $this->weekendVsWeekdayChart = $this->createWeekendVsWeekdayChart($bookings);
        $this->priceDistributionChart = $this->createPriceDistributionChart($bookings);
    }

    // 🔹 Tambahkan fungsi untuk Lead Time Chart
    private function createLeadTimeChart($bookings)
    {
        $data = $bookings->groupBy('lead_time')->map(fn($row) => count($row))->all();

        $chart = new Chart;
        $chart->labels(array_keys($data));
        $chart->dataset('Lead Time (Hari Sebelum Check-in)', 'bar', array_values($data))
              ->backgroundColor('#ffce56');

        return $chart;
    }

    private function createPricePerRoomChart($bookings)
    {
        $data = $bookings->groupBy('room_type_reserved')->map(fn($row) => $row->avg('avg_price_per_room'))->all();

        $chart = new Chart;
        $chart->labels(array_keys($data));
        $chart->dataset('Harga Rata-rata Per Tipe Kamar', 'bar', array_values($data))
              ->backgroundColor('#2ecc71');

        return $chart;
    }

    // 🔹 Perbandingan Pemesanan Akhir Pekan vs Hari Kerja
    private function createWeekendVsWeekdayChart($bookings)
    {
        $weekendBookings = $bookings->sum('no_of_weekend_nights');
        $weekdayBookings = $bookings->sum('no_of_week_nights');

        $chart = new Chart;
        $chart->labels(['Akhir Pekan', 'Hari Kerja']);
        $chart->dataset('Perbandingan Pemesanan', 'bar', [$weekendBookings, $weekdayBookings])
              ->backgroundColor(['#e74c3c', '#3498db']);

        return $chart;
    }

      // 🔹 Distribusi Harga Kamar (Histogram)
      private function createPriceDistributionChart($bookings)
      {
          $data = $bookings->groupBy('avg_price_per_room')->map(fn($row) => count($row))->all();
          ksort($data); // Urutkan harga dari kecil ke besar
  
          $chart = new Chart;
          $chart->labels(array_keys($data));
          $chart->dataset('Distribusi Harga Kamar', 'line', array_values($data))
                ->backgroundColor('#9b59b6')
                ->fill(false);
  
          return $chart;
      }

     // 🔹 Fungsi Pembuatan Chart Umum
     private function createChart($bookings, $column, $title, $type, $sort = false)
     {
         $data = $bookings->groupBy($column)->map(fn($row) => count($row))->all();
 
         if ($sort) {
             ksort($data);
         }
 
         $chart = new Chart;
         $chart->labels(array_keys($data));
         $chart->dataset($title, $type, array_values($data))
             ->backgroundColor(['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff']);
 
         return $chart;
     }
}

