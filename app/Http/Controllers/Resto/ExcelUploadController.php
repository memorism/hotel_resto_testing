<?php

namespace App\Http\Controllers\Resto;

use App\Http\Controllers\Controller;
use App\Models\RestoUploadLog;
use App\Models\RestoOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RestoOrdersImport;
use Illuminate\Support\Facades\Storage;

class ExcelUploadController extends Controller
{
    public function index()
    {
        $restoId = auth()->user()->resto_id;
        $uploads = RestoUploadLog::where('resto_id', $restoId)->orderByDesc('created_at')->get();
        return view('resto.dataorders.index', compact('uploads'));
    }

    public function create()
    {
        return view('resto.dataorders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'description' => 'nullable|string',
            'file_name' => 'required|string|max:255',
        ]);

        $upload = RestoUploadLog::create([
            'user_id' => Auth::id(),
            'resto_id' => auth()->user()->resto_id,
            'file_name' => $request->file_name,
            'description' => $request->description,
        ]);

        Excel::import(new RestoOrdersImport($upload->id, $upload->resto_id, $upload->user_id), $request->file('file'));

        return redirect()->route('resto.dataorders.index')->with('success', 'File berhasil diupload dan data diimport!');
    }

    public function show($uploadId, Request $request)
    {
        $upload = RestoUploadLog::where('id', $uploadId)
            ->where('resto_id', auth()->user()->resto_id)
            ->firstOrFail();

        $perPage = $request->get('perPage', 10);

        $orders = RestoOrder::where('resto_upload_log_id', $upload->id)
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $q->where('received_by', 'like', '%' . $request->search . '%')
                        ->orWhere('order_date', 'like', '%' . $request->search . '%')
                        ->orWhere('item_name', 'like', '%' . $request->search . '%')
                        ->orWhere('item_type', 'like', '%' . $request->search . '%')
                        ->orWhere('time_order', 'like', '%' . $request->search . '%')
                        ->orWhere('transaction_type', 'like', '%' . $request->search . '%')
                        ->orWhere('type_of_order', 'like', '%' . $request->search . '%');
                });
            })
            ->paginate($perPage);

        return view('resto.dataorders.show', compact('upload', 'orders'));
    }

    public function edit($uploadId)
    {
        $upload = RestoUploadLog::where('id', $uploadId)
            ->where('resto_id', auth()->user()->resto_id)
            ->firstOrFail();

        return view('resto.dataorders.edit', compact('upload'));
    }

    public function update(Request $request, $uploadId)
    {
        $request->validate([
            'file_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:xlsx,xls',
        ]);

        $upload = RestoUploadLog::where('id', $uploadId)
            ->where('resto_id', auth()->user()->resto_id)
            ->firstOrFail();

        if ($request->hasFile('file')) {
            RestoOrder::where('resto_upload_log_id', $upload->id)->delete();

            $upload->update([
                'file_name' => $request->file_name,
                'description' => $request->description,
            ]);

            Excel::import(new RestoOrdersImport($upload->id, $upload->resto_id, $upload->user_id), $request->file('file'));
        } else {
            $upload->update([
                'file_name' => $request->file_name,
                'description' => $request->description,
            ]);
        }

        return redirect()->route('resto.dataorders.index')->with('success', 'Data upload berhasil diperbarui.');
    }

    public function destroy($uploadId)
    {
        $upload = RestoUploadLog::where('id', $uploadId)
            ->where('resto_id', auth()->user()->resto_id)
            ->firstOrFail();

        RestoOrder::where('resto_upload_log_id', $upload->id)->delete();
        $upload->delete();

        return redirect()->route('resto.dataorders.index')->with('success', 'Upload dan data pesanan berhasil dihapus.');
    }
}
