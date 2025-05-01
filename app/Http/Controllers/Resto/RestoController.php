<?php

namespace App\Http\Controllers\Resto;

use Illuminate\Http\Request;
use App\Models\RestoOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestoController extends Controller
{
    public function index(Request $request)
    {
        $restoId = auth()->user()->resto_id;

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = RestoOrder::where('resto_id', $restoId);

        if ($startDate && $endDate) {
            $query->whereBetween(DB::raw('DATE(order_date)'), [$startDate, $endDate]);
        }

        // 1️⃣ Key Metrics
        $totalTransactions = $query->count();
        $totalRevenue = $query->sum(DB::raw('quantity * item_price'));
        $averageTransactionValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // 2️⃣ Line Chart – Pendapatan per bulan
        $monthlyRevenue = (clone $query)->selectRaw("DATE_FORMAT(order_date, '%Y-%m') as month, SUM(quantity * item_price) as total_revenue")
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(fn($item) => (object)[
                'month' => $item->month,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 3️⃣ Pie Chart – Metode Pembayaran
        $paymentDistribution = (clone $query)->select('transaction_type', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('transaction_type')
            ->get()
            ->map(fn($item) => (object)[
                'transaction_type' => $item->transaction_type,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 4️⃣ Pie Chart – Berdasarkan item_type
        $revenueByItemType = (clone $query)->select('item_type', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('item_type')
            ->get()
            ->map(fn($item) => (object)[
                'item_type' => $item->item_type,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 5️⃣ Bar Chart – Berdasarkan type_of_order
        $revenueByOrderType = (clone $query)->select('type_of_order', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('type_of_order')
            ->get()
            ->map(fn($item) => (object)[
                'type_of_order' => $item->type_of_order,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 6️⃣ Bar Chart – Top 5 menu paling laku
        $top5Items = (clone $query)->select('item_name', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('item_name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get()
            ->map(fn($item) => (object)[
                'item_name' => $item->item_name,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 7️⃣ Bar Chart – 5 menu paling sepi
        $least5Items = (clone $query)->select('item_name', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('item_name')
            ->orderBy('total_revenue')
            ->limit(5)
            ->get()
            ->map(fn($item) => (object)[
                'item_name' => $item->item_name,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 8️⃣ Bar Chart – Pendapatan berdasarkan penerima (received_by)
        $revenueByReceiver = (clone $query)->select('received_by', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('received_by')
            ->get()
            ->map(fn($item) => (object)[
                'received_by' => $item->received_by,
                'total_revenue' => (int) $item->total_revenue
            ]);

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
