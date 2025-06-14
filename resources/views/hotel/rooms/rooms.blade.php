<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Kamar Hotel') }}
            </h2>
            <a href="{{ route('hotel.rooms.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                {{-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> --}}
                Tambah Kamar
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <!-- Search Bar -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('hotel.rooms.index') }}">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari tipe kamar, deskripsi..."
                                    class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out">
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto border rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href = '{{ route('hotel.rooms.index', array_merge(request()->query(), ['sort' => 'no', 'direction' => request('sort') == 'no' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        No
                                        @if (request('sort') == 'no')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href = '{{ route('hotel.rooms.index', array_merge(request()->query(), ['sort' => 'room_type', 'direction' => request('sort') == 'room_type' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Tipe Kamar
                                        @if (request('sort') == 'room_type')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href = '{{ route('hotel.rooms.index', array_merge(request()->query(), ['sort' => 'total_rooms', 'direction' => request('sort') == 'total_rooms' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Jumlah Kamar
                                        @if (request('sort') == 'total_rooms')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href = '{{ route('hotel.rooms.index', array_merge(request()->query(), ['sort' => 'price_per_room', 'direction' => request('sort') == 'price_per_room' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Harga Kamar
                                        @if (request('sort') == 'price_per_room')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href = '{{ route('hotel.rooms.index', array_merge(request()->query(), ['sort' => 'description', 'direction' => request('sort') == 'description' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Deskripsi
                                        @if (request('sort') == 'description')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($rooms as $index => $room)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $room->room_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $room->total_rooms }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Rp {{ number_format($room->price_per_room, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                            {{ $room->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            <x-dropdown-action :editUrl="route('hotel.rooms.edit', $room->id)"
                                                :deleteUrl="route('hotel.rooms.destroy', $room->id)" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                <span>Belum ada data kamar.</span>
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