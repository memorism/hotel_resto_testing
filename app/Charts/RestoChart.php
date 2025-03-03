<?php

namespace App\Charts;

use App\Models\RestoOrder;
use Illuminate\Support\Facades\Auth;

class RestoChart
{
    // 📊 1. Total Penjualan per Hari
    public function totalSalesChart($userId = null)
    {
        // Gunakan user_id yang diberikan atau default ke Auth::id()
        $userId = $userId ?? Auth::id();

        $salesData = RestoOrder::where('user_id', $userId)
            ->selectRaw('order_date, SUM(transaction_amount) as total_sales')
            ->groupBy('order_date')
            ->orderBy('order_date', 'ASC')
            ->get();

        return [
            'labels' => $salesData->pluck('order_date')->toArray(),
            'data' => $salesData->pluck('total_sales')->toArray(),
        ];
    }

    // 📊 2. Jumlah Pesanan per Item
    public function itemSalesChart($userId = null)
    {
        // Gunakan user_id yang diberikan atau default ke Auth::id()
        $userId = $userId ?? Auth::id();

        $items = RestoOrder::where('user_id', $userId)
            ->selectRaw('item_name, COUNT(*) as total_orders')
            ->groupBy('item_name')
            ->orderBy('total_orders', 'DESC')
            ->get();

        return [
            'labels' => $items->pluck('item_name')->toArray(),
            'data' => $items->pluck('total_orders')->toArray(),
        ];
    }

    // 📊 3. Total Pendapatan per Tipe Item
    public function revenueByItemTypeChart($userId = null)
    {
        // Gunakan user_id yang diberikan atau default ke Auth::id()
        $userId = $userId ?? Auth::id();

        $revenueData = RestoOrder::where('user_id', $userId)
            ->selectRaw('item_type, SUM(transaction_amount) as total_revenue')
            ->groupBy('item_type')
            ->orderBy('total_revenue', 'DESC')
            ->get();

        return [
            'labels' => $revenueData->pluck('item_type')->toArray(),
            'data' => $revenueData->pluck('total_revenue')->toArray(),
        ];
    }

    // 📊 4. Jumlah Pesanan per Jenis Transaksi
    public function orderByTransactionTypeChart($userId = null)
    {
        // Gunakan user_id yang diberikan atau default ke Auth::id()
        $userId = $userId ?? Auth::id();

        $orderData = RestoOrder::where('user_id', $userId)
            ->selectRaw('transaction_type, COUNT(*) as total_orders')
            ->groupBy('transaction_type')
            ->orderBy('total_orders', 'DESC')
            ->get();

        return [
            'labels' => $orderData->pluck('transaction_type')->toArray(),
            'data' => $orderData->pluck('total_orders')->toArray(),
        ];
    }
}
