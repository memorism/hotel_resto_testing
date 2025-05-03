<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Data Transaksi') }}
            </h2>
            <a href="{{ route('hotel.frontoffice.booking.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto">

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-6">
                    <form action="{{ route('hotel.frontoffice.booking.index') }}" method="GET"
                        class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

                        {{-- Booking ID --}}
                        <div>
                            <label for="booking_id" class="block text-sm text-gray-700 mb-1">Cari Booking ID:</label>
                            <input type="text" name="booking_id" id="booking_id" value="{{ request('booking_id') }}"
                                class="w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>

                        {{-- Dari Tanggal --}}
                        <div>
                            <label for="start_date" class="block text-sm text-gray-700 mb-1">Dari Tanggal:</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                class="w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>

                        {{-- Sampai Tanggal --}}
                        <div>
                            <label for="end_date" class="block text-sm text-gray-700 mb-1">Sampai Tanggal:</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                class="w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>

                        {{-- Per Page --}}
                        <div>
                            <label for="per_page" class="block text-sm text-gray-700 mb-1">Tampilkan:</label>
                            <select name="per_page" id="per_page"
                                class="  w-full rounded-md  border-gray-300 shadow-sm px-4 py-2 text-sm">
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



                <div  class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 whitespace-nowrap">No</th>
                                <th class="px-6 py-3 whitespace-nowrap">Booking ID</th>
                                <th class="px-6 py-3 whitespace-nowrap">Nama File</th>
                                <th class="px-6 py-3 whitespace-nowrap">Dewasa</th>
                                <th class="px-6 py-3 whitespace-nowrap">Arrival Date</th>
                                <th class="px-6 py-3 whitespace-nowrap">Status</th>
                                <th class="px-6 py-3 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr class="border-b">
                                    <td class="text-center px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->booking_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ optional($booking->uploadLog)->file_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->no_of_adults }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $booking->arrival_year }}-{{ $booking->arrival_month }}-{{ $booking->arrival_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->booking_status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('hotel.frontoffice.booking.edit', $booking->id) }}"
                                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm">Edit</a>
                                            <form action="{{ route('hotel.frontoffice.booking.destroy', $booking->id) }}"
                                                method="POST" onsubmit="return confirm('Yakin hapus booking ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data booking.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $bookings->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
</x-app-layout>