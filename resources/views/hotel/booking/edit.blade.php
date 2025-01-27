<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('hotel.booking.update', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- File Name -->
                            <div class="form-group">
                                <label for="file_name" class="block text-sm font-medium text-gray-700">File Name</label>
                                <input type="text" name="file_name" id="file_name" class="form-control"
                                    value="{{ $booking->uploadOrder->file_name }}" readonly>
                            </div>

                            <!-- Booking ID -->
                            <div class="form-group">
                                <label for="booking_id" class="block text-sm font-medium text-gray-700">Booking ID</label>
                                <input type="text" name="booking_id" id="booking_id" class="form-control"
                                    value="{{ $booking->booking_id }}" readonly>
                            </div>

                            <!-- No of Adults -->
                            <div class="form-group">
                                <label for="no_of_adults" class="block text-sm font-medium text-gray-700">No of Adults</label>
                                <input type="number" name="no_of_adults" id="no_of_adults" class="form-control"
                                    value="{{ $booking->no_of_adults }}" required>
                            </div>

                            <!-- No of Children -->
                            <div class="form-group">
                                <label for="no_of_children" class="block text-sm font-medium text-gray-700">No of Children</label>
                                <input type="number" name="no_of_children" id="no_of_children" class="form-control"
                                    value="{{ $booking->no_of_children }}" required>
                            </div>

                            <!-- No of Weekend Nights -->
                            <div class="form-group">
                                <label for="no_of_weekend_nights" class="block text-sm font-medium text-gray-700">No of Weekend Nights</label>
                                <input type="number" name="no_of_weekend_nights" id="no_of_weekend_nights"
                                    class="form-control" value="{{ $booking->no_of_weekend_nights }}" required>
                            </div>

                            <!-- No of Week Nights -->
                            <div class="form-group">
                                <label for="no_of_week_nights" class="block text-sm font-medium text-gray-700">No of Week Nights</label>
                                <input type="number" name="no_of_week_nights" id="no_of_week_nights" class="form-control"
                                    value="{{ $booking->no_of_week_nights }}" required>
                            </div>

                            <!-- Type of Meal Plan -->
                            <div class="form-group">
                                <label for="type_of_meal_plan" class="block text-sm font-medium text-gray-700">Type of Meal Plan</label>
                                <input type="text" name="type_of_meal_plan" id="type_of_meal_plan" class="form-control"
                                    value="{{ $booking->type_of_meal_plan }}" required>
                            </div>

                            <!-- Required Car Parking Space -->
                            <div class="form-group">
                                <label for="required_car_parking_space" class="block text-sm font-medium text-gray-700">Required Car Parking Space</label>
                                <select name="required_car_parking_space" id="required_car_parking_space"
                                    class="form-control" required>
                                    <option value="1" {{ $booking->required_car_parking_space == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $booking->required_car_parking_space == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <!-- Room Type Reserved -->
                            <div class="form-group">
                                <label for="room_type_reserved" class="block text-sm font-medium text-gray-700">Room Type Reserved</label>
                                <input type="text" name="room_type_reserved" id="room_type_reserved" class="form-control"
                                    value="{{ $booking->room_type_reserved }}" required>
                            </div>

                            <!-- Lead Time -->
                            <div class="form-group">
                                <label for="lead_time" class="block text-sm font-medium text-gray-700">Lead Time</label>
                                <input type="number" name="lead_time" id="lead_time" class="form-control"
                                    value="{{ $booking->lead_time }}" required>
                            </div>

                            <!-- Arrival Year -->
                            <div class="form-group">
                                <label for="arrival_year" class="block text-sm font-medium text-gray-700">Arrival Year</label>
                                <input type="number" name="arrival_year" id="arrival_year" class="form-control"
                                    value="{{ $booking->arrival_year }}" required>
                            </div>

                            <!-- Arrival Month -->
                            <div class="form-group">
                                <label for="arrival_month" class="block text-sm font-medium text-gray-700">Arrival Month</label>
                                <input type="number" name="arrival_month" id="arrival_month" class="form-control"
                                    value="{{ $booking->arrival_month }}" required>
                            </div>

                            <!-- Arrival Date -->
                            <div class="form-group">
                                <label for="arrival_date" class="block text-sm font-medium text-gray-700">Arrival Date</label>
                                <input type="number" name="arrival_date" id="arrival_date" class="form-control"
                                    value="{{ $booking->arrival_date }}" required>
                            </div>

                            <!-- Market Segment Type -->
                            <div class="form-group">
                                <label for="market_segment_type" class="block text-sm font-medium text-gray-700">Market Segment Type</label>
                                <input type="text" name="market_segment_type" id="market_segment_type" class="form-control"
                                    value="{{ $booking->market_segment_type }}" required>
                            </div>

                            <!-- Repeated Guest -->
                            <div class="form-group">
                                <label for="repeated_guest" class="block text-sm font-medium text-gray-700">Repeated Guest</label>
                                <select name="repeated_guest" id="repeated_guest" class="form-control" required>
                                    <option value="1" {{ $booking->repeated_guest == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $booking->repeated_guest == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <!-- No of Previous Cancellations -->
                            <div class="form-group">
                                <label for="no_of_previous_cancellations" class="block text-sm font-medium text-gray-700">No of Previous Cancellations</label>
                                <input type="number" name="no_of_previous_cancellations" id="no_of_previous_cancellations"
                                    class="form-control" value="{{ $booking->no_of_previous_cancellations }}" required>
                            </div>

                            <!-- No of Previous Bookings Not Canceled -->
                            <div class="form-group">
                                <label for="no_of_previous_bookings_not_canceled" class="block text-sm font-medium text-gray-700">No of Previous Bookings Not Canceled</label>
                                <input type="number" name="no_of_previous_bookings_not_canceled"
                                    id="no_of_previous_bookings_not_canceled" class="form-control"
                                    value="{{ $booking->no_of_previous_bookings_not_canceled }}" required>
                            </div>

                            <!-- Average Price Per Room -->
                            <div class="form-group">
                                <label for="avg_price_per_room" class="block text-sm font-medium text-gray-700">Average Price Per Room</label>
                                <input type="number" name="avg_price_per_room" id="avg_price_per_room" class="form-control"
                                    value="{{ $booking->avg_price_per_room }}" required>
                            </div>

                            <!-- No of Special Requests -->
                            <div class="form-group">
                                <label for="no_of_special_requests" class="block text-sm font-medium text-gray-700">No of Special Requests</label>
                                <input type="number" name="no_of_special_requests" id="no_of_special_requests"
                                    class="form-control" value="{{ $booking->no_of_special_requests }}" required>
                            </div>

                            <!-- Booking Status -->
                            <div class="form-group">
                                <label for="booking_status" class="block text-sm font-medium text-gray-700">Booking Status</label>
                                <input type="text" name="booking_status" id="booking_status" class="form-control"
                                    value="{{ $booking->booking_status }}" required>
                            </div>

                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ url()->previous() }}"
                                class="ms-4 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md shadow-md">
                                {{ __('Kembali') }}
                            </a>

                            <button type="submit"
                                class="ms-4 px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-md shadow-md">
                                {{ __('Edit data') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
