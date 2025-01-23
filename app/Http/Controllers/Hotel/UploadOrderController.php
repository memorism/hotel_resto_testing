<?php

namespace App\Http\Controllers\Hotel;

// app/Http/Controllers/UploadOrderController.php


use App\Models\UploadOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;

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
        return view('upload_orders.create');
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


    // Menampilkan detail upload order
    public function show($id)
    {
        $uploadOrder = UploadOrder::findOrFail($id);

        return view('upload_orders.show', compact('uploadOrder'));
    }

    // Menampilkan halaman edit upload order
    public function edit($id)
    {
        $uploadOrder = UploadOrder::findOrFail($id);

        return view('upload_orders.edit', compact('uploadOrder'));
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

        return redirect()->route('upload_orders.index')->with('success', 'Upload Order updated successfully!');
    }

    // Menghapus upload order
    public function destroy($id)
    {
        $uploadOrder = UploadOrder::findOrFail($id);
        $uploadOrder->delete();

        return redirect()->route('upload_orders.index')->with('success', 'Upload Order deleted successfully!');
    }
}
