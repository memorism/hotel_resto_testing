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

                <!-- 🔹 Ringkasan Data -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-white">
                    <div class="bg-blue-500 p-4 rounded-lg shadow">
                        <h5 class="text-lg font-semibold">Total Pendapatan</h5>
                        <p class="text-2xl">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-green-500 p-4 rounded-lg shadow">
                        <h5 class="text-lg font-semibold">Profit</h5>
                        <p class="text-2xl">Rp {{ number_format($profit, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-yellow-500 p-4 rounded-lg shadow">
                        <h5 class="text-lg font-semibold">RevPAR</h5>
                        <p class="text-2xl">Rp {{ number_format($revPAR, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-red-500 p-4 rounded-lg shadow">
                        <h5 class="text-lg font-semibold">ADR</h5>
                        <p class="text-2xl">Rp {{ number_format($adr, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- 🔹 Semua Grafik -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Pendapatan Bulanan</h3>
                        <canvas id="revenueChart"></canvas>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Pendapatan vs Biaya</h3>
                        <canvas id="expenseChart"></canvas>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Pendapatan Berdasarkan Segmen Pasar</h3>
                        <canvas id="marketSegmentChart"></canvas>
                    </div>

                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Pendapatan Berdasarkan Tipe Kamar</h3>
                        <canvas id="roomChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 1️⃣ Grafik Pendapatan Bulanan
        new Chart(document.getElementById('revenueChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($monthlyRevenue)) !!},
                datasets: [{
                    label: 'Pendapatan Bulanan',
                    data: {!! json_encode(array_values($monthlyRevenue)) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }
        });

        // 2️⃣ Grafik Pendapatan vs Biaya Operasional
        new Chart(document.getElementById('expenseChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($monthlyRevenue)) !!},
                datasets: [
                    {
                        label: 'Pendapatan',
                        data: {!! json_encode(array_values($monthlyRevenue)) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Biaya Operasional',
                        data: {!! json_encode(array_values($monthlyExpenses)) !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            }
        });

        // 3️⃣ Grafik Pendapatan Berdasarkan Segmen Pasar
        new Chart(document.getElementById('marketSegmentChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($marketSegmentRevenue)) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode(array_values($marketSegmentRevenue)) !!},
                    backgroundColor: ['red', 'blue', 'green', 'yellow', 'purple']
                }]
            }
        });

        // 4️⃣ Grafik Pendapatan Berdasarkan Tipe Kamar
        new Chart(document.getElementById('roomChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($roomRevenue)) !!},
                datasets: [{
                    label: 'Pendapatan Kamar',
                    data: {!! json_encode(array_values($roomRevenue)) !!},
                    backgroundColor: ['orange', 'blue', 'green', 'red', 'purple']
                }]
            }
        });
    </script>

</x-app-layout>
