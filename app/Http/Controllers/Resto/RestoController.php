<?php

namespace App\Http\Controllers\Resto;

use Illuminate\Http\Request;
use App\Models\RestoOrder;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

class RestoController extends Controller
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

        // 1️⃣ Total Penjualan
        $totalSales = $query->count();

        // 2️⃣ Total Pendapatan
        $totalRevenue = $query->sum(DB::raw('quantity * item_price'));

        // 3️⃣ Rata-rata Order Value
        $averageOrderValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        // 4️⃣ Profit & Loss (Contoh: total revenue - 30% operational cost)
        $profitLoss = $totalRevenue - ($totalRevenue * 0.3);

        // 5️⃣ Target Pencapaian (Asumsikan target bulanan Rp 100 Juta)
        $targetAchievement = ($totalRevenue / 100000000) * 100;

        // 6️⃣ Tren Pendapatan Harian
        $revenueTrend = clone $query;
        $revenueTrend = $revenueTrend->select(
            DB::raw("DATE(order_date) as date"),
            DB::raw("SUM(quantity * item_price) as total_revenue")
        )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // 7️⃣ Profit & Loss Harian (Misal, 70% dari pendapatan sebagai laba bersih)
        $profitLossTrend = clone $query;
        $profitLossTrend = $profitLossTrend->select(
            DB::raw("DATE(order_date) as date"),
            DB::raw("SUM(quantity * item_price * 0.7) as profit_or_loss")
        )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // 8️⃣ Distribusi Metode Pembayaran
        $paymentMethods = clone $query;
        $paymentMethods = $paymentMethods->select(
            'transaction_type',
            DB::raw("COUNT(id) as total_payments")
        )
            ->groupBy('transaction_type')
            ->get();

        // 9️⃣ Pendapatan Berdasarkan Jenis Menu
        $revenueByItemType = clone $query;
        $revenueByItemType = $revenueByItemType->select(
            'item_type',
            DB::raw("SUM(quantity * item_price) as total_revenue")
        )
            ->groupBy('item_type')
            ->get();

        // 🔟 Biaya Operasional vs Pendapatan
        $costVsRevenue = clone $query;
        $costVsRevenue = $costVsRevenue->select(
            DB::raw("DATE(order_date) as date"),
            DB::raw("SUM(quantity * item_price) as total_revenue"),
            DB::raw("SUM(quantity * item_price * 0.3) as total_cost") // Asumsikan 30% biaya operasional
        )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('resto.dashboard', compact(
            'totalSales',
            'totalRevenue',
            'averageOrderValue',
            'profitLoss',
            'targetAchievement',
            'revenueTrend',
            'profitLossTrend',
            'paymentMethods',
            'revenueByItemType',
            'costVsRevenue',
            'startDate',
            'endDate'
        ));
    }
}
