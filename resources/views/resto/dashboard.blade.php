<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Finance Restoran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- 🔹 Filter Form -->
                <form method="GET" action="{{ route('resto.dashboard') }}" class="mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700">Tanggal Mulai:</label>
                            <input type="date" name="start_date" class="w-full p-2 border rounded"
                                value="{{ request('start_date') }}">
                        </div>
                        <div>
                            <label class="block text-gray-700">Tanggal Akhir:</label>
                            <input type="date" name="end_date" class="w-full p-2 border rounded"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>

                <!-- 🔹 Ringkasan Keuangan -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                    <div class="bg-blue-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Total Penjualan</h4>
                        <p class="text-2xl font-bold">{{ number_format($totalSales) }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Total Pendapatan</h4>
                        <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Rata-rata Order Value</h4>
                        <p class="text-2xl font-bold">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-red-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Profit / Loss</h4>
                        <p class="text-2xl font-bold">Rp {{ number_format($profitLoss, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Target Pencapaian</h4>
                        <p class="text-2xl font-bold">{{ number_format($targetAchievement, 2) }}%</p>
                    </div>
                </div>

                <!-- 🔹 Grafik Keuangan -->
                <style>
                    .chart-container {
                        width: 100%;
                        height: 300px;
                    }
                </style>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Tren Pendapatan Harian</h4>
                        @if(count($revenueTrend) > 0)
                            <div class="chart-container">
                                <canvas id="revenueTrendChart"></canvas>
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada data pendapatan tersedia.</p>
                        @endif
                    </div>

                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Profit & Loss</h4>
                        @if(count($profitLossTrend) > 0)
                            <div class="chart-container">
                                <canvas id="profitLossChart"></canvas>
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada data Profit & Loss tersedia.</p>
                        @endif
                    </div>

                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Distribusi Metode Pembayaran</h4>
                        @if(count($paymentMethods) > 0)
                            <div class="chart-container">
                                <canvas id="paymentMethodChart"></canvas>
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada data metode pembayaran.</p>
                        @endif
                    </div>

                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Pendapatan Berdasarkan Jenis Menu</h4>
                        @if(count($revenueByItemType) > 0)
                            <div class="chart-container">
                                <canvas id="revenueByItemTypeChart"></canvas>
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada data pendapatan per jenis menu.</p>
                        @endif
                    </div>

                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Biaya Operasional vs Pendapatan</h4>
                        @if(count($costVsRevenue) > 0)
                            <div class="chart-container">
                                <canvas id="costVsRevenueChart"></canvas>
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada data biaya operasional.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function createChart(ctx, type, labels, data, colors, xLabel, yLabel, chartLabel) {
                if (!ctx) return; // Cegah error jika canvas tidak ditemukan
                return new Chart(ctx, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: chartLabel,
                            data: data,
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { title: { display: true, text: xLabel } },
                            y: { title: { display: true, text: yLabel } }
                        }
                    }
                });
            }

            @if(count($revenueTrend) > 0)
                createChart(
                    document.getElementById('revenueTrendChart').getContext('2d'),
                    'line',
                    {!! json_encode($revenueTrend->pluck('date')->toArray()) !!},
                    {!! json_encode($revenueTrend->pluck('total_revenue')->toArray()) !!},
                    ['#2ecc71'], 'Tanggal', 'Total Pendapatan', 'Tren Pendapatan'
                );
            @endif

            @if(count($profitLossTrend) > 0)
                createChart(
                    document.getElementById('profitLossChart').getContext('2d'),
                    'bar',
                    {!! json_encode($profitLossTrend->pluck('date')->toArray()) !!},
                    {!! json_encode($profitLossTrend->pluck('profit_or_loss')->toArray()) !!},
                    ['#e74c3c'], 'Tanggal', 'Profit / Loss', 'Profit & Loss Harian'
                );
            @endif

            @if(count($paymentMethods) > 0)
                createChart(
                    document.getElementById('paymentMethodChart').getContext('2d'),
                    'pie',
                    {!! json_encode($paymentMethods->pluck('transaction_type')->toArray()) !!},
                    {!! json_encode($paymentMethods->pluck('total_payments')->toArray()) !!},
                    ['#f39c12', '#3498db', '#9b59b6'],
                    'Metode Pembayaran', 'Jumlah Transaksi', 'Distribusi Metode Pembayaran'
                );
            @endif

            @if(count($revenueByItemType) > 0)
                createChart(
                    document.getElementById('revenueByItemTypeChart').getContext('2d'),
                    'bar',
                    {!! json_encode($revenueByItemType->pluck('item_type')->toArray()) !!},
                    {!! json_encode($revenueByItemType->pluck('total_revenue')->toArray()) !!},
                    ['#9b59b6'], 'Jenis Item', 'Pendapatan (Rp)', 'Pendapatan Berdasarkan Jenis Menu'
                );
            @endif

            @if(count($costVsRevenue) > 0)
                createChart(
                    document.getElementById('costVsRevenueChart').getContext('2d'),
                    'bar',
                    {!! json_encode($costVsRevenue->pluck('date')->toArray()) !!},
                    {!! json_encode($costVsRevenue->pluck('total_cost')->toArray()) !!},
                    ['#e67e22'], 'Tanggal', 'Biaya Operasional (Rp)', 'Biaya Operasional vs Pendapatan'
                );
            @endif
        });
    </script>

</x-app-layout>