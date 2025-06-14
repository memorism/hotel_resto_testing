<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Okupansi Hotel') }}
            </h2>
            <a class="invisible btn btn-primary">test</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6">

                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.okupansihotel') }}" class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Pilih Hotel:</label>
                            <select name="hotel_id"
                                class="w-full rounded-lg p-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
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

                <!-- Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl border border-indigo-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-indigo-500 bg-opacity-10 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Total Reservasi</h4>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalReservations }}</p>
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
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Rata-rata Lama Menginap</h4>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($averageStay, 2) }} <span
                                        class="text-sm text-gray-500">Malam</span></p>
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
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Persentase Okupansi</h4>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($occupancyRate, 2) }}<span
                                        class="text-sm text-gray-500">%</span></p>
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
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Rasio Pembatalan</h4>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ number_format($cancellationRate, 2) }}<span
                                        class="text-sm text-gray-500">%</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Semua Grafik -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Tren Harian</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Trend</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="weekdayOccupancyChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Rata-rata Lama Menginap per Bulan</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Average</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="avgStayChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Segmentasi Pasar</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Distribution</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="segmentChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Tipe Kamar Terisi</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Distribution</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="roomTypeDistribution"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Okupansi per Bulan (%)</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Monthly</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="monthlyOccupancy"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Rasio Pembatalan & Pemesanan</h4>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                    <span class="text-xs text-gray-500">Pemesanan</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                    <span class="text-xs text-gray-500">Pembatalan</span>
                                </div>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="multiAxisChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Hari Kerja vs Akhir Pekan</h4>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-teal-500 rounded-full"></span>
                                    <span class="text-xs text-gray-500">Hari Kerja</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                                    <span class="text-xs text-gray-500">Akhir Pekan</span>
                                </div>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="stayDurationTrend"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
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

        // Grafik Okupansi Berdasarkan Hari Kedatangan
        createChart(
            document.getElementById('weekdayOccupancyChart').getContext('2d'),
            'line',
            {!! json_encode(array_keys($weekdayOccupancy)) !!},
            {!! json_encode(array_values($weekdayOccupancy)) !!},
            'rgba(59, 130, 246, 0.5)',
            'Tanggal',
            'Jumlah Reservasi',
            'Jumlah Reservasi'
        );

        // Grafik Rata-rata Lama Menginap per Bulan
        createChart(
            document.getElementById('avgStayChart').getContext('2d'),
            'bar',
            {!! json_encode(array_keys($avgStayPerMonth)) !!},
            {!! json_encode(array_values($avgStayPerMonth)) !!},
            'rgba(16, 185, 129, 0.7)',
            'Bulan',
            'Rata-rata Malam',
            'Rata-rata Lama Menginap'
        );

        // Grafik Okupansi Berdasarkan Segmentasi Pasar
        createChart(
            document.getElementById('segmentChart').getContext('2d'),
            'pie',
            {!! json_encode(array_keys($topMarketSegments)) !!},
            {!! json_encode(array_values($topMarketSegments)) !!},
            ['#ec4899', '#8b5cf6', '#6366f1', '#0ea5e9', '#10b981'],
            'Segmentasi Pasar',
            'Jumlah Reservasi',
            'Segmentasi Pasar'
        );

        // Grafik Okupansi Berdasarkan Tipe Kamar
        createChart(
            document.getElementById('roomTypeDistribution').getContext('2d'),
            'bar',
            {!! json_encode(array_keys($roomTypeDistributionData)) !!},
            {!! json_encode(array_values($roomTypeDistributionData)) !!},
            ['#0ea5e9', '#6366f1', '#8b5cf6', '#ec4899'],
            'Tipe Kamar',
            'Jumlah Reservasi',
            'Distribusi Tipe Kamar'
        );

        // Grafik Okupansi per Bulan
        createChart(
            document.getElementById('monthlyOccupancy').getContext('2d'),
            'line',
            {!! json_encode(array_keys($avgStayPerMonth)) !!},
            {!! json_encode(array_values($monthlyOccupancy)) !!},
            'rgba(59, 130, 246, 0.5)',
            'Bulan',
            'Okupansi (%)',
            'Okupansi Bulanan'
        );

        // Grafik Multi-Axis
        new Chart(document.getElementById('multiAxisChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($occupancyRatePerMonth)) !!},
                datasets: [
                    {
                        label: 'Rasio Pemesanan (%)',
                        data: {!! json_encode(array_values($occupancyRatePerMonth)) !!},
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderWidth: 2,
                        type: 'line',
                        yAxisID: 'y',
                        tension: 0.3
                    },
                    {
                        label: 'Rasio Pembatalan (%)',
                        data: {!! json_encode(array_values($cancellationRatio)) !!},
                        type: 'line',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        backgroundColor: 'rgba(239, 68, 68, 0.5)',
                        borderWidth: 2,
                        yAxisID: 'y',
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
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
                        position: 'left',
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
                    },
                    // y1: {
                    //     position: 'right',
                    //     grid: {
                    //         display: false
                    //     },
                    //     ticks: {
                    //         color: '#6b7280',
                    //         font: {
                    //             size: 12
                    //         }
                    //     },
                    //     beginAtZero: true
                    // }
                }
            }
        });

        // Grafik Hari Kerja vs Akhir Pekan
        new Chart(document.getElementById('stayDurationTrend').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Hari Biasa', 'Akhir Pekan'],
                datasets: [{
                    label: 'Jumlah Malam Menginap',
                    data: {!! json_encode([$totalWeekNights, $totalWeekendNights]) !!},
                    backgroundColor: ['rgba(20, 184, 166, 0.7)', 'rgba(249, 115, 22, 0.7)'],
                    borderColor: ['rgba(20, 184, 166, 1)', 'rgba(249, 115, 22, 1)'],
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
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
            }
        });
    </script>
</x-app-layout>