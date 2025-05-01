<?php

namespace App\Http\Controllers\Hotel\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelUploadLog;
use App\Imports\HotelFinanceImport;
use Maatwebsite\Excel\Facades\Excel;

class FinanceMigrasiController extends Controller
{
    public function index()
    {
        $hotelId = auth()->user()->hotel_id;
        $uploads = HotelUploadLog::where('hotel_id', $hotelId)
            ->where('type', 'finance')
            ->latest()
            ->get();

        return view('hotel.finance.migrasi.index', compact('uploads'));
    }

    public function create()
    {
        return view('hotel.finance.migrasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();
        $upload = HotelUploadLog::create([
            'user_id' => $user->id,
            'hotel_id' => $user->hotel_id,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'description' => $request->description,
            'type' => 'finance',
        ]);

        try {
            Excel::import(new HotelFinanceImport($upload->id, $user->hotel_id, $user->id), $request->file('file'));
            return redirect()->route('finance.migrasi.index')->with('success', 'Data keuangan berhasil diimpor.');
        } catch (\Exception $e) {
            $upload->delete();
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $upload = HotelUploadLog::where('hotel_id', auth()->user()->hotel_id)
            ->where('id', $id)
            ->firstOrFail();

        // Hapus semua transaksi yang terkait dengan log ini
        $upload->finances()->delete(); // untuk hapus semua data finance terkait upload ini

        $upload->delete();

        return redirect()->route('finance.migrasi.index')->with('success', 'Histori import dan data keuangan berhasil dihapus.');
    }

}
