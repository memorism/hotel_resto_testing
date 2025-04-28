<?php

namespace App\Http\Controllers\Hotel\Frontoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UploadOrder;
use App\Models\Hotel;
use App\Imports\BookingsImport;
use Maatwebsite\Excel\Facades\Excel;

class MigrasiController extends Controller
{
    /**
     * Tampilkan list histori data migrasi.
     */
    public function index()
    {
        $user = auth()->user(); // ✅ ambil user yang login
        $hotel = Hotel::find($user->hotel_id); // ✅ cek ke tabel hotels

        if (!$hotel) {
            return back()->with('error', 'Data hotel tidak ditemukan atau belum dikaitkan.');
        }

        $uploadOrders = UploadOrder::where('hotel_id', $hotel->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hotel.frontoffice.migrasi.index', compact('uploadOrders'));
    }

    /**
     * Tampilkan form upload file migrasi.
     */
    public function create()
    {
        return view('hotel.frontoffice.migrasi.create');
    }

    /**
     * Proses simpan data migrasi (upload Excel).
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'description' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $hotel = Hotel::find($user->hotel_id); // ✅ ambil dari table hotels, bukan users

        if (!$hotel) {
            return back()->with('error', 'Data hotel tidak ditemukan atau belum dikaitkan.');
        }

        $uploadOrder = UploadOrder::create([
            'hotel_id'    => $hotel->id,
            'user_id'     => $user->id,
            'file_name'   => $request->file('file')->getClientOriginalName(),
            'description' => $request->description ?? null,
        ]);

        try {
            Excel::import(
                new BookingsImport($uploadOrder->id, $hotel->id, $user->id),
                $request->file('file')
            );

            return redirect()->route('hotel.frontoffice.migrasi.index')->with('success', 'Data migrasi berhasil diupload.');
        } catch (\Exception $e) {
            $uploadOrder->delete(); // rollback kalau gagal
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data migrasi (beserta data bookings terkait).
     */
    public function destroy($id)
    {
        $uploadOrder = UploadOrder::where('hotel_id', auth()->user()->hotel_id)
            ->where('id', $id)
            ->firstOrFail();

        // Hapus semua bookings yang terkait
        $uploadOrder->bookings()->delete();
        // Hapus log upload order
        $uploadOrder->delete();

        return redirect()->route('hotel.frontoffice.migrasi.index')
            ->with('success', 'Data migrasi dan bookings terkait berhasil dihapus.');
    }
}
