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

        $restoUsers = User::where('usertype', 'resto')->with('orders')->get();
        $hotelUsers = User::where('usertype', 'hotel')->with('bookings')->get();

        $restoStats = $restoUsers->map(function ($user) {
            $lastOrder = $user->orders->sortByDesc('updated_at')->first();
            return [
                'name' => $user->name,
                'last_updated' => $lastOrder ? $lastOrder->updated_at->diffForHumans() : 'Belum pernah menginput data',
            ];
        });
        

        $hotelStats = $hotelUsers->map(function ($user) {
            $lastBooking = $user->bookings->sortByDesc('updated_at')->first();
            return [
                'name' => $user->name,
                'last_updated' => $lastBooking ? $lastBooking->updated_at->diffForHumans() : 'Belum pernah menginput data',
            ];
        });




        // Kirim data ke view
        return view('admin.dashboard')->with([
            'hotelCount' => $hotelCount,
            'restoCount' => $restoCount,
            'restoStats' => $restoStats,
            'hotelStats' => $hotelStats,
        ]);
            }
}
