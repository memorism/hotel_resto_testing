<?php

namespace App\Http\Controllers\resto;

use App\Http\Controllers\Controller;
use App\Models\ExcelUpload;
use App\Models\RestoOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RestoOrdersImport;
use Illuminate\Support\Facades\Storage;

class ExcelUploadController extends Controller
{
    // Menampilkan daftar file Excel yang telah diupload oleh user
    public function index()
    {
        $uploads = ExcelUpload::where('user_id', Auth::id())->get();
        return view('resto.dataorders.index', compact('uploads'));
    }

    // Menampilkan halaman upload file
    public function create()
    {
        return view('resto.dataorders.create');
    }

    // Menyimpan file yang diupload dan mengimport data
    public function store(Request $request)
    {
        
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'description' => 'nullable|string',
            'file_name' => 'required|string',
        ]);

        // Simpan file ke storage
        $file = $request->file('file');
        $filePath = $file->store('uploads/resto_orders', 'public');

        // Simpan informasi upload ke database
        $upload = ExcelUpload::create([
            'user_id' => Auth::id(),
            'file_name' => $request->file_name,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        // Import data dari file Excel ke tabel resto_orders
        Excel::import(new RestoOrdersImport($upload), $file);

        return redirect()->route('resto.dataorders.index')->with('success', 'File berhasil diupload dan data diimport!');
    }

    // Menampilkan detail data dari file yang diupload (View)
    public function show($uploadId, Request $request)
    {
        $upload = ExcelUpload::findOrFail($uploadId);

        if ($upload->user_id != Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $perPage = $request->get('perPage', 10);

        $orders = RestoOrder::where('excel_upload_id', $upload->id)
            ->where('user_id', Auth::id())
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where('received_by', 'like', '%' . $request->search . '%')
                    ->orWhere('order_date', 'like', '%' . $request->search . '%')
                    ->orWhere('item_name', 'like', '%' . $request->search . '%')
                    ->orWhere('item_type', 'like', '%' . $request->search . '%')
                    ->orWhere('time_order', 'like', '%' . $request->search . '%')
                    ->orWhere('transaction_type', 'like', '%' . $request->search . '%')
                    ->orWhere('type_of_order', 'like', '%' . $request->search . '%');
            })
            ->paginate($perPage);

        return view('resto.dataorders.show', compact('upload', 'orders'));
    }

    // Menampilkan form edit (Edit)
    public function edit($uploadId)
    {
        $upload = ExcelUpload::findOrFail($uploadId);

        if ($upload->user_id != Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('resto.dataorders.edit', compact('upload'));
    }

    // Memperbarui data yang diupload dan menghapus data lama
    public function update(Request $request, $uploadId)
    {
        $request->validate([
            'file_name' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:xlsx,xls',
        ]);

        $upload = ExcelUpload::findOrFail($uploadId);

        if ($upload->user_id != Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Hapus data lama jika ada file baru yang diunggah
        if ($request->hasFile('file')) {
            RestoOrder::where('excel_upload_id', $upload->id)->delete();

            // Hapus file lama jika ada
            if (!empty($upload->file_path) && Storage::disk('public')->exists($upload->file_path)) {
                Storage::disk('public')->delete($upload->file_path);
            }

            // Simpan file baru
            $file = $request->file('file');
            $filePath = $file->store('uploads/resto_orders', 'public');

            // Update data upload dengan file baru
            $upload->update([
                'file_name' => $request->file_name,
                'description' => $request->description,
                'file_path' => $filePath,
            ]);

            // Import data baru dari file yang diupload
            Excel::import(new RestoOrdersImport($upload), $file);
        } else {
            // Update hanya nama file dan deskripsi tanpa menghapus data lama
            $upload->update([
                'file_name' => $request->file_name,
                'description' => $request->description,
            ]);
        }

        return redirect()->route('resto.dataorders.index')->with('success', 'File berhasil diperbarui!');
    }


    // Menghapus file dan data yang terkait (Delete)
    public function destroy($uploadId)
    {
        $upload = ExcelUpload::findOrFail($uploadId);

        if ($upload->user_id != Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Cek apakah file_path tidak null sebelum menghapus file
        if (!empty($upload->file_path) && Storage::disk('public')->exists($upload->file_path)) {
            Storage::disk('public')->delete($upload->file_path);
        }

        // Hapus semua data pesanan terkait file ini
        RestoOrder::where('excel_upload_id', $upload->id)->delete();

        // Hapus record upload dari database
        $upload->delete();

        return redirect()->route('resto.dataorders.index')->with('success', 'File dan data terkait telah dihapus!');
    }

}
