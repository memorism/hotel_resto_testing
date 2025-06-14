<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelUploadLog;
use App\Models\HotelBooking;
use App\Imports\BookingsImport;
use Maatwebsite\Excel\Facades\Excel;

class UploadOrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $query = HotelUploadLog::where('hotel_id', auth()->user()->hotel_id);

        if ($search) {
            $query->where('file_name', 'LIKE', "%$search%");
        }

        $uploadOrders = $query->paginate($perPage);

        return view('hotel.databooking.index', compact('uploadOrders', 'search'));
    }

    public function create()
    {
        return view('hotel.databooking.create');
    }

    public function store(Request $request)
    {
        $uploadLog = HotelUploadLog::firstOrCreate([
            'hotel_id' => auth()->user()->hotel_id,
            'user_id' => auth()->id(),
            'file_name' => $request->file_name,
            'description' => $request->description,
        ]);

        $booking = new HotelBooking($request->all());
        $booking->hotel_upload_log_id = $uploadLog->id;
        $booking->hotel_id = auth()->user()->hotel_id;
        $booking->user_id = auth()->id();
        $booking->save();

        return redirect()->back()->with('success', 'Booking berhasil diupload');
    }

    public function storeAndImport(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|mimes:xlsx,xls|max:2048',
        ]);

        $uploadLog = HotelUploadLog::create([
            'hotel_id' => auth()->user()->hotel_id,
            'user_id' => auth()->id(),
            'file_name' => $request->file_name,
            'description' => $request->description,
        ]);

        if ($request->hasFile('file')) {
            Excel::import(new BookingsImport($uploadLog->id, auth()->id(), auth()->user()->hotel_id), $request->file('file'));
        }

        return redirect()->route('hotel.databooking.index')->with('success', 'Upload order berhasil disimpan' . ($request->hasFile('file') ? ' dan file Excel berhasil diimport!' : '!'));
    }

    public function show($id)
    {
        $booking = HotelBooking::findOrFail($id);
        return response()->json($booking);
    }

    public function edit($id)
    {
        $uploadOrder = HotelUploadLog::where('id', $id)->where('hotel_id', auth()->user()->hotel_id)->firstOrFail();
        return view('hotel.databooking.edit', compact('uploadOrder'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'file_name' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|mimes:xlsx,xls|max:2048',
        ]);

        $uploadOrder = HotelUploadLog::where('id', $id)->where('hotel_id', auth()->user()->hotel_id)->firstOrFail();
        $uploadOrder->file_name = $validated['file_name'];
        $uploadOrder->description = $validated['description'];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $newFileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $newFileName, 'public');
            $uploadOrder->file_name = $newFileName;
            $uploadOrder->save();

            HotelBooking::where('hotel_upload_log_id', $uploadOrder->id)->delete();
            Excel::import(new BookingsImport($uploadOrder->id, auth()->id(), auth()->user()->hotel_id), $file);
        } else {
            $uploadOrder->save();
        }

        return redirect()->route('hotel.databooking.index')->with('success', 'Upload Order berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $uploadOrder = HotelUploadLog::where('id', $id)->where('hotel_id', auth()->user()->hotel_id)->firstOrFail();
        $uploadOrder->delete();

        return redirect()->route('hotel.databooking.index')->with('success', 'Upload Order berhasil dihapus.');
    }

    public function viewUploadOrder($id, Request $request)
    {
        $uploadOrder = HotelUploadLog::where('id', $id)->where('hotel_id', auth()->user()->hotel_id)->firstOrFail();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $bookingsQuery = HotelBooking::where('hotel_upload_log_id', $uploadOrder->id);

        if ($search) {
            $bookingsQuery->where('booking_id', 'LIKE', "%$search%");
        }

        $bookings = $bookingsQuery->paginate($perPage);

        return view('hotel.databooking.view-upload-order', compact('uploadOrder', 'bookings', 'search'));
    }
}
