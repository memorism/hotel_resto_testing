<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Okupansi Hotel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- 🔹 Ringkasan Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-blue-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Total Reservasi</h4>
                        <p class="text-2xl font-bold">{{ $totalReservations }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Rata-rata Lama Menginap</h4>
                        <p class="text-2xl font-bold">{{ number_format($averageStay, 2) }} Malam</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Persentase Okupansi</h4>
                        <p class="text-2xl font-bold">{{ number_format($occupancyRate, 2) }}%</p>
                    </div>
                    <div class="bg-red-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Rasio Pembatalan</h4>
                        <p class="text-2xl font-bold">{{ number_format($cancellationRate, 2) }}%</p>
                    </div>
                </div>

                <!-- 🔹 Grafik Okupansi -->
                <style>
                    .chart-container {
                        width: 100%;
                        height: 300px;
                        /* Menetapkan tinggi tetap untuk grafik */
                    }
                </style>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Okupansi Berdasarkan Hari Kedatangan</h4>
                        <div class="chart-container">
                            <canvas id="weekdayOccupancyChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Rata-rata Lama Menginap per Bulan</h4>
                        <div class="chart-container">
                            <canvas id="avgStayChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Okupansi Berdasarkan Segmentasi Pasar</h4>
                        <div class="chart-container">
                            <canvas id="segmentChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Rasio Pembatalan per Bulan</h4>
                        <div class="chart-container">
                            <canvas id="cancellationChart"></canvas>
                        </div>
                    </div>


                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Okupansi Berdasarkan Tipe Kamar</h4>
                        <div class="chart-container">
                            <canvas id="roomTypeDistribution"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <div class="text-md font-semibold mb-2">
                            <h4 class="text-md font-semibold mb-2">Tren Okupansi Bulanan</h4>
                            <div class="chart-container">
                                <canvas id="monthlyOccupancy"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Rasio Pembatalan & Pemesanan</h4>
                        <div class="chart-container">
                            <canvas id="multiAxisChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Tren Okupansi Berdasarkan Jumlah Malam Menginap</h4>
                        <div class="chart-container">
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
            document.getElementById('weekdayOccupancyChart').getContext('2d'), 'bar',
            {!! json_encode(array_keys($weekdayOccupancy)) !!}, {!! json_encode(array_values($weekdayOccupancy)) !!},
            ['#3498db'], 'Hari Kedatangan', 'Jumlah Reservasi', 'Okupansi per Hari'
        );

        // Grafik 2️⃣ Rata-rata Lama Menginap per Bulan
        createChart(
            document.getElementById('avgStayChart').getContext('2d'), 'line',
            {!! json_encode(array_keys($avgStayPerMonth)) !!}, {!! json_encode(array_values($avgStayPerMonth)) !!},
            ['#2ecc71'], 'Bulan Kedatangan', 'Rata-rata Lama Menginap (Malam)', 'Lama Menginap Rata-rata'
        );

        // Grafik 3️⃣ Okupansi Berdasarkan Segmentasi Pasar
        createChart(
            document.getElementById('segmentChart').getContext('2d'), 'pie',
            {!! json_encode(array_keys($topMarketSegments)) !!}, {!! json_encode(array_values($topMarketSegments)) !!},
            ['#e74c3c', '#f39c12', '#9b59b6', '#3498db', '#2ecc71'],
            'Segmentasi Pasar', 'Jumlah Reservasi', 'Okupansi per Segmentasi Pasar'
        );

        // Grafik 4️⃣ Rasio Pembatalan per Bulan
        createChart(
            document.getElementById('cancellationChart').getContext('2d'), 'line',
            {!! json_encode(array_keys($cancellationRatio)) !!}, {!! json_encode(array_values($cancellationRatio)) !!},
            ['#e74c3c'], 'Bulan Kedatangan', 'Rasio Pembatalan', 'Persentase Pembatalan per Bulan'
        );

        // Grafik 4️⃣ Okupansi Berdasarkan Tipe Kamar
        createChart(
            document.getElementById('roomTypeDistribution').getContext('2d'), 'bar',
            {!! json_encode(array_keys($roomTypeDistributionData)) !!}, {!! json_encode(array_values($roomTypeDistributionData)) !!},
            ['purple', 'yellow', 'cyan', 'pink'], 'Tipe Kamar', 'Jumlah Reservasi', 'Okupansi per Tipe Kamar'
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
                        label: 'Rasio Okupansi (%)',
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
                        title: { display: true, text: 'Rasio Okupansi (%)' }
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