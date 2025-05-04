<?php

namespace App\Http\Controllers\Resto;

use App\Http\Controllers\Controller;
use App\Models\RestoFinance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class RestoFinanceController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $finances = RestoFinance::where('resto_id', Auth::user()->resto_id)->latest()->paginate(10);
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

        RestoFinance::create($validated);

        return redirect()->route('resto.finances.index')->with('success', 'Data keuangan berhasil ditambahkan.');
    }

    public function edit(RestoFinance $finance)
    {
        // $this->authorize('update', $finance);
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

        $finance->update($validated);

        return redirect()->route('resto.finances.index')->with('success', 'Data keuangan berhasil diperbarui.');
    }

    public function destroy(RestoFinance $finance)
    {
        $finance->delete();

        return back()->with('success', 'Data keuangan berhasil dihapus.');
    }
}
