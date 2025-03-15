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

                <!-- 🔹 Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 text-white mb-6">
                    <div class="bg-blue-500 p-4 rounded-lg">
                        <h5>Total Penjualan</h5>
                        <p class="text-2xl">{{ number_format($totalSales) }}</p>
                    </div>
                    <div class="bg-green-500 p-4 rounded-lg">
                        <h5>Total Pendapatan</h5>
                        <p class="text-2xl">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-yellow-500 p-4 rounded-lg">
                        <h5>Rata-rata Order Value</h5>
                        <p class="text-2xl">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-red-500 p-4 rounded-lg">
                        <h5>Profit & Loss</h5>
                        <p class="text-2xl">Rp {{ number_format($profitLoss, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-purple-500 p-4 rounded-lg">
                        <h5>Target Pencapaian</h5>
                        <p class="text-2xl">{{ number_format($targetAchievement, 2) }}%</p>
                    </div>
                </div>

                <!-- 🔹 Semua Grafik -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Pendapatan Harian</h3>
                        <canvas id="revenueTrend"></canvas>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Profit & Loss Harian</h3>
                        <canvas id="profitLossTrend"></canvas>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Pendapatan Berdasarkan Jenis Menu</h3>
                        <canvas id="menuChart"></canvas>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Biaya Operasional vs Pendapatan</h3>
                        <canvas id="costVsRevenueChart"></canvas>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Distribusi Metode Pembayaran</h3>
                        <canvas id="paymentChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('revenueTrend'), {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueTrend->pluck('order_date')) !!},
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: {!! json_encode($revenueTrend->pluck('total_revenue')) !!},
                    backgroundColor: 'blue'
                }]
            }
        });

        new Chart(document.getElementById('profitLossTrend'), {
            type: 'line',
            data: {
                labels: {!! json_encode($profitLossTrend->pluck('order_date')) !!},
                datasets: [{
                    label: 'Profit & Loss Harian',
                    data: {!! json_encode($profitLossTrend->pluck('profit_or_loss')) !!},
                    backgroundColor: 'green'
                }]
            }
        });

        new Chart(document.getElementById('paymentChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($paymentMethods->pluck('transaction_type')) !!},
                datasets: [{
                    data: {!! json_encode($paymentMethods->pluck('total_payments')) !!},
                    backgroundColor: ['red', 'blue', 'green']
                }]
            }
        });

        new Chart(document.getElementById('menuChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($revenueByItemType->pluck('item_name')) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($revenueByItemType->pluck('total_revenue')) !!},
                    backgroundColor: 'purple'
                }]
            }
        });

        new Chart(document.getElementById('costVsRevenueChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($costVsRevenue->pluck('order_date')) !!},
                datasets: [
                    {
                        label: 'Pendapatan',
                        data: {!! json_encode($costVsRevenue->pluck('total_revenue')) !!},
                        backgroundColor: 'blue'
                    },
                    {
                        label: 'Biaya Operasional',
                        data: {!! json_encode($costVsRevenue->pluck('total_cost')) !!},
                        backgroundColor: 'red'
                    }
                ]
            }
        });
    </script>

</x-app-layout>