<x-app-layout>
    {{-- header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Data Bookings') }}
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
                        <div class="overflow-x-auto">
                            <table class="min-w-full border divide-y divide-gray-200 table-auto">
                                <thead class="bg-gray-50 sticky top-0 z-10">
                                    <tr>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">No</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">File Name</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Booking ID</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">No. of Adults
                                        </th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">No. of Children
                                        </th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">No. of Weekend
                                            Nights</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">No. of Week
                                            Nights</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Type of Meal Plan
                                        </th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Required Car
                                            Parking Space</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Room Type
                                            Reserved</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Lead Time</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Arrival Year</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Arrival Month
                                        </th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Arrival Date</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Market Segment
                                            Type</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Repeated Guest
                                        </th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">No. of Previous
                                            Cancellations</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">No. of Previous
                                            Bookings Not Canceled</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Avg Price Per
                                            Room</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">No. of Special
                                            Requests</th>
                                        <th class="text-center px-4 py-2" style="white-space: nowrap;">Booking Status
                                        </th>
                                        <th class="text-center px-4 py-2 sticky right-0 bg-white"
                                            style="white-space: nowrap;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $index => $booking)
                                        <tr>
                                            <td class="text-center px-4 py-2">{{ $index + 1 }}</td>
                                            <td class="text-center px-4 py-2">
                                                {{ $booking->uploadOrder->file_name }}
                                            </td>
                                            <td class="text-center px-4 py-2">{{ $booking->booking_id }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_adults }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_children }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_weekend_nights }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_week_nights }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->type_of_meal_plan }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->required_car_parking_space }}
                                            </td>
                                            <td class="text-center px-4 py-2">{{ $booking->room_type_reserved }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->lead_time }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->arrival_year }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->arrival_month }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->arrival_date }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->market_segment_type }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->repeated_guest }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_previous_cancellations }}
                                            </td>
                                            <td class="text-center px-4 py-2">
                                                {{ $booking->no_of_previous_bookings_not_canceled }}
                                            </td>
                                            <td class="text-center px-4 py-2">{{ $booking->avg_price_per_room }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_special_requests }}</td>
                                            <td class="text-center px-4 py-2">
                                                @if($booking->booking_status == 'Canceled')
                                                    <span class="px-2 py-1 bg-red-500 text-white rounded-md">Canceled</span>
                                                @else
                                                    <span class="px-2 py-1 bg-green-500 text-white rounded-md">Confirmed</span>
                                                @endif
                                            </td>

                                            <td class="text-center px-4 py-2 sticky right-0 bg-white">
                                                <div class="flex justify-center gap-2">

                                                    <!-- Tombol Update -->
                                                    {{-- {{ route('hotel.databooking.edit', $uploadOrder->id) }} --}}
                                                    <a href="{{ route('hotel.booking.edit', $booking->id) }}"
                                                        class="px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-md hover:bg-yellow-600 text-decoration-none">
                                                        Update
                                                    </a>

                                                    <!-- Tombol Delete -->
                                                    <form method="POST"
                                                        action="{{ route('hotel.booking.destroy', $booking->id) }}"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600">
                                                            Delete
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
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>