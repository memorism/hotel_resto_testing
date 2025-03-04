<?php

namespace App\Http\Controllers\resto;

use Illuminate\Http\Request;
use App\Models\RestoOrder;
use Carbon\Carbon;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OccupancyController extends Controller
{
    // Menampilkan data okupansi restoran
    public function index()
    {
        $userId = Auth::id(); // Hanya menampilkan data sesuai user login

        // Tren jumlah transaksi per hari
        $transactionTrends = RestoOrder::select(
            DB::raw("DATE(order_date) as date"),
            DB::raw("COUNT(id) as total_transactions")
        )
        ->where('user_id', $userId)
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        // Distribusi jenis pesanan (Dine In vs Take Away)
        $orderTypes = RestoOrder::select(
            'type_of_order',
            DB::raw("COUNT(id) as total_orders")
        )
        ->where('user_id', $userId)
        ->groupBy('type_of_order')
        ->get();

        // Popularitas menu (menu yang paling sering dipesan)
        $menuPopularity = RestoOrder::select(
            'item_name',
            DB::raw("SUM(quantity) as total_quantity")
        )
        ->where('user_id', $userId)
        ->groupBy('item_name')
        ->orderBy('total_quantity', 'desc')
        ->limit(10)
        ->get();

        // Waktu tersibuk (Peak Hours)
        $peakHours = RestoOrder::select(
            DB::raw("HOUR(time_order) as hour"),
            DB::raw("COUNT(id) as total_orders")
        )
        ->where('user_id', $userId)
        ->groupBy('hour')
        ->orderBy('hour', 'asc')
        ->get();

        // Hari tersibuk (Peak Days)
        $peakDays = RestoOrder::select(
            DB::raw("DAYNAME(order_date) as day"),
            DB::raw("COUNT(id) as total_orders")
        )
        ->where('user_id', $userId)
        ->groupBy('day')
        ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
        ->get();

        return view('resto.okupansi', compact(
            'transactionTrends', 'orderTypes', 'menuPopularity', 'peakHours', 'peakDays'
        ));
    }
}
