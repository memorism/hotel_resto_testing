<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Models\HotelUploadLog;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;

        $perPage = $request->get('perPage', 10);
        $perPage = ($perPage === 'semua') ? HotelBooking::where('hotel_id', $hotelId)->count() : (int) $perPage;

        $search = $request->get('search', '');

        $bookings = HotelBooking::when($search, function ($query, $search) {
            return $query->where('booking_id', 'like', '%' . $search . '%');
        })
            ->where('hotel_id', $hotelId)
            ->paginate($perPage);

        return view('hotel.booking.booking', compact('bookings'));
    }

    public function create()
    {
        $hotelId = auth()->user()->hotel_id;
        $fileNames = HotelUploadLog::where('hotel_id', $hotelId)->pluck('file_name', 'file_name');
        return view('hotel.booking.create', compact('fileNames'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|string|max:255',
            'file_name' => 'required|string|max:255',
            'no_of_adults' => 'required|integer',
            'no_of_children' => 'required|integer',
            'no_of_weekend_nights' => 'required|integer',
            'no_of_week_nights' => 'required|integer',
            'type_of_meal_plan' => 'required|string|max:255',
            'required_car_parking_space' => 'required|boolean',
            'room_type_reserved' => 'required|string|max:255',
            'lead_time' => 'required|integer',
            'arrival_year' => 'required|integer',
            'arrival_month' => 'required|integer',
            'arrival_date' => 'required|integer',
            'market_segment_type' => 'required|string|max:255',
            'repeated_guest' => 'required|boolean',
            'no_of_previous_cancellations' => 'required|integer',
            'no_of_previous_bookings_not_canceled' => 'required|integer',
            'avg_price_per_room' => 'required|numeric',
            'no_of_special_requests' => 'required|integer',
            'booking_status' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $file = HotelUploadLog::where('hotel_id', $user->hotel_id)
            ->where('file_name', $validated['file_name'])
            ->first();

        if (!$file) {
            return redirect()->back()->with('error', 'File yang dipilih tidak valid atau tidak milik hotel Anda.');
        }

        $validated['hotel_upload_log_id'] = $file->id;
        $validated['user_id'] = $user->id;
        $validated['hotel_id'] = $user->hotel_id;

        HotelBooking::create($validated);

        return redirect()->route('hotel.booking.booking')->with('success', 'Booking berhasil dibuat!');
    }

    public function show($id)
    {
        $booking = HotelBooking::find($id);
        return response()->json($booking);
    }

    public function edit(HotelBooking $booking)
    {
        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.booking.booking')->with('error', 'Unauthorized access');
        }

        $fileNames = HotelUploadLog::where('hotel_id', auth()->user()->hotel_id)->pluck('file_name', 'file_name');
        return view('hotel.booking.edit', compact('booking', 'fileNames'));
    }

    public function update(Request $request, HotelBooking $booking)
    {
        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.booking.booking')->with('error', 'Unauthorized access');
        }

        $validated = $request->validate([
            'booking_id' => 'required|string|max:255',
            'file_name' => 'required|string|max:255',
            'no_of_adults' => 'required|integer',
            'no_of_children' => 'required|integer',
            'no_of_weekend_nights' => 'required|integer',
            'no_of_week_nights' => 'required|integer',
            'type_of_meal_plan' => 'required|string|max:255',
            'required_car_parking_space' => 'required|boolean',
            'room_type_reserved' => 'required|string|max:255',
            'lead_time' => 'required|integer',
            'arrival_year' => 'required|integer',
            'arrival_month' => 'required|integer',
            'arrival_date' => 'required|integer',
            'market_segment_type' => 'required|string|max:255',
            'repeated_guest' => 'required|boolean',
            'no_of_previous_cancellations' => 'required|integer',
            'no_of_previous_bookings_not_canceled' => 'required|integer',
            'avg_price_per_room' => 'required|numeric',
            'no_of_special_requests' => 'required|integer',
            'booking_status' => 'required|string|max:255',
        ]);

        $file = HotelUploadLog::where('hotel_id', auth()->user()->hotel_id)
            ->where('file_name', $validated['file_name'])
            ->first();

        if (!$file) {
            return redirect()->back()->with('error', 'File yang dipilih tidak valid atau tidak milik hotel Anda.');
        }

        $booking->update(array_merge($validated, [
            'hotel_upload_log_id' => $file->id
        ]));

        return redirect()->route('hotel.booking.booking')->with('success', 'Booking updated successfully!');
    }

    public function destroy($id)
    {
        $booking = HotelBooking::findOrFail($id);

        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.booking.booking')->with('error', 'Unauthorized access');
        }

        $booking->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('hotel.booking.booking')->with('success', 'Booking deleted successfully.');
    }
}
