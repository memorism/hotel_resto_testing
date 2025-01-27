<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Models\UploadOrder;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $perPage = $request->get('perPage', 10);

        $search = $request->get('search', '');

        $bookings = Booking::when($search, function ($query, $search) {
            return $query->where('booking_id', 'like', '%' . $search . '%');
        })
            ->where('user_id', $userId)
            ->paginate($perPage);

        return view('hotel.booking.booking', compact('bookings'));
    }


    public function create()
    {
        // Ambil file yang diupload oleh pengguna yang login
        $fileNames = UploadOrder::where('user_id', auth()->id())->pluck('file_name', 'file_name');
        
        return view('hotel.booking.create', compact('fileNames'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'booking_id' => 'required|string|max:255',
            'file_name' => 'required|string|max:255', // file_name yang dipilih
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

        // Pastikan file yang dipilih milik pengguna yang sedang login
        $file = UploadOrder::where('user_id', auth()->id())
                            ->where('file_name', $validated['file_name'])
                            ->first();

        if (!$file) {
            return redirect()->back()->with('error', 'File yang dipilih tidak valid atau tidak milik Anda.');
        }

        // Simpan data booking dan nama file yang dipilih
        Booking::create([
            'booking_id' => $validated['booking_id'],
            'file_name' => $validated['file_name'], // Nama file yang dipilih
            'no_of_adults' => $validated['no_of_adults'],
            'no_of_children' => $validated['no_of_children'],
            'no_of_weekend_nights' => $validated['no_of_weekend_nights'],
            'no_of_week_nights' => $validated['no_of_week_nights'],
            'type_of_meal_plan' => $validated['type_of_meal_plan'],
            'required_car_parking_space' => $validated['required_car_parking_space'],
            'room_type_reserved' => $validated['room_type_reserved'],
            'lead_time' => $validated['lead_time'],
            'arrival_year' => $validated['arrival_year'],
            'arrival_month' => $validated['arrival_month'],
            'arrival_date' => $validated['arrival_date'],
            'market_segment_type' => $validated['market_segment_type'],
            'repeated_guest' => $validated['repeated_guest'],
            'no_of_previous_cancellations' => $validated['no_of_previous_cancellations'],
            'no_of_previous_bookings_not_canceled' => $validated['no_of_previous_bookings_not_canceled'],
            'avg_price_per_room' => $validated['avg_price_per_room'],
            'no_of_special_requests' => $validated['no_of_special_requests'],
            'booking_status' => $validated['booking_status'],
            'user_id' => auth()->id(), // Menambahkan user_id yang sesuai dengan pengguna yang login
        ]);

        return redirect()->route('hotel.booking.booking')->with('success', 'Booking created successfully!');
    }



    public function show($id)
    {
        $id = Booking::find($id);
        return response()->json($id);
    }

    public function edit(Booking $booking)
    {
        // Pastikan booking milik user yang login
        if ($booking->user_id != auth()->id()) {
            return redirect()->route('hotel.booking.booking')->with('error', 'Unauthorized access');
        }

        $fileNames = UploadOrder::where('user_id', auth()->id())->pluck('file_name', 'file_name');
        return view('hotel.booking.edit', compact('booking', 'fileNames'));
    }



    public function update(Request $request, Booking $booking)
    {
        // Pastikan booking milik user yang login
        if ($booking->user_id != auth()->id()) {
            return redirect()->route('hotel.booking.booking')->with('error', 'Unauthorized access');
        }

        // Validasi data yang diterima
        $validated = $request->validate([
            'booking_id' => 'required|string|max:255',
            'file_name' => 'required|string|max:255', // file_name yang dipilih
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

        // Pastikan file yang dipilih milik pengguna yang sedang login
        $file = UploadOrder::where('user_id', auth()->id())
                            ->where('file_name', $validated['file_name'])
                            ->first();

        if (!$file) {
            return redirect()->back()->with('error', 'File yang dipilih tidak valid atau tidak milik Anda.');
        }

        // Update data booking
        $booking->update([
            'booking_id' => $validated['booking_id'],
            'file_name' => $validated['file_name'],
            'no_of_adults' => $validated['no_of_adults'],
            'no_of_children' => $validated['no_of_children'],
            'no_of_weekend_nights' => $validated['no_of_weekend_nights'],
            'no_of_week_nights' => $validated['no_of_week_nights'],
            'type_of_meal_plan' => $validated['type_of_meal_plan'],
            'required_car_parking_space' => $validated['required_car_parking_space'],
            'room_type_reserved' => $validated['room_type_reserved'],
            'lead_time' => $validated['lead_time'],
            'arrival_year' => $validated['arrival_year'],
            'arrival_month' => $validated['arrival_month'],
            'arrival_date' => $validated['arrival_date'],
            'market_segment_type' => $validated['market_segment_type'],
            'repeated_guest' => $validated['repeated_guest'],
            'no_of_previous_cancellations' => $validated['no_of_previous_cancellations'],
            'no_of_previous_bookings_not_canceled' => $validated['no_of_previous_bookings_not_canceled'],
            'avg_price_per_room' => $validated['avg_price_per_room'],
            'no_of_special_requests' => $validated['no_of_special_requests'],
            'booking_status' => $validated['booking_status'],
            // user_id tetap sama, tidak diubah
        ]);

        return redirect()->route('hotel.booking.booking')->with('success', 'Booking updated successfully!');
    }


    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('hotel.booking.booking')->with('success', 'Booking deleted successfully.');
    }


}
