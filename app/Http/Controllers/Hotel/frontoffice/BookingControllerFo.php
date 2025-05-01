<?php

namespace App\Http\Controllers\hotel\frontoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelBooking;

class BookingControllerFo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $hotelId = $user->hotel_id;

        $perPage = $request->get('perPage', 10);
        $search = $request->get('search', '');

        $bookings = HotelBooking::where('hotel_id', $hotelId)
            ->when($search, function ($query, $search) {
                return $query->where('booking_id', 'like', '%' . $search . '%');
            })
            ->paginate($perPage);

        return view('hotel.frontoffice.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hotel.frontoffice.booking.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|unique:bookings,booking_id',
            'no_of_adults' => 'required|integer|min:1',
            'no_of_children' => 'required|integer|min:0',
            'no_of_weekend_nights' => 'required|integer|min:0',
            'no_of_week_nights' => 'required|integer|min:0',
            'type_of_meal_plan' => 'required|string|max:255',
            'required_car_parking_space' => 'required|boolean',
            'room_type_reserved' => 'required|string|max:255',
            'lead_time' => 'required|integer|min:0',
            'arrival_year' => 'required|integer',
            'arrival_month' => 'required|integer',
            'arrival_date' => 'required|integer',
            'market_segment_type' => 'required|string|max:255',
            'avg_price_per_room' => 'required|numeric',
            'no_of_special_requests' => 'required|integer|min:0',
            'booking_status' => 'required|in:Not_Canceled,Canceled',
        ]);

        HotelBooking::create(array_merge($request->all(), [
            'hotel_id' => auth()->user()->hotel_id, // 🔥 Pakai hotel_id, bukan user_id lagi
            'user_id'  => auth()->user()->id,
        ]));

        return redirect()->route('hotel.frontoffice.booking.index')->with('success', 'Booking berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $booking = HotelBooking::findOrFail($id);
        $this->authorizeBooking($booking);

        return view('hotel.frontoffice.booking.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $booking = HotelBooking::findOrFail($id);
        $this->authorizeBooking($booking);

        $request->validate([
            'no_of_adults' => 'required|integer|min:1',
            'no_of_children' => 'required|integer|min:0',
            'no_of_weekend_nights' => 'required|integer|min:0',
            'no_of_week_nights' => 'required|integer|min:0',
            'type_of_meal_plan' => 'required|string|max:255',
            'required_car_parking_space' => 'required|boolean',
            'room_type_reserved' => 'required|string|max:255',
            'lead_time' => 'required|integer|min:0',
            'arrival_year' => 'required|integer',
            'arrival_month' => 'required|integer',
            'arrival_date' => 'required|integer',
            'market_segment_type' => 'required|string|max:255',
            'avg_price_per_room' => 'required|numeric',
            'no_of_special_requests' => 'required|integer|min:0',
            'booking_status' => 'required|in:Not_Canceled,Canceled',
        ]);

        $booking->update($request->except(['hotel_id', 'user_id']));

        return redirect()->route('hotel.frontoffice.booking.index')->with('success', 'Booking berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = HotelBooking::findOrFail($id);
        $this->authorizeBooking($booking);
        $booking->delete();

        return redirect()->route('hotel.frontoffice.booking.index')->with('success', 'Booking berhasil dihapus.');
    }

    /**
     * Authorization helper to ensure FO hanya bisa akses booking di hotel-nya.
     */
    protected function authorizeBooking($booking)
    {
        $hotelId = auth()->user()->hotel_id;
        if ($booking->hotel_id !== $hotelId) {
            abort(403, 'Tidak punya akses ke booking ini.');
        }
    }



}
