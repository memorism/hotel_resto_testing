@php
    $days = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
        'Sunday' => 'Minggu',
    ];

    $translatedPeakDays = $peakDays->pluck('day')->map(function ($d) use ($days) {
        return $days[$d] ?? $d;
    });
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Statistik Restaurant') }}
            </h2>
            <a class="invisible btn btn-primary">test</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <!-- 🔹 Filter Form -->
                <form method="GET" action="{{ route('admin.okupansiresto') }}" class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Pilih Restoran:</label>
                            <select name="resto_id"
                                class="w-full rounded-lg p-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">Semua Restoran</option>
                                @foreach ($restos as $resto)
                                    <option value="{{ $resto->id }}" {{ request('resto_id') == $resto->id ? 'selected' : '' }}>
                                        {{ $resto->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai:</label>
                            <input type="date" name="start_date"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Tanggal Akhir:</label>
                            <input type="date" name="end_date"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-150">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter
                                </span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- 🔹 Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl border border-indigo-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-indigo-500 bg-opacity-10 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Item Terlaris</h4>
                                <p class="text-2xl font-bold text-gray-900">{{ $bestItem->item_name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl border border-pink-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-pink-500 bg-opacity-10 rounded-lg">
                                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Jenis Order Terbanyak</h4>
                                <p class="text-2xl font-bold text-gray-900">{{ $mostOrderType->type_of_order ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-orange-500 bg-opacity-10 rounded-lg">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Jam Tersibuk</h4>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ optional($busiestHour)->hour !== null ? optional($busiestHour)->hour . ':00' : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-green-500 bg-opacity-10 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Hari Tersibuk</h4>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ isset($busiestDay->day) ? ($days[ucfirst(strtolower($busiestDay->day))] ?? $busiestDay->day) : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🔹 Grafik -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Transaksi per Jenis Menu</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Trend</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="transactionByItemTypeChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Jumlah Pengunjung per Bulan</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Trend</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="visitorsPerMonthChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Popularitas Menu</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-purple-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Distribution</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="menuPopularityChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Waktu Tersibuk</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Trend</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="peakHoursChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Distribusi Jenis Pesanan</h4>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                                    <span class="text-sm text-gray-500">Distribution</span>
                                </div>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="orderTypeChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Hari Tersibuk</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-purple-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Hari</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="peakDayChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1f2937',
                        bodyColor: '#1f2937',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        usePointStyle: true
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            }
                        },
                        beginAtZero: true
                    }
                }
            };

            function createChart(ctx, type, labels, data, colors, xLabel, yLabel, chartLabel) {
                const options = { ...chartOptions };

                if (type === 'pie') {
                    options.plugins.legend.display = true;
                    options.plugins.legend.position = 'bottom';
                    options.plugins.legend.labels = {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        color: '#6b7280',
                        font: {
                            size: 12
                        }
                    };
                    delete options.scales;
                }

                return new Chart(ctx, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: chartLabel,
                            data: data,
                            backgroundColor: Array.isArray(colors) ? colors : [colors],
                            borderColor: type === 'line' ? colors : 'white',
                            borderWidth: type === 'line' ? 2 : 1,
                            borderRadius: type === 'bar' ? 4 : 0,
                            tension: type === 'line' ? 0.3 : 0,
                            fill: type === 'line' ? 'origin' : undefined,
                            hoverOffset: type === 'pie' ? 10 : 0
                        }]
                    },
                    options: options
                });
            }

            // Transaction by Item Type Chart
            createChart(
                document.getElementById('transactionByItemTypeChart').getContext('2d'),
                'bar',
                {!! json_encode($transactionByItemType->pluck('item_type')) !!},
                {!! json_encode($transactionByItemType->pluck('total_transactions')) !!},
                'rgba(59, 130, 246, 0.7)',
                'Jenis Menu',
                'Jumlah Transaksi',
                'Transaksi per Jenis Menu'
            );

            // Visitors per Month Chart
            createChart(
                document.getElementById('visitorsPerMonthChart').getContext('2d'),
                'line',
                {!! json_encode($visitorsPerMonth->pluck('month')) !!},
                {!! json_encode($visitorsPerMonth->pluck('total')) !!},
                'rgba(16, 185, 129, 0.7)',
                'Bulan',
                'Jumlah Pengunjung',
                'Pengunjung per Bulan'
            );

            // Menu Popularity Chart
            createChart(
                document.getElementById('menuPopularityChart').getContext('2d'),
                'bar',
                {!! json_encode($menuPopularity->pluck('item_name')) !!},
                {!! json_encode($menuPopularity->pluck('total_sold')) !!},
                'rgba(139, 92, 246, 0.7)',
                'Menu',
                'Jumlah Terjual',
                'Popularitas Menu'
            );

            // Peak Hours Chart
            createChart(
                document.getElementById('peakHoursChart').getContext('2d'),
                'line',
                {!! json_encode($peakHours->pluck('hour')) !!},
                {!! json_encode($peakHours->pluck('total_orders')) !!},
                'rgba(249, 115, 22, 0.7)',
                'Jam',
                'Jumlah Pesanan',
                'Waktu Tersibuk'
            );

            // Order Type Distribution Chart
            createChart(
                document.getElementById('orderTypeChart').getContext('2d'),
                'pie',
                {!! json_encode($orderTypeDistribution->pluck('type_of_order')) !!},
                {!! json_encode($orderTypeDistribution->pluck('total')) !!},
                ['rgba(245, 158, 11, 0.7)', 'rgba(59, 130, 246, 0.7)', 'rgba(16, 185, 129, 0.7)'],
                '',
                '',
                'Distribusi Jenis Pesanan'
            );

            // Peak Day Chart
            createChart(
                document.getElementById('peakDayChart').getContext('2d'),
                'bar',
                {!! json_encode($translatedPeakDays) !!},
                {!! json_encode($peakDays->pluck('total')) !!},
                'rgba(139, 92, 246, 0.7)',
                'Hari',
                'Jumlah Pengunjung',
                'Hari Tersibuk'
            );
        });
    </script>
</x-app-layout>