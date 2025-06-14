<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Keuangan Restaurant') }}
            </h2>
            <a class="invisible btn btn-primary">test</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <!-- 🔹 Filter Form -->
                <form method="GET" action="{{ route('admin.resto') }}" class="mb-8">
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-blue-500 bg-opacity-10 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Total Transaksi</h4>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalTransactions ?? 0) }}
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
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Total Pendapatan</h4>
                                <p class="text-2xl font-bold text-gray-900">Rp
                                    {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
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
                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Rata-rata Pembelian</h4>
                                <p class="text-2xl font-bold text-gray-900">Rp
                                    {{ number_format($averageTransactionValue ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🔹 Grafik Keuangan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Pendapatan per Bulan</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Trend</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="monthlyRevenueChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Metode Pembayaran</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Distribution</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="paymentDistributionChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Pendapatan per Item Type</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-purple-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Distribution</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="revenueByItemTypeChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Pendapatan per Tipe Order</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Distribution</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="revenueByOrderTypeChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Top 5 Menu Terlaris</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-teal-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Top Items</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="top5ItemsChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Top 5 Menu Paling Jarang Dibeli</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Bottom Items</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="least5ItemsChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Pendapatan Berdasarkan Penerima Order</h4>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-purple-500 rounded-full"></span>
                                <span class="text-sm text-gray-500">Staff</span>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="revenueByReceiverChart"></canvas>
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

            // Monthly Revenue Chart
            createChart(
                document.getElementById('monthlyRevenueChart').getContext('2d'),
                'line',
                {!! json_encode($monthlyRevenue->pluck('month')) !!},
                {!! json_encode($monthlyRevenue->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'rgba(16, 185, 129, 0.7)',
                'Bulan',
                'Pendapatan',
                'Pendapatan per Bulan'
            );

            // Payment Distribution Chart
            createChart(
                document.getElementById('paymentDistributionChart').getContext('2d'),
                'pie',
                {!! json_encode($paymentDistribution->pluck('transaction_type')) !!},
                {!! json_encode($paymentDistribution->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                ['rgba(245, 158, 11, 0.7)', 'rgba(59, 130, 246, 0.7)', 'rgba(16, 185, 129, 0.7)'],
                '',
                '',
                'Metode Pembayaran'
            );

            // Revenue by Item Type Chart
            createChart(
                document.getElementById('revenueByItemTypeChart').getContext('2d'),
                'pie',
                {!! json_encode($revenueByItemType->pluck('item_type')) !!},
                {!! json_encode($revenueByItemType->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                ['rgba(139, 92, 246, 0.7)', 'rgba(16, 185, 129, 0.7)', 'rgba(59, 130, 246, 0.7)'],
                '',
                '',
                'Pendapatan per Item Type'
            );

            // Revenue by Order Type Chart
            createChart(
                document.getElementById('revenueByOrderTypeChart').getContext('2d'),
                'bar',
                {!! json_encode($revenueByOrderType->pluck('type_of_order')) !!},
                {!! json_encode($revenueByOrderType->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'rgba(59, 130, 246, 0.7)',
                'Tipe Order',
                'Pendapatan',
                'Pendapatan per Tipe Order'
            );

            // Top 5 Items Chart
            createChart(
                document.getElementById('top5ItemsChart').getContext('2d'),
                'bar',
                {!! json_encode($top5Items->pluck('item_name')) !!},
                {!! json_encode($top5Items->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'rgba(20, 184, 166, 0.7)',
                'Menu',
                'Pendapatan',
                'Top 5 Menu Terlaris'
            );

            // Least 5 Items Chart
            createChart(
                document.getElementById('least5ItemsChart').getContext('2d'),
                'bar',
                {!! json_encode($least5Items->pluck('item_name')) !!},
                {!! json_encode($least5Items->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'rgba(239, 68, 68, 0.7)',
                'Menu',
                'Pendapatan',
                'Top 5 Menu Paling Jarang Dibeli'
            );

            // Revenue by Receiver Chart
            createChart(
                document.getElementById('revenueByReceiverChart').getContext('2d'),
                'bar',
                {!! json_encode($revenueByReceiver->pluck('received_by')) !!},
                {!! json_encode($revenueByReceiver->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'rgba(139, 92, 246, 0.7)',
                'Penerima',
                'Pendapatan',
                'Pendapatan Berdasarkan Penerima Order'
            );
        });
    </script>
</x-app-layout>