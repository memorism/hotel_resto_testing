<?php

namespace App\Http\Controllers\resto;

use App\Http\Controllers\Controller;
use App\Models\ExcelUpload;
use App\Models\RestoOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RestoOrdersImport;

class ExcelUploadController extends Controller
{
    public function index()
    {
        // Menampilkan file yang telah diupload oleh user
        $uploads = ExcelUpload::where('user_id', Auth::id())->get();
        return view('resto.dataorders.index', compact('uploads'));
    }

    public function create()
    {
        // Menampilkan halaman upload file
        return view('resto.dataorders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',  // Validasi format file
            'description' => 'nullable|string',
            'file_name' => 'required|string',  // Validasi untuk nama file
        ]);

        // Store the file
        $file = $request->file('file');
        $file->store('uploads', 'public');  // Menyimpan file tanpa menyimpan path di database

        // Simpan informasi upload ke database tanpa menyimpan file_path
        $upload = ExcelUpload::create([
            'user_id' => Auth::id(),
            'file_name' => $request->file_name,
            'description' => $request->description,
        ]);

        // Import data dari Excel ke tabel resto_orders
        Excel::import(new RestoOrdersImport($upload), $file);

        return redirect()->route('resto.dataorders.index')->with('success', 'File berhasil diupload!');
    }

    public function show($uploadId, Request $request)
    {
        $upload = ExcelUpload::findOrFail($uploadId);
    
        if ($upload->user_id != Auth::id()) {
            abort(403, 'Unauthorized access');
        }
    
        // Mengambil jumlah per halaman
        $perPage = $request->get('perPage', 10);
    
        // Mengambil pencarian dan melakukan filter berdasarkan search
        $orders = RestoOrder::where('excel_upload_id', $upload->id)
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
    


}
