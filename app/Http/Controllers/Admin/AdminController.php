<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Charts\AdminDashboardChart;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user_id dari request
        $selectedUserId = $request->input('user_id');

        // Ambil jumlah hotel dan resto
        $hotelCount = User::where('usertype', 'hotel')->count();
        $restoCount = User::where('usertype', 'resto')->count();

        // Ambil daftar semua pengguna
        $users = User::all();

        // Siapkan chart untuk data yang diinginkan
        $chart = new AdminDashboardChart();

        // Pastikan chart mengambil data berdasarkan selectedUserId jika ada
        $chart->bookingStatusChart = $chart->createBookingStatusChart($selectedUserId);
        $chart->typeMealChart = $chart->createTypeMealChart($selectedUserId);
        $chart->arrivalYearChart = $chart->createArrivalYearChart($selectedUserId);
        $chart->arrivalMonthChart = $chart->createArrivalMonthChart($selectedUserId);
        $chart->roomTypeChart = $chart->createRoomTypeChart($selectedUserId);
        $chart->marketSegmentChart = $chart->createMarketSegmentChart($selectedUserId);

        // Kirim data ke view
        return view('admin.dashboard', compact('hotelCount', 'restoCount', 'users', 'selectedUserId', 'chart'));
    }
}
