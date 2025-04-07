<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Keuangan Restoran') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <!-- 🔹 Filter Form -->
                <form method="GET" action="{{ route('admin.resto') }}" class="mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-gray-700">Pilih Restoran:</label>
                            <select name="resto_id" class="w-full p-2 border rounded">
                                <option value="">Semua Restoran</option>
                                @foreach ($restos as $resto)
                                    <option value="{{ $resto->id }}" {{ request('resto_id') == $resto->id ? 'selected' : '' }}>
                                        {{ $resto->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Total Transaksi</h4>
                        <p class="text-2xl font-bold text-blue-800">{{ number_format($totalTransactions ?? 0) }}</p>
                    </div>
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Total Pendapatan</h4>
                        <p class="text-2xl font-bold text-green-800">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Rata-rata Pembelian</h4>
                        <p class="text-2xl font-bold text-yellow-800">Rp {{ number_format($averageTransactionValue ?? 0, 0, ',', '.') }}</p>
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
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Pendapatan per Bulan</h4>
                        <div class="chart-container">
                        <canvas id="monthlyRevenueChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Metode Pembayaran</h4>
                        <div class="chart-container">
                        <canvas id="paymentDistributionChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Pendapatan per Item Type</h4>
                        <div class="chart-container">
                        <canvas id="revenueByItemTypeChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Pendapatan per Tipe Order</h4>
                        <div class="chart-container">
                        <canvas id="revenueByOrderTypeChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Top 5 Menu Terlaris</h4>
                        <div class="chart-container">
                        <canvas id="top5ItemsChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Top 5 Menu Paling Jarang Dibeli</h4>
                        <div class="chart-container">
                        <canvas id="least5ItemsChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Pendapatan Berdasarkan Penerima Order</h4>
                        <div class="chart-container">
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
                            x: { title: { display: true, text: xLabel } },
                            y: {
                                beginAtZero: true,
                                stepSize: step,
                                title: { display: true, text: yLabel },
                                ticks: {
                                    callback: value => 'Rp ' + value.toLocaleString('id-ID')
                                }
                            }
                        },
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: { enabled: true }
                        }
                    }
                });
            }

            renderChart(
                'monthlyRevenueChart', 'line',
                {!! json_encode($monthlyRevenue->pluck('month')) !!},
                {!! json_encode($monthlyRevenue->pluck('total_revenue')->map(fn($v) => (int)$v)) !!},
                'Pendapatan per Bulan', 'Bulan', 'Pendapatan', '#2ecc71'
            );

            renderChart(
                'paymentDistributionChart', 'pie',
                {!! json_encode($paymentDistribution->pluck('transaction_type')) !!},
                {!! json_encode($paymentDistribution->pluck('total_revenue')->map(fn($v) => (int)$v)) !!},
                'Metode Pembayaran', '', '', ['#f39c12', '#3498db', '#9b59b6']
            );

            renderChart(
                'revenueByItemTypeChart', 'pie',
                {!! json_encode($revenueByItemType->pluck('item_type')) !!},
                {!! json_encode($revenueByItemType->pluck('total_revenue')->map(fn($v) => (int)$v)) !!},
                'Pendapatan per Item Type', '', '', ['#9b59b6', '#1abc9c', '#34495e']
            );

            renderChart(
                'revenueByOrderTypeChart', 'bar',
                {!! json_encode($revenueByOrderType->pluck('type_of_order')) !!},
                {!! json_encode($revenueByOrderType->pluck('total_revenue')->map(fn($v) => (int)$v)) !!},
                'Pendapatan per Tipe Order', 'Tipe Order', 'Pendapatan', '#3498db'
            );

            renderChart(
                'top5ItemsChart', 'bar',
                {!! json_encode($top5Items->pluck('item_name')) !!},
                {!! json_encode($top5Items->pluck('total_revenue')->map(fn($v) => (int)$v)) !!},
                'Top 5 Menu Terlaris', 'Menu', 'Pendapatan', '#1abc9c'
            );

            renderChart(
                'least5ItemsChart', 'bar',
                {!! json_encode($least5Items->pluck('item_name')) !!},
                {!! json_encode($least5Items->pluck('total_revenue')->map(fn($v) => (int)$v)) !!},
                'Top 5 Menu Paling Jarang Dibeli', 'Menu', 'Pendapatan', '#e74c3c'
            );

            renderChart(
                'revenueByReceiverChart', 'bar',
                {!! json_encode($revenueByReceiver->pluck('received_by')) !!},
                {!! json_encode($revenueByReceiver->pluck('total_revenue')->map(fn($v) => (int)$v)) !!},
                'Pendapatan Berdasarkan Penerima Order', 'Penerima', 'Pendapatan', '#8e44ad'
            );
        });
    </script>
</x-app-layout>