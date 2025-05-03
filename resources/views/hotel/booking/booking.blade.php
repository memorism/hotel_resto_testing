<x-app-layout>
    {{-- header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Data Transaksi Keseluruhan') }}
            </h2>
            <a href="{{ route('hotel.booking.create') }}" class="btn btn-primary">
                Tambah Data
            </a>
        </div>
    </x-slot>

    {{-- isi --}}
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <div class="min-w-full align-middle">

                        {{-- Filter dan Pencarian --}}
                        <div class="mb-6">
                            <form action="{{ route('hotel.booking.index') }}" method="GET"
                                class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

                                {{-- Booking ID --}}
                                <div>
                                    <label for="booking_id" class="block text-sm text-gray-700 mb-1">Cari Booking
                                        ID:</label>
                                    <input type="text" name="booking_id" id="booking_id"
                                        value="{{ request('booking_id') }}"
                                        class="w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>

                                {{-- Dari Tanggal --}}
                                <div>
                                    <label for="start_date" class="block text-sm text-gray-700 mb-1">Dari
                                        Tanggal:</label>
                                    <input type="date" name="start_date" id="start_date"
                                        value="{{ request('start_date') }}"
                                        class="w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>

                                {{-- Sampai Tanggal --}}
                                <div>
                                    <label for="end_date" class="block text-sm text-gray-700 mb-1">Sampai
                                        Tanggal:</label>
                                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                        class="w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>

                                {{-- Per Page --}}
                                <div>
                                    <label for="per_page" class="block text-sm text-gray-700 mb-1">Tampilkan:</label>
                                    <select name="per_page" id="per_page"
                                        class="w-full rounded-md border-gray-300 shadow-sm px-4 py-2 text-sm">
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="semua" {{ request('per_page') == 'semua' ? 'selected' : '' }}>Semua
                                        </option>
                                    </select>
                                </div>

                                {{-- Tombol Submit --}}
                                <div>
                                    <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md text-sm">
                                        Filter / Cari
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Tabel --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full border divide-y divide-gray-200 table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="text-center px-4 py-2">No</th>
                                        <th class="text-center px-4 py-2">Nama File</th>
                                        <th class="text-center px-4 py-2">ID Pemesanan</th>
                                        <th class="text-center px-4 py-2">Dewasa</th>
                                        <th class="text-center px-4 py-2">Anak-anak</th>
                                        <th class="text-center px-4 py-2">Weekend Nights</th>
                                        <th class="text-center px-4 py-2">Week Nights</th>
                                        <th class="text-center px-4 py-2">Paket Makanan</th>
                                        <th class="text-center px-4 py-2">Parkir</th>
                                        <th class="text-center px-4 py-2">Tipe Kamar</th>
                                        <th class="text-center px-4 py-2">Lead Time</th>
                                        <th class="text-center px-4 py-2">Tahun</th>
                                        <th class="text-center px-4 py-2">Bulan</th>
                                        <th class="text-center px-4 py-2">Tanggal</th>
                                        <th class="text-center px-4 py-2">Segmen</th>
                                        <th class="text-center px-4 py-2">Harga / Kamar</th>
                                        <th class="text-center px-4 py-2">Permintaan Khusus</th>
                                        <th class="text-center px-4 py-2">Status</th>
                                        <th class="text-center px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $index => $booking)
                                        <tr>
                                            <td class="text-center px-4 py-2">{{ $index + 1 }}</td>
                                            <td>
                                                {{ $booking->uploadLog?->file_name ?? '-' }}
                                            </td>
                                            <td class="text-center px-4 py-2">{{ $booking->booking_id }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_adults }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_children }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_weekend_nights }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_week_nights }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->type_of_meal_plan }}</td>
                                            <td class="text-center px-4 py-2">
                                                {{ $booking->required_car_parking_space ? 'Ya' : 'Tidak' }}
                                            </td>
                                            <td class="text-center px-4 py-2">{{ $booking->room_type_reserved }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->lead_time }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->arrival_year }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->arrival_month }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->arrival_date }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->market_segment_type }}</td>
                                            <td class="text-center px-4 py-2">
                                                {{ number_format($booking->avg_price_per_room, 2) }}
                                            </td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_special_requests }}</td>
                                            <td class="text-center px-4 py-2">
                                                @if($booking->booking_status === 'Canceled')
                                                    <span class="px-2 py-1 bg-red-500 text-white rounded-md">Dibatalkan</span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 bg-green-500 text-white rounded-md">Dikonfirmasi</span>
                                                @endif
                                            </td>
                                            <td class="text-center px-4 py-2">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('hotel.booking.edit', $booking->id) }}"
                                                        class="px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-md hover:bg-yellow-600">
                                                        Ubah
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('hotel.booking.destroy', $booking->id) }}"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination Links --}}
                        <div class="mt-4">
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>