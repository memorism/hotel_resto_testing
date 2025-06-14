<?php

namespace App\Http\Controllers\Resto\Finance;

use App\Http\Controllers\Controller;
use App\Models\RestoFinance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceTransactionController extends Controller
{
    public function index(Request $request)
    {
        $restoId = Auth::user()->resto_id;
        $sortField = $request->get('sort', 'tanggal');
        $sortDirection = $request->get('direction', 'desc');

        $finances = RestoFinance::where('resto_id', $restoId)
            ->when($request->jenis, fn($q) => $q->where('jenis', $request->jenis))
            ->when($request->start_date, fn($q) => $q->whereDate('tanggal', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('tanggal', '<=', $request->end_date))
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends($request->all());

        return view('resto.finance_transactions.index', compact('finances'));
    }

    public function create()
    {
        return view('resto.finance_transactions.create');
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

        RestoFinance::create($validated);

        return redirect()->route('financeresto.finances.index')
            ->with('success', 'Data keuangan berhasil ditambahkan.');
    }

    public function edit(RestoFinance $finance)
    {
        $this->authorizeTransaction($finance);
        return view('resto.finance_transactions.edit', compact('finance'));
    }

    public function update(Request $request, RestoFinance $finance)
    {
        $this->authorizeTransaction($finance);

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

        return redirect()->route('financeresto.finances.index')
            ->with('success', 'Data keuangan berhasil diperbarui.');
    }

    public function destroy(RestoFinance $finance)
    {
        $this->authorizeTransaction($finance);
        $finance->delete();

        return back()->with('success', 'Data keuangan berhasil dihapus.');
    }

    protected function authorizeTransaction($finance)
    {
        if ($finance->resto_id !== Auth::user()->resto_id) {
            abort(403, 'Tidak punya akses ke data ini.');
        }
    }
}
