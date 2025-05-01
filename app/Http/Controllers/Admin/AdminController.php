<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Resto;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $selectedUserId = $request->input('user_id');

        $hotelCount = Hotel::count();
        $restoCount = Resto::count();

        $hotelUsers = User::where('usertype', 'hotelnew')->with('hotelBookings')->get();
        $restoUsers = User::where('usertype', 'restonew')->with('restoOrders')->get();

        $hotelStats = $hotelUsers->map(function ($hotel) {
            $lastBooking = $hotel->hotelBookings->sortByDesc('updated_at')->first(); // ✅ perbaikan disini
            return [
                'name' => $hotel->name,
                'last_updated' => $lastBooking ? $lastBooking->updated_at->diffForHumans() : 'Belum pernah menginput data',
            ];
        });

        $restoStats = $restoUsers->map(function ($resto) {
            $lastOrder = $resto->restoOrders->sortByDesc('updated_at')->first();
            return [
                'name' => $resto->name,
                'last_updated' => $lastOrder ? $lastOrder->updated_at->diffForHumans() : 'Belum pernah menginput data',
            ];
        });

        return view('admin.dashboard', compact(
            'hotelCount',
            'restoCount',
            'hotelStats',
            'restoStats'
        ));
    }
}
