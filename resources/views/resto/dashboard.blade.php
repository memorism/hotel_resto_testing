<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Resto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">📊 Statistik Pesanan & Penjualan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Chart Total Penjualan per Hari -->
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Total Penjualan per Hari</h4>
                        <canvas id="totalSalesChart"></canvas>
                    </div>

                    <!-- Chart Jumlah Pesanan per Item -->
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Jumlah Pesanan per Item</h4>
                        <canvas id="itemSalesChart"></canvas>
                    </div>

                    <!-- Chart Pendapatan per Jenis Item -->
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Pendapatan per Jenis Item</h4>
                        <canvas id="revenueByItemTypeChart"></canvas>
                    </div>

                    <!-- Chart Pesanan Berdasarkan Jenis Transaksi -->
                    <div class="bg-white p-4 shadow-md rounded-lg">
                        <h4 class="text-md font-semibold mb-2">Pesanan Berdasarkan Jenis Transaksi</h4>
                        <canvas id="orderByTransactionTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Chart: Total Penjualan per Hari
        new Chart(document.getElementById('totalSalesChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($totalSalesChart['labels']) !!},
                datasets: [{
                    label: 'Total Penjualan',
                    data: {!! json_encode($totalSalesChart['data']) !!},
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });

        // Chart: Jumlah Pesanan per Item
        new Chart(document.getElementById('itemSalesChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($itemSalesChart['labels']) !!},
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: {!! json_encode($itemSalesChart['data']) !!},
                    backgroundColor: 'red'
                }]
            }
        });

        // Chart: Pendapatan per Jenis Item
        new Chart(document.getElementById('revenueByItemTypeChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($revenueByItemTypeChart['labels']) !!},
                datasets: [{
                    data: {!! json_encode($revenueByItemTypeChart['data']) !!},
                    backgroundColor: ['green', 'yellow', 'blue', 'red', 'purple']
                }]
            }
        });

        // Chart: Pesanan Berdasarkan Jenis Transaksi
        new Chart(document.getElementById('orderByTransactionTypeChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($orderByTransactionTypeChart['labels']) !!},
                datasets: [{
                    data: {!! json_encode($orderByTransactionTypeChart['data']) !!},
                    backgroundColor: ['orange', 'cyan', 'pink']
                }]
            }
        });
    </script>
</x-app-layout>
