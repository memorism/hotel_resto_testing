<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Models\HotelUploadLog;
use Illuminate\Support\Facades\Auth;
use App\Models\SharedCustomer;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;

        // Ambil nilai dari request
        $perPage = $request->get('per_page', 10);
        $perPage = ($perPage === 'semua')
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
                return $query->whereRaw("STR_TO_DATE(CONCAT(arrival_year, '-', arrival_month, '-', arrival_date), '%Y-%m-%d') >= ?", [$queryDate]);
            })
            ->when($endDate, function ($query, $endDate) {
                $queryDate = date('Y-m-d', strtotime($endDate));
                return $query->whereRaw("STR_TO_DATE(CONCAT(arrival_year, '-', arrival_month, '-', arrival_date), '%Y-%m-%d') <= ?", [$queryDate]);
            })
            
            ->orderByDesc('arrival_date')
            ->paginate($perPage)
            ->appends($request->all()); // agar pagination tetap menyimpan filter

        return view('hotel.booking.booking', compact('bookings'));
    }


    public function create()
    {
        $hotelId = auth()->user()->hotel_id;
    
        $fileNames = HotelUploadLog::where('hotel_id', $hotelId)->pluck('file_name', 'file_name');
    
        $customers = SharedCustomer::whereHas('hotelBookings', function ($q) use ($hotelId) {
            $q->where('hotel_id', $hotelId);
        })->orWhereDoesntHave('hotelBookings') // pelanggan baru yang belum pernah booking juga ditampilkan
          ->orderBy('name')->get();
    
        return view('hotel.booking.create', compact('fileNames', 'customers'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:shared_customers,id',
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
        $validated['customer_id'] = $validated['customer_id'] ?? null;

        HotelBooking::create($validated);

        return redirect()->route('hotel.booking.index')->with('success', 'Booking berhasil dibuat!');
    }

    public function show(HotelBooking $booking)
    {
        if ($booking->hotel_id !== auth()->user()->hotel_id) {
            abort(403);
        }

        return view('hotel.booking.show', compact('booking'));
    }

    public function edit(HotelBooking $booking)
    {
        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.booking.index')->with('error', 'Unauthorized access');
        }

        $fileNames = HotelUploadLog::where('hotel_id', auth()->user()->hotel_id)->pluck('file_name', 'file_name');
        return view('hotel.booking.edit', compact('booking', 'fileNames'));
    }

    public function update(Request $request, HotelBooking $booking)
    {
        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.booking.index')->with('error', 'Unauthorized access');
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

        return redirect()->route('hotel.booking.index')->with('success', 'Booking updated successfully!');
    }

    public function destroy(HotelBooking $booking)
    {
        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.booking.index')->with('error', 'Unauthorized access');
        }

        $booking->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('hotel.booking.index')->with('success', 'Booking deleted successfully.');
    }

    
}