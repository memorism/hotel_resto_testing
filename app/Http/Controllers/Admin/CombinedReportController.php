<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CombinedReport;
use App\Models\Hotel;
use App\Models\Resto;

class CombinedReportController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $combinedSearch = $request->input('combined_search');
        $showZeroIncome = $request->boolean('show_zero_income');
        $perPage = $request->input('per_page', 10);
        $sort = $request->input('sort', 'tanggal');
        $direction = $request->input('direction', 'desc');

        $query = CombinedReport::query();

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($combinedSearch) {
            $query->where(function ($q) use ($combinedSearch) {
                $q->whereHas('hotel', function ($hotelQ) use ($combinedSearch) {
                    $hotelQ->where('name', 'like', '%' . $combinedSearch . '%');
                })->orWhereHas('resto', function ($restoQ) use ($combinedSearch) {
                    $restoQ->where('name', 'like', '%' . $combinedSearch . '%');
                });
            });
        }

        if (!$showZeroIncome) {
            $query->where(function ($q) {
                $q->where('total_income', '>', 0)
                    ->orWhere('total_expense', '>', 0);
            });
        }

        // Validate sort column
        $allowedSortColumns = ['tanggal', 'hotel_id', 'resto_id', 'total_income', 'total_expense', 'net_profit'];
        if (!in_array($sort, $allowedSortColumns)) {
            $sort = 'tanggal';
        }

        // Validate direction
        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        // Handle sorting for related models
        if ($sort === 'hotel_id') {
            $query->join('hotels', 'combined_reports.hotel_id', '=', 'hotels.id')
                ->orderBy('hotels.name', $direction)
                ->select('combined_reports.*');
        } elseif ($sort === 'resto_id') {
            $query->join('restos', 'combined_reports.resto_id', '=', 'restos.id')
                ->orderBy('restos.name', $direction)
                ->select('combined_reports.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        // Handle "semua" for per_page
        $perPage = ($perPage === 'semua') ? $query->count() : (int) $perPage;

        // // Debug output
        // $sql = $query->toSql();
        // $bindings = $query->getBindings();
        // $fullQuery = str_replace(
        //     array_map(function ($binding) {
        //         return is_string($binding) ? "'" . $binding . "'" : $binding;
        //     }, $bindings),
        //     array_fill(0, count($bindings), '?'),
        //     $sql
        // );
        // dd([
        //     'sql' => $sql,
        //     'bindings' => $bindings,
        //     'full_query' => $fullQuery
        // ]);

        $reports = $query->with(['hotel', 'resto'])
            ->paginate($perPage)
            ->appends($request->all());

        return view('admin.combined_reports.index', compact('reports'));
    }

}

