<?php

namespace App\Http\Controllers\Resto;

use Illuminate\Http\Request;
use App\Models\RestoOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestoController extends Controller
{
    private function getFilteredQuery($restoId, $startDate, $endDate, $status = null)
    {
        return RestoOrder::where('resto_id', $restoId)
            ->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween(DB::raw('DATE(order_date)'), [$startDate, $endDate]);
            })
            ->when($status, function ($q) use ($status) {
                $q->where('approval_status', $status);
            });
    }


    public function index(Request $request)
    {
        $restoId = auth()->user()->resto_id;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');


        $baseQuery = $this->getFilteredQuery($restoId, $startDate, $endDate, $status);

        // 1️⃣ Key Metrics
        $totalTransactions = (clone $baseQuery)->count();
        $totalRevenue = (clone $baseQuery)->sum(DB::raw('quantity * item_price'));
        $averageTransactionValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // 2️⃣ Monthly Revenue
        $monthlyRevenue = (clone $baseQuery)
            ->selectRaw("DATE_FORMAT(order_date, '%Y-%m') as month, SUM(quantity * item_price) as total_revenue")
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(fn($item) => (object) [
                'month' => $item->month,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 3️⃣ Payment Method
        $paymentDistribution = (clone $baseQuery)
            ->select('transaction_type', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('transaction_type')
            ->get()
            ->map(fn($item) => (object) [
                'transaction_type' => $item->transaction_type,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 4️⃣ Item Type
        $revenueByItemType = (clone $baseQuery)
            ->select('item_type', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('item_type')
            ->get()
            ->map(fn($item) => (object) [
                'item_type' => $item->item_type,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 5️⃣ Order Type
        $revenueByOrderType = (clone $baseQuery)
            ->select('type_of_order', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('type_of_order')
            ->get()
            ->map(fn($item) => (object) [
                'type_of_order' => $item->type_of_order,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 6️⃣ Top 5 Items
        $top5Items = (clone $baseQuery)
            ->select('item_name', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('item_name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get()
            ->map(fn($item) => (object) [
                'item_name' => $item->item_name,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 7️⃣ Least 5 Items
        $least5Items = (clone $baseQuery)
            ->select('item_name', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('item_name')
            ->orderBy('total_revenue')
            ->limit(5)
            ->get()
            ->map(fn($item) => (object) [
                'item_name' => $item->item_name,
                'total_revenue' => (int) $item->total_revenue
            ]);

        // 8️⃣ By Receiver
        $revenueByReceiver = (clone $baseQuery)
            ->select('received_by', DB::raw('SUM(quantity * item_price) as total_revenue'))
            ->groupBy('received_by')
            ->get()
            ->map(fn($item) => (object) [
                'received_by' => match (strtolower($item->received_by)) {
                    'l', 'laki-laki' => 'Pria',
                    'p', 'perempuan' => 'Wanita',
                    default => $item->received_by ?? 'Tidak Diketahui',
                },
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
            'revenueByReceiver',
            'status',
        ));
    }

}
