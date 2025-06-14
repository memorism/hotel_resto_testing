<?php

namespace App\Http\Controllers\Hotel;

use App\Models\HotelRoom;
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

        $sort = $request->get('sort', 'arrival_date');
        $direction = $request->get('direction', 'desc');
        $allowedSortColumns = [
            'customer_name',
            'no_of_adults',
            'no_of_children',
            'lead_time',
            'arrival_year',
            'arrival_month',
            'arrival_date',
            'avg_price_per_room',
        ];

        if (!in_array($sort, $allowedSortColumns)) {
            $sort = 'arrival_date';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $perPage = $request->get('per_page', 10);
        $perPage = ($perPage === 'semua')
            ? HotelBooking::where('hotel_id', $hotelId)->count()
            : (int) $perPage;

        $searchCustomer = $request->get('search_customer');
        $status = $request->get('status');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = HotelBooking::with(['uploadLog', 'customer'])
            ->where('hotel_id', $hotelId)
            ->when($status, fn($q) => $q->where('approval_status', $status))
            ->when($startDate, fn($q) => $q->whereRaw("STR_TO_DATE(CONCAT(arrival_year, '-', arrival_month, '-', arrival_date), '%Y-%m-%d') >= ?", [date('Y-m-d', strtotime($startDate))]))
            ->when($endDate, fn($q) => $q->whereRaw("STR_TO_DATE(CONCAT(arrival_year, '-', arrival_month, '-', arrival_date), '%Y-%m-%d') <= ?", [date('Y-m-d', strtotime($endDate))]))
            ->when($searchCustomer, function ($q, $searchCustomer) {
                $q->whereHas('customer', function ($customerQuery) use ($searchCustomer) {
                    $customerQuery->where('name', 'like', '%' . $searchCustomer . '%');
                });
            });

        // Apply sorting
        if ($sort === 'customer_name') {
            $query->join('shared_customers', 'hotel_bookings.customer_id', '=', 'shared_customers.id')
                ->orderBy('shared_customers.name', $direction)
                ->select('hotel_bookings.*'); // Select all columns from hotel_bookings to avoid issues
        } else {
            $query->orderBy($sort, $direction);
        }

        $bookings = $query->paginate($perPage)->appends($request->all());

        return view('hotel.booking.booking', compact('bookings'));
    }


    public function create()
    {
        $hotelId = auth()->user()->hotel_id;

        $fileNames = HotelUploadLog::where('hotel_id', $hotelId)->pluck('file_name', 'file_name');
        $hotelRooms = HotelRoom::where('hotel_id', $hotelId)->get();
        $customers = SharedCustomer::whereHas('hotelBookings', function ($q) use ($hotelId) {
            $q->where('hotel_id', $hotelId);
        })->orWhereDoesntHave('hotelBookings') // pelanggan baru yang belum pernah booking juga ditampilkan
            ->orderBy('name')->get();

        return view('hotel.booking.create', compact('fileNames', 'customers', 'hotelRooms'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:shared_customers,id',
            'booking_id' => 'nullable|string|max:255',
            'file_name' => 'nullable|string|max:255',
            'no_of_adults' => 'required|integer',
            'no_of_children' => 'required|integer',
            'no_of_weekend_nights' => 'required|integer',
            'no_of_week_nights' => 'required|integer',
            'type_of_meal_plan' => 'required|string|max:255',
            'required_car_parking_space' => 'required|boolean',
            'room_type_reserved' => 'required|string|max:255',
            'lead_time' => 'required|integer',
            'arrival_date_full' => 'required|date',
            'market_segment_type' => 'required|string|max:255',
            'avg_price_per_room' => 'required|numeric',
            'no_of_special_requests' => 'required|integer',
            'booking_status' => 'required|string|max:255',
        ]);

        // Pisahkan tanggal
        $arrivalDate = \Carbon\Carbon::parse($validated['arrival_date_full']);
        $validated['arrival_year'] = $arrivalDate->year;
        $validated['arrival_month'] = $arrivalDate->month;
        $validated['arrival_date'] = $arrivalDate->day;

        // Hapus field arrival_date_full (karena tidak ada di tabel)
        unset($validated['arrival_date_full']);

        // Cek file (jika ada)
        $file = null;
        if (!empty($validated['file_name'])) {
            $file = HotelUploadLog::where('hotel_id', auth()->user()->hotel_id)
                ->where('file_name', $validated['file_name'])
                ->first();

            if (!$file) {
                return redirect()->back()->with('error', 'File yang dipilih tidak valid atau tidak milik hotel Anda.');
            }
        }

        $data = array_merge($validated, [
            'hotel_upload_log_id' => $file?->id,
            'hotel_id' => auth()->user()->hotel_id,
            'customer_id' => $validated['customer_id'] ?? null,
            'approval_status' => 'pending',
        ]);

        HotelBooking::create($data);

        return redirect()->route('hotel.booking.index')->with('success', 'Booking berhasil dibuat!');
    }


    public function show(HotelBooking $booking)
    {
        if ($booking->hotel_id !== auth()->user()->hotel_id) {
            abort(403);
        }


        return view('hotel.booking.show', compact('booking', 'customers'));
    }

    public function edit(HotelBooking $booking)
    {
        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.booking.index')->with('error', 'Unauthorized access');
        }

        $booking->load('customer');

        $hotelId = auth()->user()->hotel_id;

        $fileNames = HotelUploadLog::where('hotel_id', $hotelId)->pluck('file_name', 'file_name');

        $customers = SharedCustomer::whereHas('hotelBookings', function ($q) use ($hotelId) {
            $q->where('hotel_id', $hotelId);
        })->orWhereDoesntHave('hotelBookings')
            ->orderBy('name')->get();

        $hotelRooms = HotelRoom::where('hotel_id', $hotelId)->get();


        return view('hotel.booking.edit', compact('booking', 'fileNames', 'customers', 'hotelRooms'));
    }


    public function update(Request $request, HotelBooking $booking)
    {

        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.booking.index')->with('error', 'Unauthorized access');
        }
        // dd($request->all()); 

        $validated = $request->validate([
            'booking_id' => 'nullable|string|max:255',
            'file_name' => 'nullable|string|max:255',
            'no_of_adults' => 'required|integer',
            'no_of_children' => 'required|integer',
            'no_of_weekend_nights' => 'required|integer',
            'no_of_week_nights' => 'required|integer',
            'type_of_meal_plan' => 'required|string|max:255',
            'required_car_parking_space' => 'required|boolean',
            'room_type_reserved' => 'required|string|max:255',
            'lead_time' => 'required|integer',
            'arrival_date_full' => 'required|date',
            'market_segment_type' => 'required|string|max:255',
            // 'repeated_guest' => 'required|boolean',
            // 'no_of_previous_cancellations' => 'required|integer',
            // 'no_of_previous_bookings_not_canceled' => 'required|integer',
            'avg_price_per_room' => 'required|numeric',
            'no_of_special_requests' => 'required|integer',
            'booking_status' => 'required|string|max:255',
        ]);

        // Konversi arrival_date_full ke tahun, bulan, tanggal
        $arrivalDate = \Carbon\Carbon::parse($validated['arrival_date_full']);
        $validated['arrival_year'] = $arrivalDate->year;
        $validated['arrival_month'] = $arrivalDate->month;
        $validated['arrival_date'] = $arrivalDate->day;
        unset($validated['arrival_date_full']);

        // Cek file log jika ada perubahan file_name
        $file = null;
        if (!empty($validated['file_name'])) {
            $file = HotelUploadLog::where('hotel_id', auth()->user()->hotel_id)
                ->where('file_name', $validated['file_name'])
                ->first();

            if (!$file) {
                return redirect()->back()->with('error', 'File tidak valid.');
            }

            $validated['hotel_upload_log_id'] = $file->id;
        }
        $validated['approval_status'] = 'pending';
        $booking->update($validated);

        return redirect()->route('hotel.booking.index')->with('success', 'Booking berhasil diperbarui!');
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

    public function approve($id)
    {
        $booking = HotelBooking::where('id', $id)
            ->where('hotel_id', auth()->user()->hotel_id)
            ->firstOrFail();

        $booking->approval_status = 'approved';
        $booking->approved_by = auth()->id();
        $booking->approved_at = now();
        $booking->save();

        return redirect()->back()->with('success', 'Booking berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_note' => 'required|string|max:1000',
        ]);

        $booking = HotelBooking::where('id', $id)
            ->where('hotel_id', auth()->user()->hotel_id)
            ->firstOrFail();

        $booking->approval_status = 'rejected';
        $booking->rejection_note = $request->rejection_note;
        $booking->rejected_by = auth()->id();
        $booking->rejected_at = now();
        $booking->save();

        return redirect()->back()->with('success', 'Booking berhasil ditolak.');
    }

    public function bulkApprove(Request $request)
    {
        $selectedBookings = $request->input('selected_bookings');

        if (empty($selectedBookings)) {
            return redirect()->back()->with('error', 'Tidak ada booking yang dipilih.');
        }

        HotelBooking::whereIn('id', $selectedBookings)
            ->where('hotel_id', auth()->user()->hotel_id)
            ->update([
                'approval_status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Booking yang dipilih berhasil disetujui.');
    }

    public function bulkReject(Request $request)
    {
        $request->validate([
            'selected_bookings' => 'required|array',
            'selected_bookings.*' => 'exists:hotel_bookings,id',
            'rejection_note' => 'required|string|max:1000',
        ]);

        HotelBooking::whereIn('id', $request->selected_bookings)
            ->where('hotel_id', auth()->user()->hotel_id)
            ->update([
                'approval_status' => 'rejected',
                'rejection_note' => $request->rejection_note,
                'rejected_by' => auth()->id(),
                'rejected_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Booking yang dipilih berhasil ditolak.');
    }
}