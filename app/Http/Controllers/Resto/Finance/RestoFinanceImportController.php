<?php

namespace App\Http\Controllers\Resto\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\RestoFinancesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\RestoUploadLog;
use App\Models\RestoFinance;

class RestoFinanceImportController extends Controller
{
    public function showForm()
    {
        return view('resto.finance_transactions.migrasi.create');
    }

    public function history(Request $request)
    {
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $logs = RestoUploadLog::with('user')
            ->where('resto_id', auth()->user()->resto_id)
            ->where('type', 'finance')
            ->orderBy($sortField, $sortDirection)
            ->get();

        return view('resto.finance_transactions.migrasi.index', compact('logs'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        $user = Auth::user();

        $uploadLog = RestoUploadLog::create([
            'resto_id' => $user->resto_id,
            'user_id' => $user->id,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'description' => 'Upload data keuangan',
            'type' => 'finance',
        ]);

        Excel::import(new RestoFinancesImport($user->resto_id, $uploadLog->id), $request->file('file'));

        return redirect()->route('financeresto.import.history')->with('success', 'Data keuangan berhasil diimpor.');
    }

    public function destroy($id)
    {
        $log = RestoUploadLog::where('id', $id)
            ->where('resto_id', auth()->user()->resto_id)
            ->where('type', 'finance')
            ->first();

        if (!$log) {
            return back()->with('error', 'Data tidak ditemukan atau bukan milik restoran ini.');
        }

        // Hapus data keuangan terkait
        RestoFinance::where('resto_upload_log_id', $log->id)
            ->where('resto_id', auth()->user()->resto_id)
            ->delete();

        // Hapus log upload
        $log->delete();

        return redirect()->route('financeresto.import.history')->with('success', 'Data riwayat upload dan data keuangan terkait berhasil dihapus.');
    }
}
