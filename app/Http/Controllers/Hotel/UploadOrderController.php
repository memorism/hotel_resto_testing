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
    public function index()
    {
        // Ambil semua upload order yang terkait dengan user yang sedang login
        $user = auth()->user();
        $uploadOrders = UploadOrder::where('user_id', $user->id)->get();

        return view('hotel.databooking.index', compact('uploadOrders'));
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
        'file_name'   => 'required|string|max:255',
        'description' => 'required|string',
        'file'        => 'required|mimes:xlsx,xls|max:2048',
    ]);

    // Simpan UploadOrder
    $uploadOrder = UploadOrder::create([
        'user_id'     => auth()->id(), // Pastikan user_id masuk ke tabel upload_orders
        'file_name'   => $request->file_name,
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
    public function import_excel()
    {
        return view('import_excel');

    }
    public function import_excel_post(Request $request)
    {
        dd($request->all());
    }


}
