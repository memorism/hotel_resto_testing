<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                {{-- Card untuk Hotel --}}
                <div class="p-4 bg-blue-100 shadow rounded-lg flex items-center justify-start space-x-4">
                    <div
                        class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl">
                        🏨
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Jumlah Hotel</h3>
                        <p class="text-2xl font-bold">{{ $hotelCount }}</p>
                    </div>
                </div>

                {{-- Card untuk Resto --}}
                <div class="p-4 bg-green-100 shadow rounded-lg flex items-center justify-start space-x-4">
                    <div
                        class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center text-2xl">
                        🍽️
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Jumlah Restaurant</h3>
                        <p class="text-2xl font-bold">{{ $restoCount }}</p>
                    </div>
                </div>

                {{-- Status Aktivitas User Hotel --}}
                <div class="mt-10">
                    <h3 class="text-xl font-bold text-gray-800 mb-4"> Status Aktivitas User Hotel</h3>
                    <div class="overflow-x-auto shadow rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 bg-white text-sm text-gray-700">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Nama User
                                    </th>
                                    <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Terakhir
                                        Update</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($hotelStats as $index => $stat)
                                    <tr
                                        class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-green-50 transition">
                                        <td class="px-6 py-3 font-medium">{{ $index + 1 }}</td>
                                        <td class="px-6 py-3">{{ $stat['name'] }}</td>
                                        <td class="px-6 py-3 italic text-gray-600">
                                            {{ $stat['last_updated'] }}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center px-6 py-4 text-gray-500">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Status Aktivitas User Resto --}}
                <div class="mt-10">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">  Status Aktivitas User Resto</h3>
                    <div class="overflow-x-auto shadow rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 bg-white text-sm text-gray-700">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Nama User
                                    </th>
                                    <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Terakhir
                                        Update</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($restoStats as $index => $stat)
                                    <tr
                                        class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-blue-50 transition">
                                        <td class="px-6 py-3 font-medium">{{ $index + 1 }}</td>
                                        <td class="px-6 py-3">{{ $stat['name'] }}</td>
                                        <td class="px-6 py-3 italic text-gray-600">
                                            {{ $stat['last_updated'] }}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center px-6 py-4 text-gray-500">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>



            </div>
        </div>
    </div>
</x-app-layout>