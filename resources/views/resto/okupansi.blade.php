<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Okupansi Restoran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- 🔹 Filter Form -->
                <form method="GET" action="{{ route('resto.okupansi') }}" class="mb-4">
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

                <!-- 🔹 Ringkasan Okupansi -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-blue-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Total Transaksi</h4>
                        <p class="text-2xl font-bold">{{ number_format($totalTransactions) }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Jam Tersibuk</h4>
                        <p class="text-2xl font-bold">
                            {{ collect($peakHours)->sortByDesc('total_orders')->first()['hour'] ?? '-' }}:00
                        </p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Hari Tersibuk</h4>
                        <p class="text-2xl font-bold">
                            {{ $peakDays->sortByDesc('total_orders')->first()->day ?? '-' }}
                        </p>
                    </div>
                    {{-- <div class="bg-red-100 p-4 rounded-lg text-center">
                        <h4 class="text-lg font-semibold">Persentase Pembatalan</h4>
                        <p class="text-2xl font-bold">{{ number_format($cancellationRate->cancellation_rate ?? 0, 2) }}%
                        </p>
                    </div> --}}
                </div>

                <!-- 🔹 Grafik Okupansi -->
                <style>
                    .chart-container {
                        width: 100%;
                        height: 300px;
                    }
                </style>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($transactionTrends->count() > 0)
                        <div class="bg-white p-4 shadow-md rounded-lg">
                            <h4 class="text-md font-semibold mb-2">Tren Transaksi Harian</h4>
                            <div class="chart-container">
                                <canvas id="transactionChart"></canvas>
                            </div>
                        </div>
                    @endif

                    @if($peakHours->count() > 0)
                        <div class="bg-white p-4 shadow-md rounded-lg">
                            <h4 class="text-md font-semibold mb-2">Waktu Tersibuk</h4>
                            <div class="chart-container">
                                <canvas id="peakHoursChart"></canvas>
                            </div>
                        </div>
                    @endif

                    @if($orderTypes->count() > 0)
                        <div class="bg-white p-4 shadow-md rounded-lg">
                            <h4 class="text-md font-semibold mb-2">Distribusi Jenis Pesanan</h4>
                            <div class="chart-container">
                                <canvas id="orderTypeChart"></canvas>
                            </div>
                        </div>
                    @endif

                    @if($menuPopularity->count() > 0)
                        <div class="bg-white p-4 shadow-md rounded-lg">
                            <h4 class="text-md font-semibold mb-2">Popularitas Menu</h4>
                            <div class="chart-container">
                                <canvas id="menuPopularityChart"></canvas>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
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

        @if($transactionTrends->count() > 0)
            createChart(
                document.getElementById('transactionChart').getContext('2d'), 'line',
                {!! json_encode($transactionTrends->pluck('date')->toArray()) !!},
                {!! json_encode($transactionTrends->pluck('total_transactions')->toArray()) !!},
                ['#3498db'], 'Tanggal', 'Jumlah Transaksi', 'Tren Transaksi Harian'
            );
        @endif

        @if($peakHours->count() > 0)
            createChart(
                document.getElementById('peakHoursChart').getContext('2d'), 'bar',
                {!! json_encode($peakHours->pluck('hour')->toArray()) !!},
                {!! json_encode($peakHours->pluck('total_orders')->toArray()) !!},
                ['#e74c3c'], 'Jam', 'Jumlah Pesanan', 'Waktu Tersibuk'
            );
        @endif

            @if($orderTypes->count() > 0)
                let orderLabels = {!! json_encode($orderTypes->pluck('type_of_order')->toArray()) !!};
                let orderData = {!! json_encode($orderTypes->pluck('total_orders')->toArray()) !!};

                let totalOrders = orderData.reduce((sum, value) => sum + value, 0);
                let percentageData = orderData.map(value => ((value / totalOrders) * 100).toFixed(2) + "%");

                // 🔹 Atur warna secara dinamis berdasarkan label pesanan
                let colorMapping = {
                    'Dine In': '#3498db', // Biru
                    'Take Away': '#e74c3c', // Merah
                    'Online': '#2ecc71', // Hijau
                    'Drive Thru': '#f1c40f', // Kuning
                    'Other': '#9b59b6' // Ungu
                };

                let backgroundColors = orderLabels.map(label => colorMapping[label] || '#34495e'); // Default warna jika tidak ada

                new Chart(document.getElementById('orderTypeChart').getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: orderLabels,
                        datasets: [{
                            data: orderData,
                            backgroundColor: backgroundColors, // Menggunakan warna yang sesuai
                            borderColor: backgroundColors.map(color => color.replace('0f', '9f')), // Variasi warna border
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            datalabels: {
                                color: '#fff',
                                font: { weight: 'bold', size: 14 },
                                formatter: (value, context) => {
                                    return percentageData[context.dataIndex]; // Menampilkan angka persentase
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels] // Aktifkan plugin untuk menampilkan label persentase
                });
            @endif


        @if($menuPopularity->count() > 0)
            createChart(
                document.getElementById('menuPopularityChart').getContext('2d'), 'bar',
                {!! json_encode($menuPopularity->pluck('item_name')->toArray()) !!},
                {!! json_encode($menuPopularity->pluck('total_quantity')->toArray()) !!},
                ['#9b59b6'], 'Menu', 'Jumlah Terjual', 'Popularitas Menu'
            );
        @endif
    </script>

</x-app-layout>