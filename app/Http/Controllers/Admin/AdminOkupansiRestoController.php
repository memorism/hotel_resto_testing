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

        // 1️⃣ **Total Transaksi**
        $totalTransactions = $orders->count();

        // 2️⃣ **Tren Jumlah Transaksi Harian**
        $transactionTrends = $orders->groupBy('order_date')->map(fn($row) => count($row))->toArray();

        // 3️⃣ **Waktu Tersibuk (Peak Hours)**
        $peakHours = $orders->groupBy(fn($order) => Carbon::parse($order->time_order)->format('H'))
            ->map(fn($row) => count($row))
            ->sortDesc() // Sort agar nilai terbesar berada di urutan pertama
            ->toArray();

        $mostBusyHour = !empty($peakHours) ? array_key_first($peakHours) . ":00" : '-';

        // 4️⃣ **Hari Tersibuk dalam Seminggu**
        $peakDays = $orders->groupBy(fn($order) => Carbon::parse($order->order_date)->format('l'))
            ->map(fn($row) => count($row))
            ->sortDesc() // Sort agar nilai terbesar berada di urutan pertama
            ->toArray();

        $mostBusyDay = !empty($peakDays) ? array_key_first($peakDays) : '-';

        // 5️⃣ **Distribusi Jenis Pesanan (Dine-in vs Take-away)**
        $orderTypes = $orders->groupBy('type_of_order')
            ->map(fn($row) => count($row))
            ->toArray();

        // 6️⃣ **Popularitas Menu (Top 10 menu yang paling sering dipesan)**
        $menuPopularity = $orders->groupBy('item_name')
            ->map(fn($row) => $row->sum('quantity'))
            ->sortDesc()
            ->take(10)
            ->toArray();

        return view('admin.okupansiresto', compact(
            'restos',
            'totalTransactions',
            'transactionTrends',
            'peakHours',
            'mostBusyHour',
            'peakDays',
            'mostBusyDay',
            'orderTypes',
            'menuPopularity',
            'startDate',
            'endDate'
        ));
    }
}
