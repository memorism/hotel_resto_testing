<?php

namespace App\Http\Controllers\Resto;

use App\Http\Controllers\Controller;
use App\Models\RestoFinance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RestoFinanceController extends Controller
{
    public function index(Request $request)
    {
        $finances = RestoFinance::where('resto_id', Auth::user()->resto_id)
            ->when($request->status, fn($q) => $q->where('approval_status', $request->status))
            ->when($request->start_date, fn($q) => $q->whereDate('tanggal', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('tanggal', '<=', $request->end_date))
            ->when($request->sort, function ($query) use ($request) {
                $direction = $request->direction === 'asc' ? 'asc' : 'desc';
                switch ($request->sort) {
                    case 'transaction_date':
                        $query->orderBy('tanggal', $direction);
                        break;
                    case 'amount':
                        $query->orderBy('nominal', $direction);
                        break;
                    case 'transaction_type':
                        $query->orderBy('jenis', $direction);
                        break;
                    case 'description':
                        $query->orderBy('keterangan', $direction);
                        break;
                    case 'approval_status':
                        $query->orderBy('approval_status', $direction);
                        break;
                    default:
                        $query->orderBy($request->sort, $direction);
                }
            }, function ($query) {
                $query->latest();
            })
            ->paginate(10)
            ->appends($request->all());

        return view('resto.finances.index', compact('finances'));
    }

    public function create()
    {
        return view('resto.finances.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'nullable|string',
            'nominal' => 'required|numeric',
        ]);

        $validated['resto_id'] = Auth::user()->resto_id;
        $validated['approval_status'] = 'pending';

        RestoFinance::create($validated);

        return redirect()->route('resto.finances.index')
            ->with('success', 'Data keuangan berhasil ditambahkan dan menunggu persetujuan.');
    }

    public function edit(RestoFinance $finance)
    {
        return view('resto.finances.edit', compact('finance'));
    }

    public function update(Request $request, RestoFinance $finance)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'nullable|string',
            'nominal' => 'required|numeric',
        ]);

        $finance->update(array_merge($validated, [
            'approval_status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
            'rejection_note' => null,
        ]));

        return redirect()->route('resto.finances.index')
            ->with('success', 'Data keuangan berhasil diperbarui dan dikembalikan ke status pending.');
    }

    public function destroy(RestoFinance $finance)
    {
        try {
            // Check if user has access to this finance record
            if ($finance->resto_id !== Auth::user()->resto_id) {
                return back()->with('error', 'Anda tidak memiliki akses untuk menghapus data ini.');
            }

            // Check if finance can be deleted (e.g. not already approved)
            if ($finance->approval_status === 'approved') {
                return back()->with('error', 'Data yang sudah disetujui tidak dapat dihapus.');
            }

            // Perform the delete operation
            if ($finance->delete()) {
                return back()->with('success', 'Data keuangan berhasil dihapus.');
            } else {
                return back()->with('error', 'Gagal menghapus data keuangan.');
            }
        } catch (\Exception $e) {
            \Log::error('Error deleting finance record: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
        }
    }

    public function approve($id)
    {
        $finance = RestoFinance::where('id', $id)
            ->where('resto_id', Auth::user()->resto_id)
            ->firstOrFail();

        $finance->update([
            'approval_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_note' => null,
        ]);

        return back()->with('success', 'Transaksi berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_note' => 'required|string|max:1000',
        ]);

        $finance = RestoFinance::where('id', $id)
            ->where('resto_id', Auth::user()->resto_id)
            ->firstOrFail();

        $finance->update([
            'approval_status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_note' => $request->rejection_note,
        ]);

        return back()->with('success', 'Transaksi ditolak dengan catatan.');
    }

    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:resto_finances,id'
        ]);

        $restoId = Auth::user()->resto_id;

        RestoFinance::whereIn('id', $request->ids)
            ->where('resto_id', $restoId)
            ->where('approval_status', 'pending')
            ->update([
                'approval_status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'rejection_note' => null,
            ]);

        return back()->with('success', 'Transaksi terpilih berhasil disetujui.');
    }

    public function bulkReject(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:resto_finances,id',
            'rejection_note' => 'required|string|max:1000',
        ]);

        $restoId = Auth::user()->resto_id;

        RestoFinance::whereIn('id', $request->ids)
            ->where('resto_id', $restoId)
            ->where('approval_status', 'pending')
            ->update([
                'approval_status' => 'rejected',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'rejection_note' => $request->rejection_note,
            ]);

        return back()->with('success', 'Transaksi terpilih berhasil ditolak.');
    }
}
