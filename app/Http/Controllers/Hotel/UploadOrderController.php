<?php

namespace App\Http\Controllers\Hotel;

use App\Models\UploadOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Imports\BookingsImport;
use Maatwebsite\Excel\Facades\Excel;


class UploadOrderController extends Controller
{
    // Menampilkan daftar upload orders untuk user
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default: 10
        $search = $request->input('search'); // Ambil keyword pencarian

        $query = UploadOrder::where('user_id', auth()->id());

        // Jika ada keyword pencarian, tambahkan ke query
        if ($search) {
            $query->where('file_name', 'LIKE', "%$search%");
        }

        $uploadOrders = $query->paginate($perPage);

        return view('hotel.databooking.index', compact('uploadOrders', 'search'));
    }



    // Menampilkan halaman untuk membuat upload order baru
    public function create()
    {
        return view('hotel.databooking.create');
    }

    // Menyimpan upload order baru
    public function store(Request $request)
    {
        // Cari atau buat UploadOrder untuk user ini
        $uploadOrder = UploadOrder::firstOrCreate([
            'user_id' => auth()->id(),
            'file_name' => $request->file_name,
            'description' => $request->description,
        ]);

        // Simpan Booking dengan upload_order_id
        $booking = new Booking($request->all());
        $booking->upload_order_id = $uploadOrder->id; // Set relasi
        $booking->save();

        return redirect()->back()->with('success', 'Booking berhasil diupload');
    }


    public function storeAndImport(Request $request)
    {

        // Validasi input
        $request->validate([
            'file_name' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        // Simpan UploadOrder
        $uploadOrder = UploadOrder::create([
            'user_id' => auth()->id(), // Pastikan user_id masuk ke tabel upload_orders
            'file_name' => $request->file_name,
            'description' => $request->description,
        ]);

        // Debugging: Cek apakah user_id tersimpan dengan benar
        \Log::info('UploadOrder Created: ', $uploadOrder->toArray());

        // Import Data Excel ke dalam tabel bookings
        Excel::import(new BookingsImport($uploadOrder->id, auth()->id()), $request->file('file'));

        return redirect()->route('hotel.databooking.index')->with('success', 'Data booking berhasil disimpan dan file Excel berhasil diimport!');
    }


    // Menampilkan detail upload order
    public function show($id)
    {
        $id = Booking::find($id);
        return response()->json($id);
    }

    // Menampilkan halaman edit upload order
    public function edit($id)
    {
        $uploadOrder = UploadOrder::findOrFail($id);

        // return view('upload_orders.edit', compact('uploadOrder'));
    }

    // Menyimpan perubahan upload order
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'upload_order' => 'required|integer',
        ]);

        $uploadOrder = UploadOrder::findOrFail($id);
        $uploadOrder->upload_order = $validated['upload_order'];
        $uploadOrder->save();

        return redirect()->route('hotel.databooking.index')->with('success', 'Upload Order updated successfully!');
    }

    // Menghapus upload order
    public function destroy($id)
    {
        $uploadOrder = UploadOrder::findOrFail($id);
        $uploadOrder->delete();

        return redirect()->route('hotel.databooking.index')->with('success', 'Upload Order deleted successfully!');
    }

    public function viewUploadOrder($id, Request $request)
    {
        // Cari UploadOrder berdasarkan ID
        $uploadOrder = UploadOrder::findOrFail($id);

        // Ambil parameter perPage dan search dari request
        $perPage = $request->input('perPage', 10); // Default: 10
        $search = $request->input('search'); // Ambil keyword pencarian

        // Query untuk mengambil data bookings yang berhubungan dengan upload order
        $bookingsQuery = Booking::where('upload_order_id', $uploadOrder->id);

        // Jika ada keyword pencarian, tambahkan ke query
        if ($search) {
            $bookingsQuery->where('booking_id', 'LIKE', "%$search%");
        }

        // Paginate hasil query
        $bookings = $bookingsQuery->paginate($perPage);

        // Tampilkan view dengan data UploadOrder dan Booking
        return view('hotel.databooking.view-upload-order', compact('uploadOrder', 'bookings', 'search'));
    }
}
