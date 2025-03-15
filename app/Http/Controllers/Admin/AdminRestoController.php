<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\RestoOrder;
use App\Models\User;
use App\Http\Controllers\Controller;
use DB;

class AdminRestoController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $restoId = $request->input('resto_id');

        $query = RestoOrder::query();

        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        if ($restoId) {
            $query->where('user_id', $restoId);
        }

        $orders = $query->get();

        // 1️⃣ Total Penjualan
        $totalSales = $orders->count();

        // 2️⃣ Total Pendapatan
        $totalRevenue = $orders->sum(fn($order) => $order->quantity * $order->item_price);

        // 3️⃣ Rata-rata Order Value
        $averageOrderValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        // 4️⃣ Profit & Loss (30% biaya operasional)
        $profitLoss = $totalRevenue - ($totalRevenue * 0.3);

        // 5️⃣ Target Pencapaian (Target: Rp 100 Juta per bulan)
        $targetAchievement = ($totalRevenue / 100000000) * 100;

        // 6️⃣ Pendapatan Harian (Gunakan order_date)
        $revenueTrend = $query->select(
            DB::raw("DATE(order_date) as order_date"),
            DB::raw("SUM(quantity * item_price) as total_revenue")
        )->groupBy('order_date')->orderBy('order_date', 'asc')->get();

        // 7️⃣ Profit & Loss Harian (Gunakan order_date)
        $profitLossTrend = $query->select(
            DB::raw("DATE(order_date) as order_date"),
            DB::raw("SUM(quantity * item_price * 0.7) as profit_or_loss")
        )->groupBy('order_date')->orderBy('order_date', 'asc')->get();

        // 8️⃣ Distribusi Metode Pembayaran (Jangan gunakan `groupBy(date)`)
        $paymentMethods = RestoOrder::select(
            'transaction_type',
            DB::raw("SUM(quantity) as total_payments") // 🔹 Pastikan jumlah dihitung dengan benar
        )
            ->whereNotNull('transaction_type') // 🔹 Pastikan hanya data valid yang diambil
            ->whereBetween('order_date', [$startDate ?? '1888-01-01', $endDate ?? now()]) // ✅ Pastikan filter tanggal
            ->when($restoId, function ($q) use ($restoId) {
                return $q->where('user_id', $restoId);
            })
            ->groupBy('transaction_type')
            ->orderByDesc(DB::raw("SUM(quantity)")) // 🔹 Urutkan dari transaksi terbanyak
            ->get();

        // 9️⃣ Pendapatan Berdasarkan Jenis Menu
        $revenueByItemType = $query->select(
            'item_name',
            DB::raw("SUM(quantity * item_price) as total_revenue")
        )->groupBy('item_name')->get();

        // 🔟 Biaya Operasional vs Pendapatan (Gunakan order_date)
        $costVsRevenue = $query->select(
            DB::raw("DATE(order_date) as order_date"),
            DB::raw("SUM(quantity * item_price) as total_revenue"),
            DB::raw("SUM(quantity * item_price * 0.3) as total_cost")
        )->groupBy('order_date')->orderBy('order_date', 'asc')->get();

        // Daftar restoran untuk filter
        $restos = User::where('usertype', 'resto')->get();

        return view('admin.resto', compact(
            'restos',
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
            'endDate',
            'restoId'
        ));
    }
}
