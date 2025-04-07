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
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-blue-100 p-4 rounded-lg text-center">
                        <h4 class="text-sm font-semibold text-gray-800">Total Reservasi</h4>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalReservations }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg text-center">
                        <h4 class="text-sm font-semibold text-gray-800">Rata-rata Lama Menginap</h4>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($averageStay, 2) }} Malam</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg text-center">
                        <h4 class="text-sm font-semibold text-gray-800">Persentase Okupansi</h4>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($occupancyRate, 2) }}%</p>
                    </div>
                    <div class="bg-red-100 p-4 rounded-lg text-center">
                        <h4 class="text-sm font-semibold text-gray-800">Rasio Pembatalan</h4>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($cancellationRate, 2) }}%</p>
                    </div>
                </div>

                <!-- 🔹 Semua Grafik -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Tren Harian</h4>
                        <div class="h-64">
                            <canvas id="weekdayOccupancyChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Rata-rata Lama Menginap per Bulan</h4>
                        <div class="h-64">
                            <canvas id="avgStayChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Segmentasi Pasar</h4>
                        <div class="h-64">
                            <canvas id="segmentChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Tipe Kamar Terisi</h4>
                        <div class="h-64">
                            <canvas id="roomTypeDistribution"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Tingkat Okupansi & Jumlah Booking per Bulan</h4>
                        <div class="h-64">
                            <canvas id="ratioCancel"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Okupansi per Bulan (%)</h4>
                        <div class="h-64">
                            <canvas id="monthlyOccupancy"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Rasio Pembatalan & Pemesanan</h4>
                        <div class="h-64">
                            <canvas id="multiAxisChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Hari Kerja vs Akhir Pekan</h4>
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
        function createChart(ctx, type, labels, data, colors, xLabel, yLabel, chartLabel) {
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
                    aspectRatio: 2, // Menjaga proporsi agar tidak terlalu tinggi
                    scales: {
                        x: { title: { display: true, text: xLabel } },
                        y: { title: { display: true, text: yLabel } }
                    }
                }
            });
        }

        // Grafik 1️⃣ Okupansi Berdasarkan Hari Kedatangan
        createChart(
            document.getElementById('weekdayOccupancyChart').getContext('2d'), 'line',
            {!! json_encode(array_keys($weekdayOccupancy)) !!}, {!! json_encode(array_values($weekdayOccupancy)) !!},
            ['#3498db'], 'Tanggal', 'Jumlah Reservasi', 'Jumlah Reservasi'
        );

        // Grafik 2️⃣ Rata-rata Lama Menginap per Bulan
        createChart(
            document.getElementById('avgStayChart').getContext('2d'), 'bar',
            {!! json_encode(array_keys($avgStayPerMonth)) !!}, {!! json_encode(array_values($avgStayPerMonth)) !!},
            ['#2ecc71'], 'Bulan', 'Rata-rata Lama Menginap (Malam)', 'Rata-rata Lama Menginap (Malam)'
        );

        // Grafik 3️⃣ Okupansi Berdasarkan Segmentasi Pasar
        createChart(
            document.getElementById('segmentChart').getContext('2d'), 'pie',
            {!! json_encode(array_keys($topMarketSegments)) !!}, {!! json_encode(array_values($topMarketSegments)) !!},
            ['#e74c3c', '#f39c12', '#9b59b6', '#3498db', '#2ecc71'],
            'Segmentasi Pasar', 'Jumlah Reservasi', 'Sejumlah'
        );

        // Grafik 4️⃣ Rasio Pembatalan per Bulan
        // createChart(
        //     document.getElementById('cancellationChart').getContext('2d'), 'line',
        //     {!! json_encode(array_keys($cancellationRatio)) !!}, {!! json_encode(array_values($cancellationRatio)) !!},
        //     ['#e74c3c'], 'Bulan Kedatangan', 'Rasio Pembatalan', 'Persentase Pembatalan per Bulan'
        // );

        // Grafik 4️⃣ Okupansi Berdasarkan Tipe Kamar
        createChart(
            document.getElementById('roomTypeDistribution').getContext('2d'), 'bar',
            {!! json_encode(array_keys($roomTypeDistributionData)) !!}, {!! json_encode(array_values($roomTypeDistributionData)) !!},
            ['purple', 'yellow', 'cyan', 'pink'], 'Tipe Kamar', 'Jumlah Reservasi', 'Jumlah Reservasi'
        );

        createChart(
            document.getElementById('monthlyOccupancy').getContext('2d'), 'line',
            {!! json_encode(array_keys($avgStayPerMonth)) !!}, {!! json_encode(array_values($monthlyOccupancy)) !!},
            ['blue'], 'Bulan', 'Jumlah Reservasi', 'Okupansi Bulanan'
        );

        new Chart(document.getElementById('multiAxisChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($occupancyRatePerMonth)) !!},
                datasets: [
                    {
                        label: 'Rasio Pemesanan (%)',
                        data: {!! json_encode(array_values($occupancyRatePerMonth)) !!},
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderWidth: 1,
                        type: 'line',
                        yAxisID: 'y'
                    },
                    {
                        label: 'Rasio Pembatalan (%)',
                        data: {!! json_encode(array_values($cancellationRatio)) !!},
                        type: 'line',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        title: { display: true, text: 'Rasio Pemasanan (%)' }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: { display: true, text: 'Rasio Pembatalan (%)' },
                        grid: { drawOnChartArea: false }
                    }
                }
            }
        });

        const ctxMulti = document.getElementById('ratioCancel').getContext('2d');
        new Chart(ctxMulti, {
            data: {
                labels: {!! json_encode(array_keys($monthlyOccupancy)) !!},
                datasets: [
                    {
                        type: 'bar',
                        label: 'Jumlah Booking',
                        data: {!! json_encode(array_values($monthlyOccupancy)) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.5)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        type: 'line',
                        label: 'Tingkat Okupansi (%)',
                        data: {!! json_encode(array_values($occupancyRatePerMonth)) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Jumlah Booking' },
                        position: 'left'
                    },
                    y1: {
                        beginAtZero: true,
                        title: { display: true, text: 'Okupansi (%)' },
                        position: 'right',
                        grid: { drawOnChartArea: false }
                    }
                }
            }
        });


        // Grafik 3️⃣ Tren Okupansi Berdasarkan Jumlah Malam Menginap
        new Chart(document.getElementById('stayDurationTrend').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Hari Biasa', 'Akhir Pekan'],
                datasets: [{
                    label: 'Jumlah Malam Menginap',
                    data: {!! json_encode([$totalWeekNights, $totalWeekendNights]) !!},
                    backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 159, 64, 0.5)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Jumlah Malam Menginap' }
                    }
                }
            }
        });
    </script>
</x-app-layout>