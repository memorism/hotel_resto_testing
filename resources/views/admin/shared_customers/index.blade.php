<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Data Semua Pelanggan') }}
                </h2>
                {{-- <span class="ml-4 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ $customers->total() }} pelanggan
                </span> --}}
            </div>
            <a href="{{ route('admin.shared_customers.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors duration-150">
                {{-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg> --}}
                Tambah Pelanggan
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="flex p-4 rounded-lg bg-green-50 border border-green-200">
                <svg class="h-5 w-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Search and Filter Section -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <!-- Search Bar -->
                        <div class="w-full max-w-md">
                            <form method="GET" action="{{ route('admin.shared_customers.index') }}">
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" placeholder="Cari nama/email/telepon..."
                                        value="{{ request('search') }}"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                                </div>
                            </form>
                        </div>

                        <!-- Filter Dropdown -->
                        <div class="relative" x-data="{ open: false }" x-cloak>
                            <button @click="open = !open" type="button"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <form method="GET" action="{{ route('admin.shared_customers.index') }}" class="p-4 space-y-4">
                                    <!-- Source Filter -->
                                    <div>
                                        <label for="source" class="block text-sm font-medium text-gray-700 mb-1">Sumber</label>
                                        <select name="source" id="source"
                                            class="block w-full p-2 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">Semua Sumber</option>
                                            <option value="hotel" {{ request('source') == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                            <option value="resto" {{ request('source') == 'resto' ? 'selected' : '' }}>Resto</option>
                                        </select>
                                    </div>

                                    <!-- Items Per Page -->
                                    <div>
                                        <label for="per_page" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Data</label>
                                        <select name="per_page" id="per_page"
                                            class="block w-full rounded-lg p-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Data</option>
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data</option>
                                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data</option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data</option>
                                            <option value="semua" {{ request('per_page') == 'semua' ? 'selected' : '' }}>Semua Data</option>
                                        </select>
                                    </div>

                                    <!-- Show Deleted Toggle -->
                                    <div class="flex items-center">
                                        <input type="checkbox" name="with_deleted" id="with_deleted" value="1"
                                            {{ request('with_deleted') ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="with_deleted" class="ml-2 block text-sm text-gray-700">
                                            Tampilkan yang terhapus
                                        </label>
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

                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onclick="window.location.href='{{ route('admin.shared_customers.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    Nama
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
                                    onclick="window.location.href='{{ route('admin.shared_customers.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => request('sort') === 'email' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
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
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onclick="window.location.href='{{ route('admin.shared_customers.index', array_merge(request()->query(), ['sort' => 'phone', 'direction' => request('sort') === 'phone' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    No. Telepon
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
                                    onclick="window.location.href='{{ route('admin.shared_customers.index', array_merge(request()->query(), ['sort' => 'gender', 'direction' => request('sort') === 'gender' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    Jenis Kelamin
                                    @if(request('sort') === 'gender')
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
                                    onclick="window.location.href='{{ route('admin.shared_customers.index', array_merge(request()->query(), ['sort' => 'address', 'direction' => request('sort') === 'address' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    Alamat
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
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($customers as $c)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 {{ $c->trashed() ? 'bg-red-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $c->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $c->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $c->phone ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $c->gender === 'L' ? 'bg-blue-100 text-blue-800' :
                                            ($c->gender === 'P' ? 'bg-pink-100 text-pink-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ $c->gender === 'L' ? 'Laki-laki' : ($c->gender === 'P' ? 'Perempuan' : '-') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $c->address ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <x-dropdown-action 
                                            :editUrl="!$c->trashed() ? route('admin.shared_customers.edit', $c->id) : null"
                                            :deleteUrl="!$c->trashed() ? route('admin.shared_customers.destroy', $c->id) : null"
                                            :restoreUrl="$c->trashed() ? route('admin.shared_customers.restore', $c->id) : null" 
                                            :isRestore="$c->trashed()"/>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-center items-center text-center py-6">
                                            <div class="text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                </svg>
                                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data ditemukan</h3>
                                                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan pelanggan baru.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($customers->hasPages())
                    <div class="px-6 py-4 bg-white border-t border-gray-200">
                        {{ $customers->appends(request()->all())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
