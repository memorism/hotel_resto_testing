<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Http\Controllers\Controller;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user yang sedang login
        $userId = auth()->id(); // ID user yang sedang login
    
        // Ambil parameter jumlah data per halaman (default 10)
        $perPage = $request->get('perPage', 10);
    
        // Ambil query pencarian jika ada
        $search = $request->get('search', '');
    
        // Query untuk mengambil data bookings, filter berdasarkan search dan user_id
        $bookings = Booking::when($search, function ($query, $search) {
            return $query->where('booking_id', 'like', '%' . $search . '%');
        })
        ->where('user_id', $userId) // Hanya mengambil booking yang terkait dengan user yang sedang login
        ->paginate($perPage);
    
        // Mengembalikan data ke view
        return view('hotel.booking.booking', compact('bookings'));
    }
    
    
    public function create()
    {
        // return view('bookings.create');
    }

    public function store(Request $request)
    {
        $userId = auth()->id();
        $request->validate([
            'booking_id' => 'required|unique:bookings',
            'no_of_adults' => 'required|integer',
            'no_of_children' => 'required|integer',
            'no_of_weekend_nights' => 'required|integer',
            'no_of_week_nights' => 'required|integer',
            'type_of_meal_plan' => 'required|string',
            'required_car_parking_space' => 'required|boolean',
            'room_type_reserved' => 'required|string',
            'lead_time' => 'required|integer',
            'arrival_year' => 'required|integer',
            'arrival_month' => 'required|integer',
            'arrival_date' => 'required|integer',
            'market_segment_type' => 'required|string',
            'repeated_guest' => 'required|boolean',
            'no_of_previous_cancellations' => 'required|integer',
            'no_of_previous_bookings_not_canceled' => 'required|integer',
            'avg_price_per_room' => 'required|numeric',
            'no_of_special_requests' => 'required|integer',
            'booking_status' => 'required|string'
        ]);

        Booking::create($request->all());
        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function show($id)
    {
        $id = Booking::find($id);
        return response()->json($id);
    }

    public function edit(Booking $booking)
    {
        // return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'no_of_adults' => 'required|integer',
            'no_of_children' => 'required|integer',
            'no_of_weekend_nights' => 'required|integer',
            'no_of_week_nights' => 'required|integer',
            'type_of_meal_plan' => 'required|string',
            'required_car_parking_space' => 'required|boolean',
            'room_type_reserved' => 'required|string',
            'lead_time' => 'required|integer',
            'arrival_year' => 'required|integer',
            'arrival_month' => 'required|integer',
            'arrival_date' => 'required|integer',
            'market_segment_type' => 'required|string',
            'repeated_guest' => 'required|boolean',
            'no_of_previous_cancellations' => 'required|integer',
            'no_of_previous_bookings_not_canceled' => 'required|integer',
            'avg_price_per_room' => 'required|numeric',
            'no_of_special_requests' => 'required|integer',
            'booking_status' => 'required|string'
        ]);

        $booking->update($request->all());
        return redirect()->route('hotel.booking.booking')->with('success', 'Booking updated successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Menghapus data booking
        $booking->delete();
    
        // Jika request datang menggunakan AJAX
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
    
        // Jika request bukan AJAX, lakukan redirect biasa
        return redirect()->route('hotel.booking.booking')->with('success', 'Booking deleted successfully.');
    }
    
    
}
