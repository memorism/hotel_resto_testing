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
        $hotelCount = Hotel::count();
        $restoCount = Resto::count();

        // Ambil semua hotel & resto
        $hotels = Hotel::with([
            'bookings' => function ($q) {
                $q->orderByDesc('updated_at');
            }
        ])->get();

        $restos = Resto::with([
            'orders' => function ($q) {
                $q->orderByDesc('updated_at');
            }
        ])->get();

        // Statistik per hotel
        $hotelStats = $hotels->map(function ($hotel) {
            $lastBooking = $hotel->bookings->first(); // Sudah terurut descending
            return [
                'name' => $hotel->name,
                'last_updated' => $lastBooking ? $lastBooking->updated_at->diffForHumans() : 'Belum pernah menginput data',
            ];
        });

        // Statistik per resto
        $restoStats = $restos->map(function ($resto) {
            $lastOrder = $resto->orders->first(); // Sudah terurut descending
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
