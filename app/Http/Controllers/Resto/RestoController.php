<?php

namespace App\Http\Controllers\Resto;

use App\Charts\RestoChart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RestoController extends Controller
{
    public function index()
    {
        $chart = new RestoChart();

        return view('resto.dashboard', [
            'totalSalesChart'         => $chart->totalSalesChart(),
            'itemSalesChart'          => $chart->itemSalesChart(),
            'revenueByItemTypeChart'  => $chart->revenueByItemTypeChart(),
            'orderByTransactionTypeChart' => $chart->orderByTransactionTypeChart(),
        ]);
    }
}
