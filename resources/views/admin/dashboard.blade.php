<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Card untuk Hotel --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-16 h-16 bg-blue-500 bg-opacity-10 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" 
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-lg font-semibold text-gray-900">Mitra Hotel</h3>
                                <div class="mt-2 flex items-baseline">
                                    <p class="text-3xl font-bold text-blue-600">{{ $hotelCount }}</p>
                                    <p class="ml-2 text-sm text-gray-500">total mitra</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card untuk Resto --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-16 h-16 bg-green-500 bg-opacity-10 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 3h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1zm8 7a3 3 0 100-6 3 3 0 000 6zm-4 8h8v-2a4 4 0 00-8 0v2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-lg font-semibold text-gray-900">Mitra Restaurant</h3>
                                <div class="mt-2 flex items-baseline">
                                    <p class="text-3xl font-bold text-green-600">{{ $restoCount }}</p>
                                    <p class="ml-2 text-sm text-gray-500">total mitra</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status Aktivitas User Hotel --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-xl transition-shadow duration-300">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Status Aktivitas User Hotel</h3>
                            <span class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full">Live
                                Updates</span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama User</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Terakhir Update</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($hotelStats as $index => $stat)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $stat['name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>
                                                <span class="text-sm text-gray-600">{{ $stat['last_updated'] }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-sm text-center text-gray-500 bg-gray-50">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <span>Tidak ada data tersedia</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Status Aktivitas User Resto --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-xl hover:shadow-xl transition-shadow duration-300">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Status Aktivitas User Resto</h3>
                            <span class="px-3 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-full">Live
                                Updates</span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama User</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Terakhir Update</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($restoStats as $index => $stat)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $stat['name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>
                                                <span class="text-sm text-gray-600">{{ $stat['last_updated'] }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-sm text-center text-gray-500 bg-gray-50">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <span>Tidak ada data tersedia</span>
                                            </div>
                                        </td>
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