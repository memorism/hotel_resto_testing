<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Data Transaksi') }}
            </h2>
            <a href="{{ route('hotel.frontoffice.booking.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                {{-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> --}}
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-600 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <!-- Filter Section -->
                    <div class="mb-6 bg-gray-50 rounded-xl border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Pencarian</h3>
                        <form action="{{ route('hotel.frontoffice.booking.index') }}" method="GET" id="filterForm">
                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                    <input type="text" name="nama" id="nama" value="{{ request('nama') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out"
                                        placeholder="Masukkan nama">
                                </div>

                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari
                                        Tanggal</label>
                                    <input type="date" name="start_date" id="start_date"
                                        value="{{ request('start_date') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out">
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai
                                        Tanggal</label>
                                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out">
                                </div>

                                <div>
                                    <label for="approval_status"
                                        class="block text-sm font-medium text-gray-700 mb-1">Status Approval</label>
                                    <select name="approval_status" id="approval_status"
                                        class="w-full rounded-lg border-gray-300 shadow-sm p-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        <option value="">Semua Status</option>
                                        <option value="approved" {{ request('approval_status') == 'approved' ? 'selected' : '' }}>
                                            Disetujui
                                        </option>
                                        <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>
                                            Menunggu
                                        </option>
                                        <option value="rejected" {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label for="per_page"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tampilkan</label>
                                    <select name="per_page" id="per_page"
                                        class="w-full rounded-lg border-gray-300 shadow-sm p-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Data</option>
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data
                                        </option>
                                        <option value="semua" {{ request('per_page') == 'semua' ? 'selected' : '' }}>Semua
                                            Data</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <script>
                        // Get all form inputs
                        const form = document.getElementById('filterForm');
                        const inputs = form.querySelectorAll('input, select');

                        // Add change event listener to each input
                        inputs.forEach(input => {
                            input.addEventListener('change', () => {
                                form.submit();
                            });
                        });

                        // Add input event listener for booking_id with debounce
                        const bookingIdInput = document.getElementById('booking_id');
                        let timeout = null;

                        bookingIdInput.addEventListener('input', () => {
                            // Clear the existing timeout
                            clearTimeout(timeout);

                            // Set a new timeout
                            timeout = setTimeout(() => {
                                form.submit();
                            }, 500); // Wait for 500ms after user stops typing
                        });
                    </script>

                    <!-- Table Section -->
                    <div class="overflow-x-auto border rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widercursor-pointer"
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'no', 'direction' => request('sort') == 'no' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'approval_status', 'direction' => request('sort') == 'approval_status' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Status
                                        @if (request('sort') == 'approval_status')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort') == 'customer_name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Customer
                                        @if (request('sort') == 'customer_name')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'no_of_adults', 'direction' => request('sort') == 'no_of_adults' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Dewasa
                                        @if (request('sort') == 'no_of_adults')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'no_of_children', 'direction' => request('sort') == 'no_of_children' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Anak
                                        @if (request('sort') == 'no_of_children')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'no_of_weekend_nights', 'direction' => request('sort') == 'no_of_weekend_nights' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Weekend
                                        @if (request('sort') == 'no_of_weekend_nights')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'no_of_week_nights', 'direction' => request('sort') == 'no_of_week_nights' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Weekday
                                        @if (request('sort') == 'no_of_week_nights')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'type_of_meal_plan', 'direction' => request('sort') == 'type_of_meal_plan' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Sarapan
                                        @if (request('sort') == 'type_of_meal_plan')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'required_car_parking_space', 'direction' => request('sort') == 'required_car_parking_space' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Parkir
                                        @if (request('sort') == 'required_car_parking_space')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'room_type_reserved', 'direction' => request('sort') == 'room_type_reserved' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Tipe
                                        @if (request('sort') == 'room_type_reserved')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'lead_time', 'direction' => request('sort') == 'lead_time' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Lead
                                        @if (request('sort') == 'lead_time')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'arrival_year', 'direction' => request('sort') == 'arrival_year' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Tahun
                                        @if (request('sort') == 'arrival_year')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'arrival_month', 'direction' => request('sort') == 'arrival_month' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Bulan
                                        @if (request('sort') == 'arrival_month')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'arrival_date', 'direction' => request('sort') == 'arrival_date' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Tanggal
                                        @if (request('sort') == 'arrival_date')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'market_segment_type', 'direction' => request('sort') == 'market_segment_type' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Segmen
                                        @if (request('sort') == 'market_segment_type')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'avg_price_per_room', 'direction' => request('sort') == 'avg_price_per_room' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Harga
                                        @if (request('sort') == 'avg_price_per_room')
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
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'no_of_special_requests', 'direction' => request('sort') == 'no_of_special_requests' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Request
                                        @if (request('sort') == 'no_of_special_requests')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        onclick="window.location.href = '{{ route('hotel.frontoffice.booking.index', array_merge(request()->query(), ['sort' => 'booking_status', 'direction' => request('sort') == 'booking_status' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Status Pemesanan
                                        @if (request('sort') == 'booking_status')
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
                                @forelse($bookings as $index => $booking)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($booking->approval_status === 'approved')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Disetujui
                                                </span>
                                            @elseif ($booking->approval_status === 'pending')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Menunggu
                                                </span>
                                            @elseif ($booking->approval_status === 'rejected')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                                @if($booking->rejection_note)
                                                    <p class="text-xs text-red-500 mt-1">{{ $booking->rejection_note }}</p>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->customer?->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->no_of_adults }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->no_of_children }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->no_of_weekend_nights }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->no_of_week_nights }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($booking->type_of_meal_plan == 'breakfast')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Ya</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Tidak</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($booking->required_car_parking_space)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Ya</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Tidak</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->room_type_reserved }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->lead_time }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->arrival_year }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->arrival_month }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->arrival_date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->market_segment_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Rp {{ number_format($booking->avg_price_per_room, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->no_of_special_requests }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($booking->booking_status === 'Canceled')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Dibatalkan
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Dikonfirmasi
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <x-dropdown-action :edit-url="route('hotel.frontoffice.booking.edit', $booking)"
                                                :delete-url="route('hotel.frontoffice.booking.destroy', $booking)" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="19" class="px-6 py-8 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                <span>Tidak ada data booking.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $bookings->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>