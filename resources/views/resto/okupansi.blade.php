<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __(' Statistik Restoran') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <!-- 🔹 Filter Form -->
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                            <label for="start_date" class="block text-sm font-medium text-gray-700">
                                Dari Tanggal
                            </label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" name="start_date" id="start_date"
                                    class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                    value="{{ request('start_date') }}" onchange="this.form.submit()">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">
                                Sampai Tanggal
                            </label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" name="end_date" id="end_date"
                                    class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                    value="{{ request('end_date') }}" onchange="this.form.submit()">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-6">
                    <!-- 🔹 Key Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div
                            class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl border border-indigo-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-indigo-600">Item Terlaris</p>
                                    <p class="text-2xl font-bold text-indigo-900 mt-2">{{ $bestItem->item_name ?? '-' }}
                                    </p>
                                </div>
                                <div class="bg-indigo-500/10 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl border border-pink-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-pink-600">Jenis Order Terbanyak</p>
                                    <p class="text-2xl font-bold text-pink-900 mt-2">
                                        {{ $mostOrderType->type_of_order ?? '-' }}</p>
                                </div>
                                <div class="bg-pink-500/10 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-orange-600">Jam Tersibuk</p>
                                    <p class="text-2xl font-bold text-orange-900 mt-2">
                                        {{ $busiestHour->hour !== null ? $busiestHour->hour . ':00' : '-' }}</p>
                                </div>
                                <div class="bg-orange-500/10 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-600">Hari Tersibuk</p>
                                    <p class="text-2xl font-bold text-green-900 mt-2">{{ $busiestDay->day ?? '-' }}</p>
                                </div>
                                <div class="bg-green-500/10 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 🔹 Grafik -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Jumlah Transaksi per Jenis Menu</h4>
                            <div class="h-[300px]">
                                <canvas id="transactionByItemTypeChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Jumlah Pengunjung per Bulan</h4>
                            <div class="h-[300px]">
                                <canvas id="visitorsPerMonthChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Popularitas Menu</h4>
                            <div class="h-[300px]">
                                <canvas id="menuPopularityChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Waktu Tersibuk</h4>
                            <div class="h-[300px]">
                                <canvas id="peakHoursChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Jenis Pesanan</h4>
                            <div class="h-[300px]">
                                <canvas id="orderTypeChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Hari Tersibuk Berdasarkan Jumlah
                                Pengunjung</h4>
                            <div class="h-[300px]">
                                <canvas id="peakDayChart"></canvas>
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
                new Chart(ctx, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: label,
                            data: data,
                            backgroundColor: Array.isArray(colors) ? colors : colors,
                            borderColor: Array.isArray(colors) ? colors : colors,
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
                                title: {
                                    display: true,
                                    text: yLabel,
                                    font: {
                                        size: 12,
                                        weight: 'medium'
                                    }
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
                indigo: ['#6366f1', '#818cf8', '#a5b4fc'],
                pink: ['#ec4899', '#f472b6', '#fbcfe8'],
                orange: ['#f97316', '#fb923c', '#fdba74'],
                green: ['#22c55e', '#4ade80', '#86efac'],
                blue: ['#3b82f6', '#60a5fa', '#93c5fd'],
                purple: ['#8b5cf6', '#a78bfa', '#c4b5fd']
            };

            renderChart(
                'transactionByItemTypeChart', 'bar',
                {!! json_encode($transactionByItemType->pluck('item_type')) !!},
                {!! json_encode($transactionByItemType->pluck('total_transactions')) !!},
                'Transaksi per Jenis Menu', 'Jenis Menu', 'Jumlah Transaksi',
                chartColors.indigo[0]
            );

            renderChart(
                'visitorsPerMonthChart', 'line',
                {!! json_encode($visitorsPerMonth->pluck('month')) !!},
                {!! json_encode($visitorsPerMonth->pluck('total')) !!},
                'Jumlah Pengunjung', 'Bulan', 'Pengunjung',
                chartColors.green[0]
            );

            renderChart(
                'menuPopularityChart', 'bar',
                {!! json_encode($menuPopularity->pluck('item_name')) !!},
                {!! json_encode($menuPopularity->pluck('total_sold')) !!},
                'Popularitas Menu', 'Menu', 'Jumlah Terjual',
                chartColors.purple[0]
            );

            renderChart(
                'peakHoursChart', 'line',
                {!! json_encode($peakHours->pluck('hour')) !!},
                {!! json_encode($peakHours->pluck('total_orders')) !!},
                'Waktu Tersibuk', 'Jam', 'Jumlah Pesanan',
                chartColors.orange[0]
            );

            renderChart(
                'orderTypeChart', 'pie',
                {!! json_encode($orderTypeDistribution->pluck('type_of_order')) !!},
                {!! json_encode($orderTypeDistribution->pluck('total')) !!},
                'Jenis Order', '', '',
                [chartColors.blue[0], chartColors.green[0], chartColors.purple[0]]
            );

            renderChart(
                'peakDayChart', 'bar',
                {!! json_encode($peakDays->pluck('day')) !!},
                {!! json_encode($peakDays->pluck('total')) !!},
                'Hari Tersibuk', 'Hari', 'Jumlah Pengunjung',
                chartColors.pink[0]
            );
        });
    </script>
</x-app-layout>