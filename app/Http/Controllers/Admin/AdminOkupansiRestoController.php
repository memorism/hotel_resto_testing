<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\RestoOrder;
use App\Models\User;

class AdminOkupansiRestoController extends Controller
{
    public function index(Request $request)
    {
        // 🔹 Ambil semua restoran untuk dropdown filter
        $restos = User::where('usertype', 'resto')->get();

        // 🔹 Ambil filter dari request
        $restoId = $request->input('resto_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // 🔹 Query utama
        $query = RestoOrder::query();

        if ($restoId) {
            $query->where('user_id', $restoId);
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

        // Key Metrics
        $bestItem = clone $query;
        $bestItem = $bestItem->select('item_name', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('item_name')
            ->orderByDesc('total_quantity')
            ->first();

        $mostOrderType = clone $query;
        $mostOrderType = $mostOrderType->select('type_of_order', DB::raw('COUNT(*) as total_orders'))
            ->groupBy('type_of_order')
            ->orderByDesc('total_orders')
            ->first();

        $busiestHour = clone $query;
        $busiestHour = $busiestHour->select(DB::raw('HOUR(time_order) as hour'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy(DB::raw('HOUR(time_order)'))
            ->orderByDesc('total_orders')
            ->first();

        $busiestDay = clone $query;
        $busiestDay = $busiestDay->select(DB::raw('DAYNAME(order_date) as day'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy(DB::raw('DAYNAME(order_date)'))
            ->orderByDesc('total_orders')
            ->first();

        // Grafik
        $visitorsPerMonth = clone $query;
        $visitorsPerMonth = $visitorsPerMonth->select(DB::raw("DATE_FORMAT(order_date, '%Y-%m') as month"), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $peakHours = clone $query;
        $peakHours = $peakHours->select(DB::raw('HOUR(time_order) as hour'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy(DB::raw('HOUR(time_order)'))
            ->orderBy(DB::raw('HOUR(time_order)'))
            ->get();

        $orderTypeDistribution = clone $query;
        $orderTypeDistribution = $orderTypeDistribution->select('type_of_order', DB::raw('COUNT(*) as total'))
            ->groupBy('type_of_order')
            ->get();

        $menuPopularity = clone $query;
        $menuPopularity = $menuPopularity->select('item_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('item_name')
            ->orderByDesc('total_sold')
            ->get();

        $transactionByItemType = clone $query;
        $transactionByItemType = $transactionByItemType->select('item_type', DB::raw('COUNT(*) as total_transactions'))
            ->groupBy('item_type')
            ->orderByDesc('total_transactions')
            ->get();

        // Hari Tersibuk dari jumlah pengunjung (solusi baru: group by tanggal lalu map DAYNAME)
        $peakDays = clone $query;
        $peakDays = $peakDays->select(DB::raw('DATE(order_date) as full_date'))
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
