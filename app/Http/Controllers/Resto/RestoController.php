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

        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        // Key Metrics
        $totalTransactions = $query->count();
        $totalRevenue = $query->sum(DB::raw('quantity * item_price'));
        $averageTransactionValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // Line Chart – Pendapatan per bulan
        $monthlyRevenue = clone $query;
        $monthlyRevenue = $monthlyRevenue->selectRaw("DATE_FORMAT(order_date, '%Y-%m') as month, SUM(quantity * item_price) as total_revenue")
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $item->total_revenue = (int) $item->total_revenue;
                return $item;
            });

        // Pie Chart – Metode Pembayaran
        $paymentDistribution = clone $query;
        $paymentDistribution = $paymentDistribution->select('transaction_type', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('transaction_type')
            ->get()
            ->map(function ($item) {
                $item->total_revenue = (int) $item->total_revenue;
                return $item;
            });

        // Pie Chart – Berdasarkan item_type
        $revenueByItemType = clone $query;
        $revenueByItemType = $revenueByItemType->select('item_type', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('item_type')
            ->get()
            ->map(function ($item) {
                $item->total_revenue = (int) $item->total_revenue;
                return $item;
            });

        // Bar Chart – Berdasarkan type_of_order
        $revenueByOrderType = clone $query;
        $revenueByOrderType = $revenueByOrderType->select('type_of_order', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('type_of_order')
            ->get()
            ->map(function ($item) {
                $item->total_revenue = (int) $item->total_revenue;
                return $item;
            });

        // Bar Chart – Top 5 menu paling banyak dibeli
        $top5Items = clone $query;
        $top5Items = $top5Items->select('item_name', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('item_name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // Bar Chart – Top 5 menu paling jarang dibeli
        $least5Items = clone $query;
        $least5Items = $least5Items->select('item_name', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('item_name')
            ->orderBy('total_revenue')
            ->limit(5)
            ->get();

        // Bar Chart – Berdasarkan received_by
        $revenueByReceiver = clone $query;
        $revenueByReceiver = $revenueByReceiver->select('received_by', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('received_by')
            ->get();

        return view('resto.dashboard', compact(
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
            'revenueByReceiver'
        ));
    }
}
