<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Keuangan Hotel') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <!-- 🔹 Filter Form -->
                <form method="GET" action="{{ route('hotel.dashboard') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm text-gray-700 font-semibold">Tanggal Mulai:</label>
                            <input type="date" name="start_date" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ request('start_date') }}">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 font-semibold">Tanggal Akhir:</label>
                            <input type="date" name="end_date" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ request('end_date') }}">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold shadow">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- 🔹 Ringkasan Keuangan -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                    @php
                        $cards = [
                            ['label' => 'Total Pendapatan', 'value' => $totalRevenue, 'bg' => 'bg-blue-100'],
                            ['label' => 'Total Biaya Operasional', 'value' => $totalExpenses, 'bg' => 'bg-red-100'],
                            ['label' => 'Keuntungan Bersih', 'value' => $profit, 'bg' => 'bg-green-100'],
                            ['label' => 'RevPAR', 'value' => $revPAR, 'bg' => 'bg-yellow-100'],
                            ['label' => 'ADR', 'value' => $adr, 'bg' => 'bg-purple-100'],
                            ['label' => 'Kerugian Akibat Pembatalan', 'value' => $cancellationLoss, 'bg' => 'bg-gray-100 text-red-500']
                        ];
                    @endphp

                    @foreach ($cards as $card)
                        <div class="{{ $card['bg'] }} p-4 rounded-lg text-center shadow">
                            <h4 class="text-sm font-semibold text-gray-700">{{ $card['label'] }}</h4>
                            <p class="text-xl font-bold">Rp{{ number_format($card['value'], 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- 🔹 Tabel Kamar dengan Pendapatan Tertinggi -->
                <div class="bg-white p-4 rounded-lg shadow-md mb-8">
                    <h4 class="text-lg font-semibold mb-4 text-gray-800">Top Performing Rooms</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm border border-gray-200">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 border">Tipe Kamar</th>
                                    <th class="px-4 py-2 border">Jumlah Reservasi</th>
                                    <th class="px-4 py-2 border">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roomRevenue as $roomType => $revenue)
                                    <tr class="text-center">
                                        <td class="px-4 py-2 border">{{ $roomType }}</td>
                                        <td class="px-4 py-2 border">{{ $roomBookings[$roomType] ?? 0 }}</td>
                                        <td class="px-4 py-2 border">Rp{{ number_format($revenue, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 🔹 Grafik Keuangan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h4 class="text-md font-semibold mb-2">Pendapatan Per Bulan</h4>
                        <div class="chart-container">
                            <canvas id="monthlyRevenueChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h4 class="text-md font-semibold mb-2">Biaya Operasional vs Pendapatan</h4>
                        <div class="chart-container">
                            <canvas id="expensesVsRevenueChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h4 class="text-md font-semibold mb-2">Pendapatan Berdasarkan Segmen Pasar</h4>
                        <div class="chart-container">
                            <canvas id="marketSegmentRevenueChart"></canvas>
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
                    scales: {
                        x: { title: { display: true, text: xLabel } },
                        y: { title: { display: true, text: yLabel } }
                    }
                }
            });
        }

        createChart(
            document.getElementById('monthlyRevenueChart').getContext('2d'), 'bar',
            {!! json_encode(array_keys($monthlyRevenue)) !!}, {!! json_encode(array_values($monthlyRevenue)) !!},
            '#3498db', 'Bulan', 'Pendapatan (Rp)', 'Pendapatan Per Bulan'
        );

        createChart(
            document.getElementById('expensesVsRevenueChart').getContext('2d'), 'line',
            {!! json_encode(array_keys($monthlyExpenses)) !!}, {!! json_encode(array_values($monthlyExpenses)) !!},
            '#e74c3c', 'Bulan', 'Biaya Operasional (Rp)', 'Biaya vs Pendapatan'
        );

        createChart(
            document.getElementById('marketSegmentRevenueChart').getContext('2d'), 'pie',
            {!! json_encode(array_keys($marketSegmentRevenue)) !!}, {!! json_encode(array_values($marketSegmentRevenue)) !!},
            ['#1abc9c', '#3498db', '#9b59b6', '#f1c40f', '#e74c3c'],
            'Segmen Pasar', 'Pendapatan (Rp)', 'Pendapatan Berdasarkan Segmen Pasar'
        );
    </script>

    <style>
        .chart-container {
            width: 100%;
            height: 300px;
        }
    </style>
</x-app-layout>
