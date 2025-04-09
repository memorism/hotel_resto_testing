<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Keuangan Hotel') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- 🔹 Filter Form -->
                <form method="GET" action="{{ route('admin.hotel') }}" class="mb-4">
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
                            <input type="date" name="start_date" class="w-full p-2 border rounded" value="{{ request('start_date') }}">
                        </div>
                        <div>
                            <label class="block text-gray-700">Tanggal Akhir:</label>
                            <input type="date" name="end_date" class="w-full p-2 border rounded" value="{{ request('end_date') }}">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>

                <!-- 🔹 Ringkasan Keuangan -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Total Pendapatan</h4>
                        <p class="text-2xl font-bold text-blue-800">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                
                    {{-- 
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Total Biaya Operasional</h4>
                        <p class="text-2xl font-bold text-red-800">Rp{{ number_format($totalExpenses, 0, ',', '.') }}</p>
                    </div>
                    --}}
                
                    {{-- 
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Keuntungan Bersih</h4>
                        <p class="text-2xl font-bold text-green-800">Rp{{ number_format($profit, 0, ',', '.') }}</p>
                    </div>
                    --}}
                
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">RevPAR</h4>
                        <p class="text-2xl font-bold text-yellow-800">Rp{{ number_format($revPAR, 0, ',', '.') }}</p>
                    </div>
                
                    <div class="bg-purple-50 border-l-4 border-purple-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">ADR</h4>
                        <p class="text-2xl font-bold text-purple-800">Rp{{ number_format($adr, 0, ',', '.') }}</p>
                    </div>
                
                    <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded">
                        <h4 class="text-gray-700 font-semibold">Kerugian Akibat Pembatalan</h4>
                        <p class="text-2xl font-bold text-red-600">Rp{{ number_format($cancellationLoss, 0, ',', '.') }}</p>
                    </div>
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
                    {{-- <div class="bg-white p-4 rounded-lg shadow-md">
                        <h4 class="text-md font-semibold mb-2">Biaya Operasional vs Pendapatan</h4>
                        <div class="chart-container">
                            <canvas id="expensesVsRevenueChart"></canvas>
                        </div>
                    </div> --}}
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

        // createChart(
        //     document.getElementById('expensesVsRevenueChart').getContext('2d'), 'line',
        //     {!! json_encode(array_keys($monthlyExpenses)) !!}, {!! json_encode(array_values($monthlyExpenses)) !!},
        //     '#e74c3c', 'Bulan', 'Biaya Operasional (Rp)', 'Biaya vs Pendapatan'
        // );

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
