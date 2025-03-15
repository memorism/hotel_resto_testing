<?php

namespace App\Http\Controllers\Hotel;

use App\Models\UploadOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Imports\BookingsImport;
use Maatwebsite\Excel\Facades\Excel;
use ConsoleTVs\Charts\Facades\Charts;


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
            'file' => 'nullable|mimes:xlsx,xls|max:2048', // File tidak wajib diunggah
        ]);

        // Simpan UploadOrder
        $uploadOrder = UploadOrder::create([
            'user_id' => auth()->id(),
            'file_name' => $request->file_name,
            'description' => $request->description,
        ]);

        // Jika ada file yang diunggah, lakukan import data
        if ($request->hasFile('file')) {
            Excel::import(new BookingsImport($uploadOrder->id, auth()->id()), $request->file('file'));
        }

        return redirect()->route('hotel.databooking.index')->with('success', 'Upload order berhasil disimpan' . ($request->hasFile('file') ? ' dan file Excel berhasil diimport!' : '!'));
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
        // Pastikan hanya user yang memiliki upload order yang bisa mengedit
        $uploadOrder = UploadOrder::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        return view('hotel.databooking.edit', compact('uploadOrder'));
    }


    // Menyimpan perubahan upload order
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'file_name' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|mimes:xlsx,xls|max:2048',
        ]);

        // Cari UploadOrder berdasarkan ID
        $uploadOrder = UploadOrder::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // Update data UploadOrder
        $uploadOrder->file_name = $validated['file_name'];
        $uploadOrder->description = $validated['description'];

        // Jika ada file baru diupload, update file dan import ulang datanya
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $newFileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $newFileName, 'public');

            // Update nama file di database
            $uploadOrder->file_name = $newFileName;
            $uploadOrder->save();

            // Hapus semua booking lama yang terkait dengan UploadOrder ini
            Booking::where('upload_order_id', $uploadOrder->id)->delete();

            // Import data baru dari file Excel yang diupload
            Excel::import(new BookingsImport($uploadOrder->id, auth()->id()), $file);
        } else {
            $uploadOrder->save();
        }

        return redirect()->route('hotel.databooking.index')->with('success', 'Upload Order berhasil diperbarui!');
    }

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
