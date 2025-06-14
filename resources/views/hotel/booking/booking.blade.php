<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Data Transaksi Keseluruhan</h2>
            {{-- <a href="{{ route('hotel.booking.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                {{-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> --}}
                Tambah Data
            </a> --}}
        </div>
    </x-slot>

    <div class="py-6 ">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    <div class="min-w-full">
                        {{-- SEARCH BAR --}}
                        <form action="{{ route('hotel.booking.index') }}" method="GET" class="mb-6">
                            <label for="search_customer" class="sr-only">Cari Customer:</label>
                            <input type="text" name="search_customer" id="search_customer"
                                value="{{ request('search_customer') }}" placeholder="Cari nama customer..."
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2">
                        </form>

                        {{-- FILTER DROPDOWN & BULK ACTION --}}
                        <style>
                            .no-animation {
                                animation: none !important;
                                transition: none !important;
                                transform: none !important;
                            }

                            [x-cloak] {
                                display: none !important;
                            }
                        </style>
                        <div class="flex justify-between items-center mb-6 no-animation">
                            <div class="relative inline-block text-left no-animation" x-data="{ open: false }"
                                @click.outside="open = false">
                                <div class="no-animation">
                                    <button type="button" @click="open = !open"
                                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 no-animation"
                                        id="options-menu" aria-haspopup="true" aria-expanded="true">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Filter Data
                                    </button>
                                </div>

                                <div x-show="open"
                                    class="origin-top-left absolute left-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 no-animation"
                                    style="display: none;">
                                    <div class="py-1" role="menu" aria-orientation="vertical"
                                        aria-labelledby="options-menu">
                                        <form action="{{ route('hotel.booking.index') }}" method="GET"
                                            class="p-4 space-y-4">
                                            @if (request('search_customer'))
                                                <input type="hidden" name="search_customer"
                                                    value="{{ request('search_customer') }}">
                                            @endif
                                            <div class="space-y-1">
                                                <label for="status"
                                                    class="block text-sm font-medium text-gray-700">Status:</label>
                                                <select name="status" id="status"
                                                    class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                    <option value="">Semua Status</option>
                                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                        Tunggu</option>
                                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                                        Setujui</option>
                                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                                        Tolak</option>
                                                </select>
                                            </div>
                                            <div class="space-y-1">
                                                <label for="start_date"
                                                    class="block text-sm font-medium text-gray-700">Dari
                                                    Tanggal:</label>
                                                <input type="date" name="start_date" id="start_date"
                                                    value="{{ request('start_date') }}"
                                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            </div>
                                            <div class="space-y-1">
                                                <label for="end_date"
                                                    class="block text-sm font-medium text-gray-700">Sampai
                                                    Tanggal:</label>
                                                <input type="date" name="end_date" id="end_date"
                                                    value="{{ request('end_date') }}"
                                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            </div>
                                            <div class="space-y-1">
                                                <label for="per_page"
                                                    class="block text-sm font-medium text-gray-700">Tampilkan:</label>
                                                <select name="per_page" id="per_page"
                                                    class="w-full p-2 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5
                                                        Data</option>
                                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>
                                                        10 Data</option>
                                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>
                                                        25 Data</option>
                                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>
                                                        50 Data</option>
                                                    <option value="semua" {{ request('per_page') == 'semua' ? 'selected' : '' }}>Semua Data</option>
                                                </select>
                                            </div>

                                            <div class="flex justify-end space-x-2 mt-4">
                                                <button type="button"
                                                    @click="open = false; window.location.href = '{{ route('hotel.booking.index') }}'"
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

                            {{-- TOMBOL BULK ACTION --}}
                            <div class="flex gap-3 items-center min-w-fit no-animation">
                                <form method="POST" action="{{ route('hotel.booking.bulkApprove') }}"
                                    id="bulkApproveForm" class="no-animation">
                                    @csrf
                                    <button type="submit" onclick="return handleBulkApprove()"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 no-animation">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Approve Terpilih
                                    </button>
                                </form>
                                <button type="button" onclick="openBulkRejectModal()"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 no-animation">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak Terpilih
                                </button>
                            </div>
                        </div>

                        {{-- TABLE DATA --}}
                        <form id="bulkWrapper">
                            <div class="overflow-x-auto border rounded-xl">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-center">
                                                <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            </th>
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                No</th>
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Status</th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.booking.index', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort') == 'customer_name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
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
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.booking.index', array_merge(request()->query(), ['sort' => 'no_of_adults', 'direction' => request('sort') == 'no_of_adults' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
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
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.booking.index', array_merge(request()->query(), ['sort' => 'no_of_children', 'direction' => request('sort') == 'no_of_children' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
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
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Weekend</th>
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Weekday</th>
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Sarapan</th>
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Parkir</th>
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Tipe Kamar</th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.booking.index', array_merge(request()->query(), ['sort' => 'lead_time', 'direction' => request('sort') == 'lead_time' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                                Lead Time
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
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.booking.index', array_merge(request()->query(), ['sort' => 'arrival_year', 'direction' => request('sort') == 'arrival_year' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
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
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.booking.index', array_merge(request()->query(), ['sort' => 'arrival_month', 'direction' => request('sort') == 'arrival_month' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
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
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.booking.index', array_merge(request()->query(), ['sort' => 'arrival_date', 'direction' => request('sort') == 'arrival_date' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
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
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Segmen</th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.booking.index', array_merge(request()->query(), ['sort' => 'avg_price_per_room', 'direction' => request('sort') == 'avg_price_per_room' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                                Harga/Kamar
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
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Permintaan</th>
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Status Pemesanan</th>
                                            <th
                                                class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($bookings as $index => $booking)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($booking->approval_status === 'pending')

                                                        <input type="checkbox" name="selected_bookings[]"
                                                            value="{{ $booking->id }}"
                                                            class="booking-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">{{ $index + 1 }}
                                                </td>
                                                <td class="px-4 py-3 text-center">
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
                                                        <div class="space-y-1">
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                Ditolak
                                                            </span>
                                                            @if ($booking->rejection_note)
                                                                <div class="text-xs text-gray-500 italic">
                                                                    "{{ $booking->rejection_note }}"
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->customer->name ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->no_of_adults }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->no_of_children }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->no_of_weekend_nights }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->no_of_week_nights }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->type_of_meal_plan == 'breakfast' ? 'Ya' : 'Tidak' }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->required_car_parking_space ? 'Ya' : 'Tidak' }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->room_type_reserved }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->lead_time }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->arrival_year }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->arrival_month }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->arrival_date }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->market_segment_type }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ number_format($booking->avg_price_per_room, 2) }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                    {{ $booking->no_of_special_requests }}
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    @if ($booking->booking_status === 'Canceled')
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
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <a href="{{ route('hotel.booking.edit', $booking->id) }}"
                                                            class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>
                                                        <form method="POST"
                                                            action="{{ route('hotel.booking.destroy', $booking->id) }}"
                                                            class="inline-block"
                                                            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tolak --}}
    <div id="bulkRejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Tolak Booking Terpilih</h2>
                <button type="button" onclick="closeBulkRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('hotel.booking.bulkReject') }}">
                @csrf
                <div id="selectedBookingsContainer"></div>
                <div class="mb-6">
                    <label for="bulk_rejection_note" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Penolakan:
                    </label>
                    <textarea name="rejection_note" id="bulk_rejection_note" rows="4" required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none"
                        placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeBulkRejectModal()"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                        Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSelectAll(source) {
            document.querySelectorAll('.booking-checkbox').forEach(checkbox => {
                checkbox.checked = source.checked;
            });
        }

        function handleBulkApprove() {
            const checkboxes = document.querySelectorAll('.booking-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Silakan pilih minimal satu booking terlebih dahulu.');
                return false;
            }

            const form = document.getElementById('bulkApproveForm');
            form.querySelectorAll('input[name="selected_bookings[]"]').forEach(e => e.remove());

            checkboxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_bookings[]';
                input.value = checkbox.value;
                form.appendChild(input);
            });

            return confirm('Yakin ingin menyetujui booking yang dipilih?');
        }

        function openBulkRejectModal() {
            const checkboxes = document.querySelectorAll('.booking-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Silakan pilih minimal satu booking terlebih dahulu.');
                return;
            }

            const container = document.getElementById('selectedBookingsContainer');
            container.innerHTML = '';

            checkboxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_bookings[]';
                input.value = checkbox.value;
                container.appendChild(input);
            });

            document.getElementById('bulkRejectModal').classList.remove('hidden');
        }

        function closeBulkRejectModal() {
            document.getElementById('bulkRejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>