<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Keuangan Hotel') }}
            </h2>
            <a class="invisible btn btn-primary">test</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6">

                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.hotel') }}" class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Pilih Hotel:</label>
                            <select name="hotel_id"
                                class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">Semua Hotel</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
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

                <!-- Ringkasan Keuangan -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-blue-500 bg-opacity-10 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Total Pendapatan</h4>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl border border-yellow-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-yellow-500 bg-opacity-10 rounded-lg">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">RevPAR</h4>
                                <p class="text-2xl font-bold text-gray-900">Rp{{ number_format($revPAR, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-purple-500 bg-opacity-10 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">ADR</h4>
                                <p class="text-2xl font-bold text-gray-900">Rp{{ number_format($adr, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl border border-red-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-red-500 bg-opacity-10 rounded-lg">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Kerugian Pembatalan</h4>
                                <p class="text-2xl font-bold text-red-600">
                                    Rp{{ number_format($cancellationLoss, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Kamar dengan Pendapatan Tertinggi -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-semibold text-gray-900">Top Performing Rooms</h4>
                            <span class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full">Real-time
                                Data</span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipe Kamar</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah Reservasi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($roomRevenue as $roomType => $revenue)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $roomType }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $roomBookings[$roomType] ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="text-sm font-medium text-gray-900">Rp{{ number_format($revenue, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Grafik Keuangan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Pendapatan Per Bulan</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Trend</span>
                            </div>
                        </div>
                        <div class="chart-container" style="position: relative;">
                            <canvas id="monthlyRevenueChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Pendapatan Berdasarkan Segmen Pasar</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-gradient-to-r from-teal-500 to-blue-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Distribution</span>
                            </div>
                        </div>
                        <div class="chart-container" style="position: relative;">
                            <canvas id="marketSegmentRevenueChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function createChart(ctx, type, labels, data, colors, xLabel, yLabel, chartLabel) {
            const options = {
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
                        usePointStyle: true,
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                let value;
                                if (context.chart.config.type === 'pie') {
                                    value = context.parsed;
                                } else {
                                    value = context.parsed.y;
                                }
                                if (value !== null) {
                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(value);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: xLabel,
                            color: '#6b7280',
                            font: {
                                size: 12,
                                weight: '500'
                            }
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
                        title: {
                            display: true,
                            text: yLabel,
                            color: '#6b7280',
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            callback: function (value) {
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }).format(value);
                            }
                        },
                        beginAtZero: true
                    }
                }
            };

            if (type === 'pie') {
                options.plugins.legend.display = true;
                options.plugins.legend.position = 'bottom';
                options.plugins.legend.labels = {
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
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
                        borderColor: type === 'bar' ? colors : 'white',
                        borderWidth: type === 'bar' ? 0 : 2,
                        borderRadius: type === 'bar' ? 4 : 0,
                        hoverOffset: type === 'pie' ? 10 : 0
                    }]
                },
                options: options
            });
        }

        // Monthly Revenue Chart
        createChart(
            document.getElementById('monthlyRevenueChart').getContext('2d'),
            'bar',
            {!! json_encode(array_keys($monthlyRevenue)) !!},
            {!! json_encode(array_values($monthlyRevenue)) !!},
            'rgb(59, 130, 246)',
            'Bulan',
            'Pendapatan',
            'Pendapatan Per Bulan'
        );

        // Market Segment Revenue Chart
        createChart(
            document.getElementById('marketSegmentRevenueChart').getContext('2d'),
            'pie',
            {!! json_encode(array_keys($marketSegmentRevenue)) !!},
            {!! json_encode(array_values($marketSegmentRevenue)) !!},
            ['#0ea5e9', '#6366f1', '#8b5cf6', '#ec4899', '#f43f5e'],
            'Segmen Pasar',
            'Pendapatan',
            'Pendapatan Berdasarkan Segmen Pasar'
        );
    </script>

    <style>
        .chart-container {
            width: 100%;
            height: 300px;
            position: relative;
        }
    </style>
</x-app-layout>