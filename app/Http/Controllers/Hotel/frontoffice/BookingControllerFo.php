<?php

namespace App\Http\Controllers\hotel\frontoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelBooking;
use App\Models\HotelUploadLog;

class BookingControllerFo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $hotelId = $user->hotel_id;

        $perPage = $request->get('per_page', 5);
        $perPage = $perPage === 'semua'
            ? HotelBooking::where('hotel_id', $hotelId)->count()
            : (int) $perPage;

        $bookingId = $request->get('booking_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $bookings = HotelBooking::with('uploadLog')
            ->where('hotel_id', $hotelId)
            ->when($bookingId, function ($query, $bookingId) {
                return $query->where('booking_id', 'like', '%' . $bookingId . '%');
            })
            ->when($startDate, function ($query, $startDate) {
                $queryDate = date('Y-m-d', strtotime($startDate));
                return $query->whereRaw(
                    "STR_TO_DATE(CONCAT(arrival_year, '-', arrival_month, '-', arrival_date), '%Y-%m-%d') >= ?",
                    [$queryDate]
                );
            })
            ->when($endDate, function ($query, $endDate) {
                $queryDate = date('Y-m-d', strtotime($endDate));
                return $query->whereRaw(
                    "STR_TO_DATE(CONCAT(arrival_year, '-', arrival_month, '-', arrival_date), '%Y-%m-%d') <= ?",
                    [$queryDate]
                );
            })
            ->orderByDesc('arrival_year')
            ->orderByDesc('arrival_month')
            ->orderByDesc('arrival_date')
            ->paginate($perPage)
            ->appends($request->all());

        return view('hotel.frontoffice.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $fileNames = HotelUploadLog::where('hotel_id', $user->hotel_id)
            ->where('user_id', $user->id)
            ->pluck('file_name', 'file_name');

        return view('hotel.frontoffice.booking.create', compact('fileNames'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|unique:bookings,booking_id',
            'file_name' => 'required|string|max:255',
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

        $user = auth()->user();

        $file = \App\Models\HotelUploadLog::where('hotel_id', $user->hotel_id)
            ->where('user_id', $user->id)
            ->where('file_name', $request->file_name)
            ->first();

        if (!$file) {
            return redirect()->back()->with('error', 'File yang dipilih tidak valid atau tidak milik Anda.');
        }

        HotelBooking::create(array_merge($request->all(), [
            'hotel_id' => $user->hotel_id,
            'user_id' => $user->id,
            'hotel_upload_log_id' => $file->id,
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
