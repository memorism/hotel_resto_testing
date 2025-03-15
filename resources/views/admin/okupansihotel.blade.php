<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Okupansi Hotel') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <!-- 🔹 Filter Form -->
                <form method="GET" action="{{ route('admin.okupansihotel') }}" class="mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-gray-700">Pilih Hotel:</label>
                            <select name="hotel_id" class="w-full p-2 border rounded">
                                <option value="">Semua Hotel</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
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
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-white">
                    <div class="bg-blue-500 p-4 rounded-lg">
                        <h5>Total Reservasi</h5>
                        <p class="text-2xl">{{ number_format($totalReservations) }}</p>
                    </div>
                    <div class="bg-green-500 p-4 rounded-lg">
                        <h5>Rata-rata Lama Menginap</h5>
                        <p class="text-2xl">{{ number_format($averageStay, 1) }} Malam</p>
                    </div>
                    <div class="bg-yellow-500 p-4 rounded-lg">
                        <h5>Persentase Okupansi</h5>
                        <p class="text-2xl">{{ number_format($occupancyRate, 2) }}%</p>
                    </div>
                    <div class="bg-red-500 p-4 rounded-lg">
                        <h5>Rasio Pembatalan</h5>
                        <p class="text-2xl">{{ number_format($cancellationRate, 2) }}%</p>
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
                        <h4 class="text-md font-semibold mb-2">Persentase Okupansi per Bulan</h4>
                        <div class="chart-container">
                            <canvas id="occupancyChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Distribusi Tipe Kamar</h4>
                        <div class="chart-container">
                            <canvas id="roomChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Segmentasi Pasar</h4>
                        <div class="chart-container">
                            <canvas id="marketSegmentChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Rasio Pembatalan per Bulan</h4>
                        <div class="chart-container">
                            <canvas id="cancellationChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Tren Okupansi per Tanggal</h4>
                        <div class="chart-container">
                        <canvas id="dailyOccupancyChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Rata-rata Lama Menginap per Bulan</h4>
                        <div class="chart-container">
                        <canvas id="avgStayChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Total Reservasi per Bulan</h4>
                        <div class="chart-container">
                        <canvas id="monthlyOccupancyChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Total Malam Menginap (Weekday vs Weekend)</h4>
                        <div class="chart-container">
                        <canvas id="stayDurationChart"></canvas>
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
                if (!ctx || labels.length === 0 || data.length === 0) {
                    console.log(chartLabel + ' tidak memiliki data, tidak ditampilkan.');
                    return;
                }
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
    
            // 🔹 Okupansi per Bulan
            createChart(
                document.getElementById('occupancyChart')?.getContext('2d'),
                'line',
                {!! json_encode(array_keys($occupancyRatePerMonth ?? [])) !!},
                {!! json_encode(array_values($occupancyRatePerMonth ?? [])) !!},
                ['#2ecc71'], 'Bulan', 'Persentase Okupansi', 'Persentase Okupansi per Bulan'
            );
    
            // 🔹 Distribusi Tipe Kamar
            createChart(
                document.getElementById('roomChart')?.getContext('2d'),
                'bar',
                {!! json_encode(array_keys($roomTypeDistribution ?? [])) !!},
                {!! json_encode(array_values($roomTypeDistribution ?? [])) !!},
                ['#3498db'], 'Tipe Kamar', 'Jumlah Reservasi', 'Distribusi Tipe Kamar'
            );
    
            // 🔹 Segmentasi Pasar
            createChart(
                document.getElementById('marketSegmentChart')?.getContext('2d'),
                'pie',
                {!! json_encode(array_keys($topMarketSegments ?? [])) !!},
                {!! json_encode(array_values($topMarketSegments ?? [])) !!},
                ['#f39c12', '#e74c3c', '#9b59b6'],
                'Segmentasi Pasar', 'Jumlah Reservasi', 'Segmentasi Pasar'
            );
    
            // 🔹 Rasio Pembatalan per Bulan
            createChart(
                document.getElementById('cancellationChart')?.getContext('2d'),
                'bar',
                {!! json_encode(array_keys($cancellationRatio ?? [])) !!},
                {!! json_encode(array_values($cancellationRatio ?? [])) !!},
                ['#e74c3c'], 'Bulan', 'Rasio Pembatalan', 'Rasio Pembatalan per Bulan'
            );
    
            // 🔹 Tren Okupansi per Tanggal
            createChart(
                document.getElementById('dailyOccupancyChart')?.getContext('2d'),
                'line',
                {!! json_encode(array_keys($weekdayOccupancy ?? [])) !!},
                {!! json_encode(array_values($weekdayOccupancy ?? [])) !!},
                ['#1abc9c'], 'Tanggal', 'Jumlah Reservasi', 'Tren Okupansi Harian'
            );
    
            // 🔹 Rata-rata Lama Menginap per Bulan
            createChart(
                document.getElementById('avgStayChart')?.getContext('2d'),
                'bar',
                {!! json_encode(array_keys($avgStayPerMonth ?? [])) !!},
                {!! json_encode(array_values($avgStayPerMonth ?? [])) !!},
                ['#9b59b6'], 'Bulan', 'Rata-rata Lama Menginap', 'Rata-rata Lama Menginap per Bulan'
            );
    
            // 🔹 Total Reservasi per Bulan
            createChart(
                document.getElementById('monthlyOccupancyChart')?.getContext('2d'),
                'bar',
                {!! json_encode(array_keys($monthlyOccupancy ?? [])) !!},
                {!! json_encode(array_values($monthlyOccupancy ?? [])) !!},
                ['#f1c40f'], 'Bulan', 'Total Reservasi', 'Total Reservasi per Bulan'
            );
    
            // 🔹 Total Malam Menginap (Weekday vs Weekend)
            createChart(
                document.getElementById('stayDurationChart')?.getContext('2d'),
                'bar',
                ['Weekday', 'Weekend'],
                [{!! json_encode($totalWeekNights ?? 0) !!}, {!! json_encode($totalWeekendNights ?? 0) !!}],
                ['#2ecc71', '#e67e22'],
                'Jenis Malam', 'Total Malam Menginap', 'Total Malam Menginap'
            );
        });
    </script>
    

</x-app-layout>