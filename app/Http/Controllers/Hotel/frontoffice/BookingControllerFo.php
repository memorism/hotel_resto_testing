<?php

namespace App\Http\Controllers\hotel\frontoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelBooking;
use App\Models\HotelUploadLog;
use App\Models\SharedCustomer;
use App\Models\HotelRoom;

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

        $nama = $request->get('nama');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $approvalStatus = $request->get('approval_status');

        $bookings = HotelBooking::with(['uploadLog', 'customer'])
            ->where('hotel_id', $hotelId)
            ->when($nama, function ($query, $nama) {
                return $query->whereHas('customer', function ($q) use ($nama) {
                    $q->where('name', 'like', '%' . $nama . '%');
                });
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
            ->when($approvalStatus, function ($query, $approvalStatus) {
                return $query->where('approval_status', $approvalStatus);
            })
            ->when($request->sort, function ($query) use ($request) {
                $direction = $request->direction === 'asc' ? 'asc' : 'desc';
                switch ($request->sort) {
                    case 'no':
                        $query->orderBy('id', $direction);
                        break;
                    case 'approval_status':
                        $query->orderBy('approval_status', $direction);
                        break;
                    case 'customer_name':
                        $query->join('shared_customers', 'hotel_bookings.customer_id', '=', 'shared_customers.id')
                            ->orderBy('shared_customers.name', $direction);
                        break;
                    case 'no_of_adults':
                        $query->orderBy('no_of_adults', $direction);
                        break;
                    case 'no_of_children':
                        $query->orderBy('no_of_children', $direction);
                        break;
                    case 'no_of_weekend_nights':
                        $query->orderBy('no_of_weekend_nights', $direction);
                        break;
                    case 'no_of_week_nights':
                        $query->orderBy('no_of_week_nights', $direction);
                        break;
                    case 'type_of_meal_plan':
                        $query->orderBy('type_of_meal_plan', $direction);
                        break;
                    case 'required_car_parking_space':
                        $query->orderBy('required_car_parking_space', $direction);
                        break;
                    case 'room_type_reserved':
                        $query->orderBy('room_type_reserved', $direction);
                        break;
                    case 'lead_time':
                        $query->orderBy('lead_time', $direction);
                        break;
                    case 'arrival_year':
                        $query->orderBy('arrival_year', $direction);
                        break;
                    case 'arrival_month':
                        $query->orderBy('arrival_month', $direction);
                        break;
                    case 'arrival_date':
                        $query->orderBy('arrival_date', $direction);
                        break;
                    case 'market_segment_type':
                        $query->orderBy('market_segment_type', $direction);
                        break;
                    case 'avg_price_per_room':
                        $query->orderBy('avg_price_per_room', $direction);
                        break;
                    case 'no_of_special_requests':
                        $query->orderBy('no_of_special_requests', $direction);
                        break;
                    case 'booking_status':
                        $query->orderBy('booking_status', $direction);
                        break;
                    default:
                        $query->orderBy($request->sort, $direction);
                }
            }, function ($query) {
                $query->orderByDesc('arrival_year')
                    ->orderByDesc('arrival_month')
                    ->orderByDesc('arrival_date');
            })
            ->paginate($perPage)
            ->appends($request->all());

        return view('hotel.frontoffice.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $hotelId = auth()->user()->hotel_id;

        $fileNames = HotelUploadLog::where('hotel_id', $hotelId)->pluck('file_name', 'file_name');
        $hotelRooms = HotelRoom::where('hotel_id', $hotelId)->get();
        $customers = SharedCustomer::whereHas('hotelBookings', function ($q) use ($hotelId) {
            $q->where('hotel_id', $hotelId);
        })->orWhereDoesntHave('hotelBookings') // pelanggan baru yang belum pernah booking juga ditampilkan
            ->orderBy('name')->get();

        return view('hotel.frontoffice.booking.create', compact('fileNames', 'customers', 'hotelRooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        // Siapkan data akhir
        $data = array_merge($validated, [
            'hotel_upload_log_id' => $file?->id,
            'hotel_id' => auth()->user()->hotel_id,
            'customer_id' => $validated['customer_id'] ?? null,
            'approval_status' => 'pending',
        ]);


        HotelBooking::create($data);

        return redirect()->route('hotel.frontoffice.booking.index')->with('success', 'Booking berhasil dibuat!');
    }


    /**
     * Show the form for editing the specified resource.
     */

    public function edit(HotelBooking $booking)
    {
        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.frontoffice.booking.edit')->with('error', 'Unauthorized access');
        }

        $booking->load('customer');

        $hotelId = auth()->user()->hotel_id;

        $fileNames = HotelUploadLog::where('hotel_id', $hotelId)->pluck('file_name', 'file_name');

        $customers = SharedCustomer::whereHas('hotelBookings', function ($q) use ($hotelId) {
            $q->where('hotel_id', $hotelId);
        })->orWhereDoesntHave('hotelBookings')
            ->orderBy('name')->get();

        $hotelRooms = HotelRoom::where('hotel_id', $hotelId)->get();


        return view('hotel.frontoffice.booking.edit', compact('booking', 'fileNames', 'customers', 'hotelRooms'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HotelBooking $booking)
    {

        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.frontoffice.booking.edit')->with('error', 'Unauthorized access');
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

        return redirect()->route('hotel.frontoffice.booking.index')->with('success', 'Booking berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(HotelBooking $booking)
    {
        if ($booking->hotel_id != auth()->user()->hotel_id) {
            return redirect()->route('hotel.frontoffice.booking.index')->with('error', 'Unauthorized access');
        }

        $booking->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('hotel.frontoffice.booking.index')->with('success', 'Booking deleted successfully.');
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
