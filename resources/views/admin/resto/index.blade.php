<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Restaurant') }}
                </h2>
                {{-- <span class="ml-2 px-2.5 py-0.5 text-xs font-medium bg-blue-50 text-blue-600 rounded-full">
                    {{ $restos->total() }} Restaurant
                </span> --}}
            </div>
            <a href="{{ route('admin.resto.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                {{-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> --}}
                Tambah Restaurant
            </a>
        </div>
    </x-slot>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Content --}}
    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white rounded-xl shadow-sm border border-gray-200">
                <!-- Header Section -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between pb-5">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Daftar Restaurant</h3>
                            <p class="mt-1 text-sm text-gray-500">Kelola data restaurant yang terdaftar dalam sistem.
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-blue-50 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6M3 3h18v18H3V3z" />
                            </svg>
                        </div>
                    </div>

                    {{-- Search & Filter --}}
                    <div class="flex justify-between items-center mb-4">
                        <!-- Search Bar -->
                        <div class="w-full max-w-md">
                            <form method="GET" action="{{ route('admin.resto.index') }}">
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" placeholder="Cari nama resto..."
                                        value="{{ request('search') }}"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                </div>
                            </form>
                        </div>

                        <!-- Filter Dropdown -->
                        <div class="relative" x-data="{ open: false }" x-cloak>
                            <button @click="open = !open" type="button"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <form method="GET" action="{{ route('admin.resto.index') }}" class="p-4 space-y-4">
                                    <!-- City Filter -->
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Filter
                                            Kota</label>
                                        <select name="city" id="city"
                                            class="block w-full p-2 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">Semua Kota</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                                    {{ $city }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Items Per Page -->
                                    <div>
                                        <label for="per_page"
                                            class="block text-sm font-medium text-gray-700 mb-1">Jumlah Data</label>
                                        <select name="per_page" id="per_page"
                                            class="block w-full rounded-lg p-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Data
                                            </option>
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data
                                            </option>
                                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data
                                            </option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data
                                            </option>
                                            <option value="semua" {{ request('per_page') == 'semua' ? 'selected' : '' }}>
                                                Semua Data</option>
                                        </select>
                                    </div>

                                    <!-- Filter Button -->
                                    <div class="pt-2">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Terapkan Filter
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Logo</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onclick="window.location.href='{{ route('admin.resto.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    Nama Restaurant
                                    @if(request('sort') === 'name')
                                        <span class="ml-1">
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onclick="window.location.href='{{ route('admin.resto.index', array_merge(request()->query(), ['sort' => 'address', 'direction' => request('sort') === 'address' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    Alamat Lengkap
                                    @if(request('sort') === 'address')
                                        <span class="ml-1">
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onclick="window.location.href='{{ route('admin.resto.index', array_merge(request()->query(), ['sort' => 'phone', 'direction' => request('sort') === 'phone' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    Telepon
                                    @if(request('sort') === 'phone')
                                        <span class="ml-1">
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onclick="window.location.href='{{ route('admin.resto.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => request('sort') === 'email' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    Email
                                    @if(request('sort') === 'email')
                                        <span class="ml-1">
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($restos as $resto)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($resto->logo)
                                            <img src="{{ asset('storage/' . $resto->logo) }}" alt="Logo {{ $resto->name }}"
                                                class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-200">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $resto->name }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500 line-clamp-2">
                                            {{ implode(', ', array_filter([$resto->street, $resto->village, $resto->district, $resto->city, $resto->province, $resto->postal_code])) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $resto->phone }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $resto->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <x-dropdown-action :edit-url="route('admin.resto.edit', $resto->id)"
                                            :delete-url="route('admin.resto.destroy', $resto->id)" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="text-center py-12">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6M3 3h18v18H3V3z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
                                            <p class="mt-1 text-sm text-gray-500">Belum ada restaurant yang terdaftar.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $restos->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>