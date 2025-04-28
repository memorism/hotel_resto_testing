<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Data Transaksi') }}
            </h2>
            <a href="{{ route('hotel.frontoffice.booking.create') }}" class="btn btn-primary">
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search & Filter --}}
            <form action="{{ route('hotel.frontoffice.booking.index') }}" method="GET" class="mb-6 flex flex-col md:flex-row items-center gap-4">
                <div>
                    <label class="block text-sm text-gray-600">Cari Booking ID:</label>
                    <input type="text" name="booking_id" value="{{ request('booking_id') }}" class="rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm text-gray-600">Dari Tanggal:</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm text-gray-600">Sampai Tanggal:</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="rounded-md border-gray-300 shadow-sm">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md mt-4 md:mt-6">
                    Filter / Cari
                </button>
            </form>

            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-gray-600 uppercase">
                        <tr>
                            <th class="px-6 py-3">Booking ID</th>
                            <th class="px-6 py-3">No. Dewasa</th>
                            <th class="px-6 py-3">Arrival Date</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr class="border-b">
                                <td class="px-6 py-4">{{ $booking->booking_id }}</td>
                                <td class="px-6 py-4">{{ $booking->no_of_adults }}</td>
                                <td class="px-6 py-4">{{ $booking->arrival_year }}-{{ $booking->arrival_month }}-{{ $booking->arrival_date }}</td>
                                <td class="px-6 py-4">{{ $booking->booking_status }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('hotel.frontoffice.booking.edit', $booking->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md">Edit</a>
                                    <form action="{{ route('hotel.frontoffice.booking.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin hapus booking ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data booking.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
