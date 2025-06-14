<x-app-layout>


    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Daftar Pelanggan') }}
            </h2>
            <a href="{{ route('resto.shared_customers.create_resto') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition duration-150 ease-in-out">
                {{-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg> --}}
                Tambah Pelanggan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6">
                    {{-- SEARCH BAR --}}
                    <form action="{{ route('resto.shared_customers.index_resto') }}" method="GET" class="mb-6">
                        <label for="search" class="sr-only">Cari:</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Cari nama, nomor telepon, atau email..."
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2">
                    </form>

                    {{-- FILTER DROPDOWN --}}
                    <div class="flex justify-between items-center mb-6">
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button type="button" @click="open = !open"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                id="options-menu" aria-haspopup="true" aria-expanded="true">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Filter Data
                            </button>

                            <div x-show="open"
                                class="origin-top-left absolute left-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                                style="display: none;">
                                <div class="py-1" role="menu" aria-orientation="vertical"
                                    aria-labelledby="options-menu">
                                    <form action="{{ route('resto.shared_customers.index_resto') }}" method="GET"
                                        class="p-4 space-y-4">
                                        @if (request('search'))
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                        @endif
                                        <div class="space-y-1">
                                            <label for="gender" class="block text-sm font-medium text-gray-700">Jenis
                                                Kelamin:</label>
                                            <select name="gender" id="gender"
                                                class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                <option value="">Semua</option>
                                                <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>
                                                    Laki-laki
                                                </option>
                                                <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>
                                                    Perempuan
                                                </option>
                                            </select>
                                        </div>

                                        <div class="flex justify-end space-x-2 mt-4">
                                            <button type="button"
                                                @click="open = false; window.location.href = '{{ route('resto.shared_customers.index_resto') }}'"
                                                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                                Reset
                                            </button>
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                                Terapkan Filter
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc']) }}'">
                                        No
                                        @if(request('sort') === 'id')
                                            <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc']) }}'">
                                        Nama
                                        @if(request('sort') === 'name')
                                            <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => request('sort') === 'email' && request('direction') === 'asc' ? 'desc' : 'asc']) }}'">
                                        Email
                                        @if(request('sort') === 'email')
                                            <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort' => 'phone', 'direction' => request('sort') === 'phone' && request('direction') === 'asc' ? 'desc' : 'asc']) }}'">
                                        No. Telepon
                                        @if(request('sort') === 'phone')
                                            <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href='{{ request()->fullUrlWithQuery(['sort' => 'gender', 'direction' => request('sort') === 'gender' && request('direction') === 'asc' ? 'desc' : 'asc']) }}'">
                                        Jenis Kelamin
                                        @if(request('sort') === 'gender')
                                            <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($customers as $c)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $c->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $c->email ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $c->phone ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($c->gender === 'L')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Laki-laki
                                                </span>
                                            @elseif($c->gender === 'P')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                                    Perempuan
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    -
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <x-dropdown-action :editUrl="route('resto.shared_customers.edit_resto', $c->id)" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center justify-center py-6">
                                                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                <p>Tidak ada pelanggan ditemukan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>