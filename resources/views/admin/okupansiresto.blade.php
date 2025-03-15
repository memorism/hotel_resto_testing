<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Okupansi Restoran') }}
        </h2>
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
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 text-white">
                    <div class="bg-blue-500 p-4 rounded-lg">
                        <h5>Total Transaksi</h5>
                        <p class="text-2xl">{{ number_format($totalTransactions) }}</p>
                    </div>
                    <div class="bg-green-500 p-4 rounded-lg">
                        <h5>Waktu Tersibuk</h5>
                        <p class="text-2xl">{{ $mostBusyHour }}</p>
                    </div>
                    <div class="bg-yellow-500 p-4 rounded-lg">
                        <h5>Hari Tersibuk</h5>
                        <p class="text-2xl">{{ $mostBusyDay }}</p>
                    </div>
                    {{-- <div class="bg-red-500 p-4 rounded-lg">
                        <h5>Jenis Pesanan Terbanyak</h5>
                        <p class="text-2xl">{{ !empty($orderTypes) ? array_key_first($orderTypes) : '-' }}</p>
                    </div> --}}
                    <div class="bg-purple-500 p-4 rounded-lg">
                        <h5>Menu Favorit</h5>
                        <p class="text-2xl">{{ !empty($menuPopularity) ? array_key_first($menuPopularity) : '-' }}</p>
                    </div>
                </div>

                <!-- 🔹 Semua Grafik -->
                <style>
                    .chart-container {
                        width: 100%;
                        height: 300px;
                        /* Menetapkan tinggi tetap untuk grafik */
                    }
                </style>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Tren Transaksi Harian</h4>
                        <div class="chart-container">
                            <canvas id="transactionTrendChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Waktu Tersibuk (Peak Hours)</h4>
                        <div class="chart-container">
                            <canvas id="peakHoursChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Hari Tersibuk</h4>
                        <div class="chart-container">
                            <canvas id="peakDaysChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Distribusi Jenis Pesanan</h4>
                        <div class="chart-container">
                            <canvas id="orderTypesChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Popularitas Menu</h4>
                        <div class="chart-container">
                            <canvas id="menuChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function createChart(ctx, type, labels, data, colors, xLabel, yLabel, chartLabel) {
                if (!ctx) return;
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

            createChart(document.getElementById('transactionTrendChart').getContext('2d'), 'line',
                {!! json_encode(array_keys($transactionTrends)) !!},
                {!! json_encode(array_values($transactionTrends)) !!},
                ['#3498db'], 'Tanggal', 'Jumlah Transaksi', 'Tren Transaksi Harian'
            );

            createChart(document.getElementById('peakHoursChart').getContext('2d'), 'bar',
                {!! json_encode(array_keys($peakHours)) !!},
                {!! json_encode(array_values($peakHours)) !!},
                ['#e67e22'], 'Jam', 'Jumlah Transaksi', 'Waktu Tersibuk'
            );

            createChart(document.getElementById('peakDaysChart').getContext('2d'), 'bar',
                {!! json_encode(array_keys($peakDays)) !!},
                {!! json_encode(array_values($peakDays)) !!},
                ['#9b59b6'], 'Hari', 'Jumlah Transaksi', 'Hari Tersibuk'
            );

            createChart(document.getElementById('orderTypesChart').getContext('2d'), 'pie',
                {!! json_encode(array_keys($orderTypes)) !!},
                {!! json_encode(array_values($orderTypes)) !!},
                ['#f39c12', '#3498db', '#9b59b6'],
                'Jenis Pesanan', 'Jumlah Transaksi', 'Distribusi Jenis Pesanan'
            );

            createChart(document.getElementById('menuChart').getContext('2d'), 'bar',
                {!! json_encode(array_keys($menuPopularity)) !!},
                {!! json_encode(array_values($menuPopularity)) !!},
                ['#1abc9c'], 'Menu', 'Jumlah Pesanan', 'Popularitas Menu'
            );
        });
    </script>

</x-app-layout>