<x-app-layout>
    {{-- header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Data Bookings') }}
            </h2>
            <a href="" class="btn btn-primary">
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
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center">
                                <label for="perPage" class="mr-2">Tampilkan</label>
                                <select id="perPage" class="form-select form-select-sm"
                                    onchange="window.location.href=this.value">
                                    <option value="{{ route('hotel.booking.booking', ['perPage' => 10]) }}" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="{{ route('hotel.booking.booking', ['perPage' => 20]) }}" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="{{ route('hotel.booking.booking', ['perPage' => 50]) }}" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                </select>
                                <label for="perPage" class="ml-2">data</label>
                            </div>

                            {{-- Pencarian --}}
                            <div class="flex items-center">
                                <form action="{{ route('hotel.booking.booking') }}" method="GET">
                                    <input type="text" name="search" id="search" class="form-input form-input-sm"
                                        placeholder="Search by Booking ID" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary btn-sm ml-2">Search</button>
                                </form>
                            </div>
                        </div>

                        {{-- Tabel --}}
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="text-center px-4 py-2">No</th>
                                    <th class="text-center px-4 py-2">Booking ID</th>
                                    <th class="text-center px-4 py-2">No. of Adults</th>
                                    <th class="text-center px-4 py-2">No. of Children</th>
                                    <th class="text-center px-4 py-2">Lead Time</th>
                                    <th class="text-center px-4 py-2">Booking Status</th>
                                    <th class="text-center px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $index => $booking)
                                    <tr>
                                        <td class="text-center px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="text-center px-4 py-2">{{ $booking->booking_id }}</td>
                                        <td class="text-center px-4 py-2">{{ $booking->no_of_adults }}</td>
                                        <td class="text-center px-4 py-2">{{ $booking->no_of_children }}</td>
                                        <td class="text-center px-4 py-2">{{ $booking->lead_time }} days</td>
                                        <td class="text-center px-4 py-2">
                                            @if($booking->booking_status == 'Canceled')
                                                <span class="px-2 py-1 bg-red-500 text-white rounded-md">Canceled</span>
                                            @else
                                                <span class="px-2 py-1 bg-green-500 text-white rounded-md">Confirmed</span>
                                            @endif
                                        </td>
                                        <td class="text-center px-4 py-2">
                                            <form action="{{ route('hotel.booking.destroy', $booking->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination Links --}}
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>