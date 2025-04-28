<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Booking') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('hotel.frontoffice.booking.update', $booking->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Booking ID</label>
                            <input type="text" name="booking_id" value="{{ $booking->booking_id }}" class="w-full rounded-md border-gray-300 shadow-sm" readonly>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Jumlah Dewasa</label>
                            <input type="number" name="no_of_adults" min="1" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('no_of_adults', $booking->no_of_adults) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Jumlah Anak</label>
                            <input type="number" name="no_of_children" min="0" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('no_of_children', $booking->no_of_children) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Jumlah Malam Weekend</label>
                            <input type="number" name="no_of_weekend_nights" min="0" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('no_of_weekend_nights', $booking->no_of_weekend_nights) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Jumlah Malam Weekday</label>
                            <input type="number" name="no_of_week_nights" min="0" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('no_of_week_nights', $booking->no_of_week_nights) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Meal Plan</label>
                            <input type="text" name="type_of_meal_plan" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('type_of_meal_plan', $booking->type_of_meal_plan) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Perlu Parkir?</label>
                            <select name="required_car_parking_space" class="w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="1" {{ $booking->required_car_parking_space == 1 ? 'selected' : '' }}>Ya</option>
                                <option value="0" {{ $booking->required_car_parking_space == 0 ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Tipe Kamar</label>
                            <input type="text" name="room_type_reserved" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('room_type_reserved', $booking->room_type_reserved) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Lead Time (Hari)</label>
                            <input type="number" name="lead_time" min="0" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('lead_time', $booking->lead_time) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Tahun Kedatangan</label>
                            <input type="number" name="arrival_year" min="2000" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('arrival_year', $booking->arrival_year) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Bulan Kedatangan</label>
                            <input type="number" name="arrival_month" min="1" max="12" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('arrival_month', $booking->arrival_month) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Tanggal Kedatangan</label>
                            <input type="number" name="arrival_date" min="1" max="31" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('arrival_date', $booking->arrival_date) }}" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium text-sm text-gray-700">Segmentasi Pasar</label>
                            <input type="text" name="market_segment_type" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('market_segment_type', $booking->market_segment_type) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Harga Rata-rata per Kamar</label>
                            <input type="number" step="0.01" name="avg_price_per_room" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('avg_price_per_room', $booking->avg_price_per_room) }}" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Jumlah Permintaan Khusus</label>
                            <input type="number" name="no_of_special_requests" min="0" class="w-full rounded-md border-gray-300 shadow-sm" value="{{ old('no_of_special_requests', $booking->no_of_special_requests) }}" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium text-sm text-gray-700">Status Booking</label>
                            <select name="booking_status" class="w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="Not_Canceled" {{ $booking->booking_status == 'Not_Canceled' ? 'selected' : '' }}>Not Canceled</option>
                                <option value="Canceled" {{ $booking->booking_status == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('hotel.frontoffice.booking.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-400">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
