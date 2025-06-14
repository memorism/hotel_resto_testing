<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Daftar Meja Restoran') }}
            </h2>
            <a href="{{ route('resto.tables.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg> --}}
                Tambah Meja
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <!-- Search Bar -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('resto.tables.index') }}">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari kode meja..."
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
                                        onclick="window.location.href = '{{ route('resto.tables.index', array_merge(request()->query(), ['sort' => 'no', 'direction' => request('sort') == 'no' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
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
                                        onclick="window.location.href = '{{ route('resto.tables.index', array_merge(request()->query(), ['sort' => 'table_code', 'direction' => request('sort') == 'table_code' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Kode Meja
                                        @if (request('sort') == 'table_code')
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
                                        onclick="window.location.href = '{{ route('resto.tables.index', array_merge(request()->query(), ['sort' => 'capacity', 'direction' => request('sort') == 'capacity' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Kapasitas
                                        @if (request('sort') == 'capacity')
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
                                        onclick="window.location.href = '{{ route('resto.tables.index', array_merge(request()->query(), ['sort' => 'is_active', 'direction' => request('sort') == 'is_active' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Status
                                        @if (request('sort') == 'is_active')
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
                                @forelse ($tables as $index => $table)
                                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                    {{ $index + 1 }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                    {{ $table->table_code }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                                    <div class="flex items-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2"
                                                                            viewBox="0 0 20 20" fill="currentColor">
                                                                            <path
                                                                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                                                        </svg>
                                                                        {{ $table->capacity }} orang
                                                                    </div>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <span class="px-3 py-1 text-sm rounded-full inline-flex items-center
                                                                                                            {{ $table->is_active
                                    ? 'bg-green-50 text-green-700 border border-green-200'
                                    : 'bg-red-50 text-red-700 border border-red-200' 
                                                                                                            }}">
                                                                        <span
                                                                            class="w-2 h-2 rounded-full mr-2
                                                                                                                {{ $table->is_active ? 'bg-green-400' : 'bg-red-400' }}">
                                                                        </span>
                                                                        {{ $table->is_active ? 'Aktif' : 'Nonaktif' }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                                    <x-dropdown-action :editUrl="route('resto.tables.edit', $table->id)"
                                                                        :deleteUrl="route('resto.tables.destroy', $table->id)" />
                                                                </td>
                                                            </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 12h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                                </svg>
                                                <span>Belum ada data meja.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $tables->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>