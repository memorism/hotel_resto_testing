<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Daftar Pelanggan Hotel') }}
            </h2>
            <a href="{{ route('hotel.frontoffice.shared_customers.create_hotel') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                {{-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> --}}
                Tambah Pelanggan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <!-- Search Section -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('hotel.frontoffice.shared_customers.index_hotel') }}"
                            id="searchForm">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama pelanggan..."
                                    class="w-full rounded-lg border-gray-300 shadow-sm pl-10 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out"
                                    id="searchInput">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Table Section -->
                    <div class="overflow-x-auto border rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.shared_customers.index_hotel', array_merge(request()->query(), ['sort' => 'no', 'direction' => request('sort') == 'no' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.shared_customers.index_hotel', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Nama
                                        @if (request('sort') == 'name')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.shared_customers.index_hotel', array_merge(request()->query(), ['sort' => 'email', 'direction' => request('sort') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Email
                                        @if (request('sort') == 'email')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.shared_customers.index_hotel', array_merge(request()->query(), ['sort' => 'phone', 'direction' => request('sort') == 'phone' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        No. Telepon
                                        @if (request('sort') == 'phone')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.shared_customers.index_hotel', array_merge(request()->query(), ['sort' => 'gender', 'direction' => request('sort') == 'gender' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Jenis Kelamin
                                        @if (request('sort') == 'gender')
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
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($customers as $c)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $c->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $c->email ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $c->phone ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
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
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <x-dropdown-action
                                                :edit-url="route('hotel.frontoffice.shared_customers.edit_hotel', $c->id)" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                <span>Tidak ada pelanggan ditemukan.</span>
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

    <script>
        // Auto-submit search form with debounce
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        let timeout = null;

        searchInput.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                searchForm.submit();
            }, 500);
        });
    </script>
</x-app-layout>