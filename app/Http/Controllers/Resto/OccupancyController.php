<?php

namespace App\Http\Controllers\Resto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RestoOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OccupancyController extends Controller
{
    private function getFilteredQuery($restoId, $startDate, $endDate, $status)
    {
        return RestoOrder::where('resto_id', $restoId)
            ->when($status, fn($q) => $q->where('approval_status', $status))
            ->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween(DB::raw('DATE(order_date)'), [$startDate, $endDate]);
            });
    }

    public function index(Request $request)
    {
        $restoId = auth()->user()->resto_id;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $baseQuery = $this->getFilteredQuery($restoId, $startDate, $endDate, $status);

        // 🔍 Key Metrics
        $bestItem = (clone $baseQuery)->select('item_name', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('item_name')
            ->orderByDesc('total_quantity')
            ->first();

        $mostOrderType = (clone $baseQuery)->select('type_of_order', DB::raw('COUNT(*) as total_orders'))
            ->groupBy('type_of_order')
            ->orderByDesc('total_orders')
            ->first();

        $busiestHour = (clone $baseQuery)
            ->select(DB::raw('HOUR(time_order) as hour'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy(DB::raw('HOUR(time_order)'))
            ->orderByDesc('total_orders')
            ->first() ?? (object) ['hour' => null];


        $busiestDay = (clone $baseQuery)->select(DB::raw('DAYNAME(order_date) as day'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy(DB::raw('DAYNAME(order_date)'))
            ->orderByDesc('total_orders')
            ->first();

        // 📊 Grafik
        $visitorsPerMonth = (clone $baseQuery)
            ->select(DB::raw("DATE_FORMAT(order_date, '%Y-%m') as month"), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $peakHours = (clone $baseQuery)
            ->select(DB::raw('HOUR(time_order) as hour'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy(DB::raw('HOUR(time_order)'))
            ->orderBy(DB::raw('HOUR(time_order)'))
            ->get();

        $orderTypeDistribution = (clone $baseQuery)
            ->select('type_of_order', DB::raw('COUNT(*) as total'))
            ->groupBy('type_of_order')
            ->get();

        $menuPopularity = (clone $baseQuery)
            ->select('item_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('item_name')
            ->orderByDesc('total_sold')
            ->get();

        $transactionByItemType = (clone $baseQuery)
            ->select('item_type', DB::raw('COUNT(*) as total_transactions'))
            ->groupBy('item_type')
            ->orderByDesc('total_transactions')
            ->get();

        $peakDays = (clone $baseQuery)
            ->select(DB::raw('DATE(order_date) as full_date'))
            ->get()
            ->groupBy(fn($item) => date('l', strtotime($item->full_date)))
            ->map(fn($group, $day) => (object) [
                'day' => $day,
                'total' => $group->count(),
            ])
            ->sortBy(fn($item) => array_search($item->day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']))
            ->values();

        return view('resto.okupansi', compact(
            'startDate',
            'endDate',
            'bestItem',
            'mostOrderType',
            'busiestHour',
            'busiestDay',
            'visitorsPerMonth',
            'peakHours',
            'orderTypeDistribution',
            'menuPopularity',
            'transactionByItemType',
            'peakDays'
        ));
    }

}
