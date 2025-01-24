<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Data Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Loop untuk menampilkan chart -->
                    @foreach ($data as $title => $values)
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-3">{{ ucfirst(str_replace('_', ' ', $title)) }}</h3>

                            @if ($values->keys()->first() === 'booking_status')
                                <!-- Pie Chart untuk booking_status -->
                                <canvas id="chart-{{ $loop->iteration }}" width="400" height="200"></canvas>
                                <script>
                                    var ctx = document.getElementById('chart-{{ $loop->iteration }}').getContext('2d');
                                    var chart = new Chart(ctx, {
                                        type: 'pie', // Pie chart untuk booking status
                                        data: {
                                            labels: {!! json_encode($values->keys()) !!},
                                            datasets: [{
                                                label: '{{ ucfirst(str_replace('_', ' ', $title)) }}',
                                                data: {!! json_encode($values->values()) !!},
                                                backgroundColor: ['rgba(0,123,255,0.5)', 'rgba(255,99,132,0.5)', 'rgba(75,192,192,0.5)'],
                                                borderColor: ['rgba(0,123,255,1)', 'rgba(255,99,132,1)', 'rgba(75,192,192,1)'],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            responsive: true
                                        }
                                    });
                                </script>
                            @else
                                <!-- Bar Chart untuk data numerik seperti no_of_adults, no_of_children, etc -->
                                <canvas id="chart-{{ $loop->iteration }}" width="400" height="200"></canvas>
                                <script>
                                    var ctx = document.getElementById('chart-{{ $loop->iteration }}').getContext('2d');
                                    var chart = new Chart(ctx, {
                                        type: 'bar', // Bar chart untuk data numerik
                                        data: {
                                            labels: {!! json_encode($values->keys()) !!},
                                            datasets: [{
                                                label: '{{ ucfirst(str_replace('_', ' ', $title)) }}',
                                                data: {!! json_encode($values->values()) !!},
                                                backgroundColor: 'rgba(0,123,255,0.5)',
                                                borderColor: 'rgba(0,123,255,1)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        callback: function (value) {
                                                            return value + '%'; // Menampilkan persentase di sumbu Y
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    });
                                </script>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>