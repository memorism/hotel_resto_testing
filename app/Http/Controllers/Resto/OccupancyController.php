<?php

namespace App\Http\Controllers\Resto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use App\Models\RestoOrder;

class OccupancyController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1️⃣ Total Transaksi (Jumlah Pesanan)
        $totalTransactions = RestoOrder::where('user_id', $userId)->count();

        // 2️⃣ Tren Jumlah Transaksi Harian (Total pesanan per hari)
        $transactionTrends = RestoOrder::select(
            DB::raw("DATE(order_date) as date"),
            DB::raw("COUNT(id) as total_transactions")
        )
        ->where('user_id', $userId)
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        // 3️⃣ Waktu Tersibuk (Peak Hours)
        $peakHours = RestoOrder::select(
            DB::raw("HOUR(time_order) as hour"),
            DB::raw("COUNT(id) as total_orders")
        )
        ->where('user_id', $userId)
        ->groupBy('hour')
        ->orderBy('hour', 'asc')
        ->get();

        // 4️⃣ Hari Tersibuk dalam Seminggu
        $peakDays = RestoOrder::select(
            DB::raw("DAYNAME(order_date) as day"),
            DB::raw("COUNT(id) as total_orders")
        )
        ->where('user_id', $userId)
        ->groupBy('day')
        ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
        ->get();

        // 5️⃣ Distribusi Jenis Pesanan (Dine-in vs Take-away)
        $orderTypes = RestoOrder::select(
            'type_of_order',
            DB::raw("COUNT(id) as total_orders")
        )
        ->where('user_id', $userId)
        ->groupBy('type_of_order')
        ->get();

        // 6️⃣ Popularitas Menu (Top 10 menu yang paling sering dipesan)
        $menuPopularity = RestoOrder::select(
            'item_name',
            DB::raw("SUM(quantity) as total_quantity")
        )
        ->where('user_id', $userId)
        ->groupBy('item_name')
        ->orderBy('total_quantity', 'desc')
        ->limit(10)
        ->get();

        // 7️⃣ Persentase Pembatalan Order
        // $cancellationRate = RestoOrder::select(
        //     DB::raw("SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) / COUNT(id) * 100 as cancellation_rate")
        // )
        // ->where('user_id', $userId)
        // ->first();

        return view('resto.okupansi', compact(
            'totalTransactions', 'transactionTrends', 'peakHours', 'peakDays',
            'orderTypes', 'menuPopularity', 
        ));
    }
}
