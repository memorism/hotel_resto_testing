<?php

namespace App\Http\Controllers\Hotel\Frontoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelUploadLog;
use App\Models\Hotel;
use App\Imports\BookingsImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Throwable;

class MigrasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $hotel = Hotel::find($user->hotel_id);

        if (!$hotel) {
            return back()->with('error', 'Data hotel tidak ditemukan atau belum dikaitkan.');
        }

        $uploadOrders = HotelUploadLog::where('hotel_id', $hotel->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hotel.frontoffice.migrasi.index', compact('uploadOrders'));
    }

    public function create()
    {
        return view('hotel.frontoffice.migrasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'file_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $hotel = Hotel::find($user->hotel_id);

        if (!$hotel) {
            return back()->with('error', 'Data hotel tidak ditemukan atau belum dikaitkan.');
        }

        try {
            // 🔍 Validasi struktur kolom
            $filePath = $request->file('file')->getRealPath();
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $headers = $sheet->rangeToArray('A1:Z1', NULL, TRUE, FALSE)[0];

            $requiredHeaders = [
                'booking_id',
                'no_of_adults',
                'no_of_children',
                'no_of_weekend_nights',
                'no_of_week_nights',
                'type_of_meal_plan',
                'required_car_parking_space',
                'room_type_reserved',
                'lead_time',
                'arrival_year',
                'arrival_month',
                'arrival_date',
                'market_segment_type',
                'avg_price_per_room',
                'no_of_special_requests',
                'booking_status',
            ];

            foreach ($requiredHeaders as $header) {
                if (!in_array($header, $headers)) {
                    return back()->with('error', 'Template tidak valid. Kolom "' . $header . '" tidak ditemukan.');
                }
            }

            $uploadOrder = HotelUploadLog::create([
                'hotel_id' => $hotel->id,
                'user_id' => $user->id,
                'file_name' => $request->file_name,
                'description' => $request->description,
                'type' => 'booking',
            ]);

            Excel::import(
                new BookingsImport($uploadOrder->id, $hotel->id, $user->id),
                $request->file('file')
            );

            return redirect()->route('hotel.frontoffice.migrasi.index')
                ->with('success', 'Data berhasil diupload dan diproses.');
        } catch (Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan saat proses import: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $uploadOrder = HotelUploadLog::where('hotel_id', auth()->user()->hotel_id)
            ->where('id', $id)
            ->firstOrFail();

        $uploadOrder->bookings()->delete();
        $uploadOrder->delete();

        return redirect()->route('hotel.frontoffice.migrasi.index')
            ->with('success', 'Data migrasi dan bookings terkait berhasil dihapus.');
    }
}