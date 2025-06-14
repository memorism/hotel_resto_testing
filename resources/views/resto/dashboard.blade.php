<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __(' Dashboard Keuangan Restoran') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <!-- 🔹 Filter Form -->
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('resto.dashboard') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label for="status" class="block text-sm font-medium text-gray-700">
                                    Status Approval
                                </label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <select name="status" id="status"
                                        class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm bg-white"
                                        onchange="this.form.submit()">
                                        <option value="">Semua</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Disetujui</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Menunggu</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Tanggal Mulai
                                </label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="date" name="start_date"
                                        class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                        value="{{ request('start_date') }}" onchange="this.form.submit()">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Tanggal Akhir
                                </label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="date" name="end_date"
                                        class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                        value="{{ request('end_date') }}" onchange="this.form.submit()">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-6">
                    <!-- 🔹 Ringkasan Keuangan -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-blue-600">Total Transaksi</p>
                                    <p class="text-2xl font-bold text-blue-900 mt-2">
                                        {{ number_format($totalTransactions ?? 0) }}</p>
                                </div>
                                <div class="bg-blue-500/10 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-600">Total Pendapatan</p>
                                    <p class="text-2xl font-bold text-green-900 mt-2">Rp
                                        {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="bg-green-500/10 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl border border-yellow-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-yellow-600">Rata-rata Pembelian</p>
                                    <p class="text-2xl font-bold text-yellow-900 mt-2">Rp
                                        {{ number_format($averageTransactionValue ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="bg-yellow-500/10 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 🔹 Grafik Keuangan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan per Bulan</h4>
                            <div class="h-[300px]">
                                <canvas id="monthlyRevenueChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Metode Pembayaran</h4>
                            <div class="h-[300px]">
                                <canvas id="paymentDistributionChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan per Item Type</h4>
                            <div class="h-[300px]">
                                <canvas id="revenueByItemTypeChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan per Tipe Order</h4>
                            <div class="h-[300px]">
                                <canvas id="revenueByOrderTypeChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Top 5 Menu Terlaris</h4>
                            <div class="h-[300px]">
                                <canvas id="top5ItemsChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Top 5 Menu Paling Jarang Dibeli</h4>
                            <div class="h-[300px]">
                                <canvas id="least5ItemsChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan Berdasarkan Penerima Order
                            </h4>
                            <div class="h-[300px]">
                                <canvas id="revenueByReceiverChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function renderChart(id, type, labels, data, label, xLabel, yLabel, colors) {
                const ctx = document.getElementById(id);
                if (!ctx) return;
                const maxY = Math.max(...data);
                const step = Math.ceil(maxY / 5 / 1000) * 1000 || 1000;

                new Chart(ctx.getContext('2d'), {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: label,
                            data: data,
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: type === 'pie' ? {} : {
                            x: {
                                title: {
                                    display: true,
                                    text: xLabel,
                                    font: {
                                        size: 12,
                                        weight: 'medium'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                stepSize: step,
                                title: {
                                    display: true,
                                    text: yLabel,
                                    font: {
                                        size: 12,
                                        weight: 'medium'
                                    }
                                },
                                ticks: {
                                    callback: value => 'Rp ' + value.toLocaleString('id-ID')
                                },
                                grid: {
                                    color: '#e2e8f0'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 12,
                                        weight: 'medium'
                                    },
                                    padding: 20
                                }
                            },
                            tooltip: {
                                enabled: true,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: {
                                    size: 13,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 12
                                },
                                padding: 12,
                                cornerRadius: 8
                            }
                        }
                    }
                });
            }

            // Chart Colors
            const chartColors = {
                blue: ['#3b82f6', '#60a5fa', '#93c5fd'],
                green: ['#10b981', '#34d399', '#6ee7b7'],
                yellow: ['#f59e0b', '#fbbf24', '#fcd34d'],
                purple: ['#8b5cf6', '#a78bfa', '#c4b5fd'],
                red: ['#ef4444', '#f87171', '#fca5a5'],
                indigo: ['#6366f1', '#818cf8', '#a5b4fc']
            };

            renderChart(
                'monthlyRevenueChart', 'line',
                {!! json_encode($monthlyRevenue->pluck('month')) !!},
                {!! json_encode($monthlyRevenue->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'Pendapatan per Bulan', 'Bulan', 'Pendapatan',
                chartColors.blue[0]
            );

            renderChart(
                'paymentDistributionChart', 'pie',
                {!! json_encode($paymentDistribution->pluck('transaction_type')) !!},
                {!! json_encode($paymentDistribution->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'Metode Pembayaran', '', '',
                [chartColors.green[0], chartColors.blue[0], chartColors.purple[0]]
            );

            renderChart(
                'revenueByItemTypeChart', 'pie',
                {!! json_encode($revenueByItemType->pluck('item_type')) !!},
                {!! json_encode($revenueByItemType->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'Pendapatan per Item Type', '', '',
                [chartColors.yellow[0], chartColors.indigo[0], chartColors.red[0]]
            );

            renderChart(
                'revenueByOrderTypeChart', 'bar',
                {!! json_encode($revenueByOrderType->pluck('type_of_order')) !!},
                {!! json_encode($revenueByOrderType->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'Pendapatan per Tipe Order', 'Tipe Order', 'Pendapatan',
                chartColors.blue[1]
            );

            renderChart(
                'top5ItemsChart', 'bar',
                {!! json_encode($top5Items->pluck('item_name')) !!},
                {!! json_encode($top5Items->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'Top 5 Menu Terlaris', 'Menu', 'Pendapatan',
                chartColors.green[1]
            );

            renderChart(
                'least5ItemsChart', 'bar',
                {!! json_encode($least5Items->pluck('item_name')) !!},
                {!! json_encode($least5Items->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'Top 5 Menu Paling Jarang Dibeli', 'Menu', 'Pendapatan',
                chartColors.red[1]
            );

            renderChart(
                'revenueByReceiverChart', 'bar',
                {!! json_encode($revenueByReceiver->pluck('received_by')) !!},
                {!! json_encode($revenueByReceiver->pluck('total_revenue')->map(fn($v) => (int) $v)) !!},
                'Pendapatan Berdasarkan Penerima Order', 'Penerima', 'Pendapatan',
                chartColors.purple[1]
            );
        });
    </script>
</x-app-layout>