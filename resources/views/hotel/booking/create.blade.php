<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('hotel.booking.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Booking ID and File Name -->
                            <div class="form-group">
                                <label for="booking_id">Booking ID</label>
                                <input type="text" name="booking_id" id="booking_id" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="file_name">File Name</label>
                                <select name="file_name" id="file_name" class="form-control" required>
                                    <option value="" disabled selected>Pilih File</option>
                                    @foreach ($fileNames as $fileName)
                                        <option value="{{ $fileName }}" >{{ $fileName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- No of Adults and No of Children -->
                            <div class="form-group">
                                <label for="no_of_adults">No of Adults</label>
                                <input type="number" name="no_of_adults" id="no_of_adults" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="no_of_children">No of Children</label>
                                <input type="number" name="no_of_children" id="no_of_children" class="form-control" required>
                            </div>

                            <!-- No of Weekend Nights and Week Nights -->
                            <div class="form-group">
                                <label for="no_of_weekend_nights">No of Weekend Nights</label>
                                <input type="number" name="no_of_weekend_nights" id="no_of_weekend_nights" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="no_of_week_nights">No of Week Nights</label>
                                <input type="number" name="no_of_week_nights" id="no_of_week_nights" class="form-control" required>
                            </div>

                            <!-- Type of Meal Plan and Required Car Parking Space -->
                            <div class="form-group">
                                <label for="type_of_meal_plan">Type of Meal Plan</label>
                                <input type="text" name="type_of_meal_plan" id="type_of_meal_plan" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="required_car_parking_space">Required Car Parking Space</label>
                                <select name="required_car_parking_space" id="required_car_parking_space" class="form-control" required>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <!-- Room Type Reserved and Lead Time -->
                            <div class="form-group">
                                <label for="room_type_reserved">Room Type Reserved</label>
                                <input type="text" name="room_type_reserved" id="room_type_reserved" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="lead_time">Lead Time</label>
                                <input type="number" name="lead_time" id="lead_time" class="form-control" required>
                            </div>

                            <!-- Arrival Year, Month, Date -->
                            <div class="form-group">
                                <label for="arrival_year">Arrival Year</label>
                                <input type="number" name="arrival_year" id="arrival_year" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="arrival_month">Arrival Month</label>
                                <input type="number" name="arrival_month" id="arrival_month" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="arrival_date">Arrival Date</label>
                                <input type="number" name="arrival_date" id="arrival_date" class="form-control" required>
                            </div>

                            <!-- Market Segment Type and Repeated Guest -->
                            <div class="form-group">
                                <label for="market_segment_type">Market Segment Type</label>
                                <input type="text" name="market_segment_type" id="market_segment_type" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="repeated_guest">Repeated Guest</label>
                                <select name="repeated_guest" id="repeated_guest" class="form-control" required>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <!-- Previous Cancellations, Not Canceled, and Avg Price -->
                            <div class="form-group">
                                <label for="no_of_previous_cancellations">No of Previous Cancellations</label>
                                <input type="number" name="no_of_previous_cancellations" id="no_of_previous_cancellations" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="no_of_previous_bookings_not_canceled">No of Previous Bookings Not Canceled</label>
                                <input type="number" name="no_of_previous_bookings_not_canceled" id="no_of_previous_bookings_not_canceled" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="avg_price_per_room">Average Price Per Room</label>
                                <input type="number" name="avg_price_per_room" id="avg_price_per_room" class="form-control" required>
                            </div>

                            <!-- Special Requests and Booking Status -->
                            <div class="form-group">
                                <label for="no_of_special_requests">No of Special Requests</label>
                                <input type="number" name="no_of_special_requests" id="no_of_special_requests" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="booking_status">Booking Status</label>
                                <input type="text" name="booking_status" id="booking_status" class="form-control" required>
                            </div>
                        </div>

                        <!-- Buttons Section -->
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ url()->previous() }}"
                                class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md shadow-md">
                                {{ __('Kembali') }}
                            </a>
                            
                            <button type="submit"
                                class="ms-4 px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-md shadow-md ml-auto">
                                {{ __('Tambah Data') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
