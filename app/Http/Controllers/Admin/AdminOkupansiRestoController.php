<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\RestoOrder;
use App\Models\Resto;

class AdminOkupansiRestoController extends Controller
{
    public function index(Request $request)
    {
        $restos = Resto::all();

        $restoId = $request->input('resto_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = RestoOrder::query();

        if ($restoId) {
            $query->where('resto_id', $restoId);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [
                Carbon::parse($startDate)->format('Y-m-d'),
                Carbon::parse($endDate)->format('Y-m-d')
            ]);
        } elseif ($startDate) {
            $query->whereDate('order_date', '>=', Carbon::parse($startDate)->format('Y-m-d'));
        } elseif ($endDate) {
            $query->whereDate('order_date', '<=', Carbon::parse($endDate)->format('Y-m-d'));
        }

        $orders = $query->get();

        $bestItem = (clone $query)->select('item_name', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('item_name')
            ->orderByDesc('total_quantity')
            ->first();

        $mostOrderType = (clone $query)->select('type_of_order', DB::raw('COUNT(*) as total_orders'))
            ->groupBy('type_of_order')
            ->orderByDesc('total_orders')
            ->first();

        $busiestHour = (clone $query)->select(DB::raw('HOUR(time_order) as hour'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy(DB::raw('HOUR(time_order)'))
            ->orderByDesc('total_orders')
            ->first();

        $busiestDay = (clone $query)->select(DB::raw('DAYNAME(order_date) as day'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy(DB::raw('DAYNAME(order_date)'))
            ->orderByDesc('total_orders')
            ->first();

        $visitorsPerMonth = (clone $query)->select(DB::raw("DATE_FORMAT(order_date, '%Y-%m') as month"), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $peakHours = (clone $query)->select(DB::raw('HOUR(time_order) as hour'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy(DB::raw('HOUR(time_order)'))
            ->orderBy(DB::raw('HOUR(time_order)'))
            ->get();

        $orderTypeDistribution = (clone $query)->select('type_of_order', DB::raw('COUNT(*) as total'))
            ->groupBy('type_of_order')
            ->get();

        $menuPopularity = (clone $query)->select('item_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('item_name')
            ->orderByDesc('total_sold')
            ->get();

        $transactionByItemType = (clone $query)->select('item_type', DB::raw('COUNT(*) as total_transactions'))
            ->groupBy('item_type')
            ->orderByDesc('total_transactions')
            ->get();

        $peakDays = (clone $query)->select(DB::raw('DATE(order_date) as full_date'))
            ->get()
            ->groupBy(function ($item) {
                return date('l', strtotime($item->full_date));
            })
            ->map(function ($group, $day) {
                return (object) [
                    'day' => $day,
                    'total' => $group->count(),
                ];
            })
            ->sortBy(function ($item) {
                $daysOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                return array_search($item->day, $daysOrder);
            })
            ->values();

        return view('admin.okupansiresto', compact(
            'startDate',
            'endDate',
            'restoId',
            'restos',
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
