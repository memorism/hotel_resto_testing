<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\RestoOrder;
use App\Models\Resto;
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

        // Gunakan resto_id, bukan user_id
        if ($restoId) {
            $query->where('resto_id', $restoId);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        $orders = $query->get();

        // Key Metrics
        $totalTransactions = $orders->count();
        $totalRevenue = $orders->sum(fn($order) => $order->quantity * $order->item_price);
        $averageTransactionValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // Line Chart – Pendapatan per bulan
        $monthlyRevenue = $orders->groupBy(function ($order) {
            return date('Y-m', strtotime($order->order_date));
        })->map(function ($group) {
            return [
                'month' => $group->first()->order_date ? date('Y-m', strtotime($group->first()->order_date)) : '',
                'total_revenue' => $group->sum(fn($o) => $o->quantity * $o->item_price),
            ];
        })->values()->sortBy('month')->values();

        // Pie Chart – Metode Pembayaran
        $paymentDistribution = $orders->groupBy('transaction_type')->map(function ($group, $key) {
            return [
                'transaction_type' => $key,
                'total_revenue' => $group->sum(fn($o) => $o->quantity * $o->item_price),
            ];
        })->values();

        // Pie Chart – Berdasarkan item_type
        $revenueByItemType = $orders->groupBy('item_type')->map(function ($group, $key) {
            return [
                'item_type' => $key,
                'total_revenue' => $group->sum(fn($o) => $o->quantity * $o->item_price),
            ];
        })->values();

        // Bar Chart – Berdasarkan type_of_order
        $revenueByOrderType = $orders->groupBy('type_of_order')->map(function ($group, $key) {
            return [
                'type_of_order' => $key,
                'total_revenue' => $group->sum(fn($o) => $o->quantity * $o->item_price),
            ];
        })->values();

        // Bar Chart – Top 5 menu paling banyak dibeli
        $top5Items = $orders->groupBy('item_name')->map(function ($group, $key) {
            return [
                'item_name' => $key,
                'total_revenue' => $group->sum(fn($o) => $o->quantity * $o->item_price),
            ];
        })->sortByDesc('total_revenue')->take(5)->values();

        // Bar Chart – Top 5 menu paling jarang dibeli
        $least5Items = $orders->groupBy('item_name')->map(function ($group, $key) {
            return [
                'item_name' => $key,
                'total_revenue' => $group->sum(fn($o) => $o->quantity * $o->item_price),
            ];
        })->sortBy('total_revenue')->take(5)->values();

        // Bar Chart – Berdasarkan received_by
        $revenueByReceiver = $orders->groupBy('received_by')->map(function ($group, $key) {
            return [
                'received_by' => $key,
                'total_revenue' => $group->sum(fn($o) => $o->quantity * $o->item_price),
            ];
        })->values();

        $restos = Resto::all();

        return view('admin.resto', compact(
            'startDate',
            'endDate',
            'totalTransactions',
            'totalRevenue',
            'averageTransactionValue',
            'monthlyRevenue',
            'paymentDistribution',
            'revenueByItemType',
            'revenueByOrderType',
            'top5Items',
            'least5Items',
            'revenueByReceiver',
            'restoId',
            'restos'
        ));
    }
}
