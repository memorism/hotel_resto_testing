<?php

namespace App\Http\Controllers\Resto;

use Illuminate\Http\Request;
use App\Models\RestoOrder;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

class RestoController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1️⃣ Total Penjualan
        $totalSales = RestoOrder::where('user_id', $userId)->count();

        // 2️⃣ Total Pendapatan
        $totalRevenue = RestoOrder::where('user_id', $userId)
            ->sum(DB::raw('quantity * item_price'));

        // 3️⃣ Rata-rata Order Value
        $averageOrderValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        // 4️⃣ Profit & Loss (Contoh: total revenue - 30% operational cost)
        $profitLoss = $totalRevenue - ($totalRevenue * 0.3);

        // 5️⃣ Target Pencapaian (Asumsikan target bulanan Rp 100 Juta)
        $targetAchievement = ($totalRevenue / 100000000) * 100;

        // 6️⃣ Tren Pendapatan Harian
        $revenueTrend = RestoOrder::select(
            DB::raw("DATE(order_date) as date"),
            DB::raw("SUM(quantity * item_price) as total_revenue")
        )
        ->where('user_id', $userId)
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        // 7️⃣ Profit & Loss Harian (Misal, 70% dari pendapatan sebagai laba bersih)
        $profitLossTrend = RestoOrder::select(
            DB::raw("DATE(order_date) as date"),
            DB::raw("SUM(quantity * item_price * 0.7) as profit_or_loss")
        )
        ->where('user_id', $userId)
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        // 8️⃣ Distribusi Metode Pembayaran
        $paymentMethods = RestoOrder::select(
            'transaction_type',
            DB::raw("COUNT(id) as total_payments")
        )
        ->where('user_id', $userId)
        ->groupBy('transaction_type')
        ->get();

        // 9️⃣ Pendapatan Berdasarkan Jenis Menu
        $revenueByItemType = RestoOrder::select(
            'item_type',
            DB::raw("SUM(quantity * item_price) as total_revenue")
        )
        ->where('user_id', $userId)
        ->groupBy('item_type')
        ->get();

        // 🔟 Biaya Operasional vs Pendapatan
        $costVsRevenue = RestoOrder::select(
            DB::raw("DATE(order_date) as date"),
            DB::raw("SUM(quantity * item_price) as total_revenue"),
            DB::raw("SUM(quantity * item_price * 0.3) as total_cost") // Asumsikan 30% biaya operasional
        )
        ->where('user_id', $userId)
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        return view('resto.dashboard', compact(
            'totalSales', 'totalRevenue', 'averageOrderValue', 'profitLoss', 'targetAchievement',
            'revenueTrend', 'profitLossTrend', 'paymentMethods', 'revenueByItemType', 'costVsRevenue'
        ));
    }
}
