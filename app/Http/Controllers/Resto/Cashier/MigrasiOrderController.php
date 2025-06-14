<?php

namespace App\Http\Controllers\Resto\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resto;
use App\Models\RestoUploadLog;
use App\Imports\RestoOrdersImport;
use Maatwebsite\Excel\Facades\Excel;

class MigrasiOrderController extends Controller
{

    public function history(Request $request)
    {
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $logs = RestoUploadLog::with('resto', 'user')
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends(['sort' => $sortField, 'direction' => $sortDirection]);

        return view('resto.cashier.migrasi.history', compact('logs'));
    }

    public function showForm()
    {
        $restos = Resto::all();
        return view('resto.cashier.migrasi.form', compact('restos'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'file_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();
        $restoId = $user->resto_id;

        if (!$restoId) {
            return back()->with('error', 'User tidak terkait dengan restoran mana pun.');
        }

        $uploadLog = RestoUploadLog::create([
            'resto_id' => $restoId,
            'user_id' => $user->id,
            'file_name' => $request->file_name,
            'description' => $request->description,
            'created_at' => now(),
            'type' => 'order',
        ]);

        Excel::import(
            new RestoOrdersImport($uploadLog->id, $restoId, $user->id),
            $request->file('file')
        );

        return redirect()->route('cashierresto.resto.orders.history')->with('success', 'Data berhasil diimpor.');
    }

    public function destroy($id)
    {
        $log = RestoUploadLog::where('id', $id)
            ->where('resto_id', auth()->user()->resto_id)
            ->first();

        if (!$log) {
            return back()->with('error', 'Data tidak ditemukan atau bukan milik restoran ini.');
        }

        // Hapus hanya data orders terkait dengan log upload ini
        // Data customer di shared_customers tetap aman karena tidak dihapus
        \App\Models\RestoOrder::where('resto_upload_log_id', $log->id)
            ->where('resto_id', auth()->user()->resto_id)
            ->delete();

        $log->delete();

        return back()->with('success', 'Data riwayat upload berhasil dihapus. Data customer tetap tersimpan.');
    }


}

