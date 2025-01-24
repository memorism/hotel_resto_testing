<?php

namespace App\Charts;


use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class BookingChart extends Chart
{
    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk membuat chart berdasarkan kolom tertentu
    public function createChart($data, $labels, $title, $chartType = 'bar')
    {
        return $this->labels($labels)
                    ->dataset($title, $chartType, $data)
                    ->options([
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'borderWidth' => 1,
                    ]);
    }
}

