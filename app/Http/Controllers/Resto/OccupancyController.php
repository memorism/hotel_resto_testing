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
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        // Ambil tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = RestoOrder::where('user_id', $userId);
        
        // Terapkan filter tanggal hanya jika tanggal diberikan
        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }
        
        // 1️⃣ Total Transaksi (Jumlah Pesanan)
        $totalTransactions = $query->count();

        // 2️⃣ Tren Jumlah Transaksi Harian (Total pesanan per hari)
        $transactionTrends = clone $query;
        $transactionTrends = $transactionTrends->select(
            DB::raw("DATE(order_date) as date"),
            DB::raw("COUNT(id) as total_transactions")
        )
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        // 3️⃣ Waktu Tersibuk (Peak Hours)
        $peakHours = clone $query;
        $peakHours = $peakHours->select(
            DB::raw("HOUR(time_order) as hour"),
            DB::raw("COUNT(id) as total_orders")
        )
        ->groupBy('hour')
        ->orderBy('hour', 'asc')
        ->get();

        // 4️⃣ Hari Tersibuk dalam Seminggu
        $peakDays = clone $query;
        $peakDays = $peakDays->select(
            DB::raw("DAYNAME(order_date) as day"),
            DB::raw("COUNT(id) as total_orders")
        )
        ->groupBy('day')
        ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
        ->get();

        // 5️⃣ Distribusi Jenis Pesanan (Dine-in vs Take-away)
        $orderTypes = clone $query;
        $orderTypes = $orderTypes->select(
            'type_of_order',
            DB::raw("COUNT(id) as total_orders")
        )
        ->groupBy('type_of_order')
        ->get();

        // 6️⃣ Popularitas Menu (Top 10 menu yang paling sering dipesan)
        $menuPopularity = clone $query;
        $menuPopularity = $menuPopularity->select(
            'item_name',
            DB::raw("SUM(quantity) as total_quantity")
        )
        ->groupBy('item_name')
        ->orderBy('total_quantity', 'desc')
        ->limit(10)
        ->get();

        return view('resto.okupansi', compact(
            'totalTransactions', 'transactionTrends', 'peakHours', 'peakDays',
            'orderTypes', 'menuPopularity', 'startDate', 'endDate'
        ));
    }
}