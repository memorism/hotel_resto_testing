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
                <form method="GET" action="{{ route('admin.okupansiresto') }}" class="mb-4">
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

                <!-- 🔹 Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Item Terlaris</h4>
                        <p class="text-lg font-bold text-indigo-800">{{ $bestItem->item_name ?? '-' }}</p>
                    </div>
                    <div class="bg-pink-50 border-l-4 border-pink-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Jenis Order Terbanyak</h4>
                        <p class="text-lg font-bold text-pink-800">{{ $mostOrderType->type_of_order ?? '-' }}</p>
                    </div>
                    <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Jam Tersibuk</h4>
                        <p class="text-lg font-bold text-orange-800">
                            {{ optional($busiestHour)->hour !== null ? optional($busiestHour)->hour . ':00' : '-' }}
                        </p>
                    </div>
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Hari Tersibuk</h4>
                        <p class="text-lg font-bold text-green-800">{{ $busiestDay->day ?? '-' }}</p>
                    </div>
                </div>

                <!-- 🔹 Grafik -->
                <style>
                    .chart-container {
                        width: 100%;
                        height: 300px;
                    }
                </style>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Jumlah Transaksi per Jenis Menu</h4>
                        <div class="chart-container">
                            <canvas id="transactionByItemTypeChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Jumlah Pengunjung per Bulan</h4>
                        <div class="chart-container">
                            <canvas id="visitorsPerMonthChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Popularitas Menu</h4>
                        <div class="chart-container">
                            <canvas id="menuPopularityChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Waktu Tersibuk</h4>
                        <div class="chart-container">
                            <canvas id="peakHoursChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Distribusi Jenis Pesanan</h4>
                        <div class="chart-container">
                            <canvas id="orderTypeChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="font-semibold mb-2">Hari Tersibuk Berdasarkan Jumlah Pengunjung</h4>
                        <div class="chart-container">
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
            function renderChart(id, type, labels, data, label, xLabel, yLabel, color) {
                const ctx = document.getElementById(id);
                if (!ctx) return;
                new Chart(ctx, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: label,
                            data: data,
                            backgroundColor: Array.isArray(color) ? color : [color],
                            borderColor: Array.isArray(color) ? color : [color],
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: type !== 'pie' ? {
                            x: { title: { display: true, text: xLabel } },
                            y: { title: { display: true, text: yLabel }, beginAtZero: true }
                        } : {},
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: { enabled: true }
                        }
                    }
                });
            }

            renderChart('transactionByItemTypeChart', 'bar',
                {!! json_encode($transactionByItemType->pluck('item_type')) !!},
                {!! json_encode($transactionByItemType->pluck('total_transactions')) !!},
                'Transaksi per Jenis Menu', 'Jenis Menu', 'Jumlah Transaksi', '#34495e');

            renderChart('visitorsPerMonthChart', 'line',
                {!! json_encode($visitorsPerMonth->pluck('month')) !!},
                {!! json_encode($visitorsPerMonth->pluck('total')) !!},
                'Jumlah Pengunjung', 'Bulan', 'Pengunjung', '#2ecc71');

            renderChart('menuPopularityChart', 'bar',
                {!! json_encode($menuPopularity->pluck('item_name')) !!},
                {!! json_encode($menuPopularity->pluck('total_sold')) !!},
                'Popularitas Menu', 'Menu', 'Jumlah Terjual', '#9b59b6');

            renderChart('peakHoursChart', 'line',
                {!! json_encode($peakHours->pluck('hour')) !!},
                {!! json_encode($peakHours->pluck('total_orders')) !!},
                'Waktu Tersibuk', 'Jam', 'Jumlah Pesanan', '#e67e22');

            renderChart('orderTypeChart', 'pie',
                {!! json_encode($orderTypeDistribution->pluck('type_of_order')) !!},
                {!! json_encode($orderTypeDistribution->pluck('total')) !!},
                'Jenis Order', '', '', ['#f39c12', '#3498db', '#1abc9c']);

            renderChart('peakDayChart', 'bar',
                {!! json_encode($peakDays->pluck('day')) !!},
                {!! json_encode($peakDays->pluck('total')) !!},
                'Hari Tersibuk', 'Hari', 'Jumlah Pengunjung', '#8e44ad');
        });
    </script>
</x-app-layout>