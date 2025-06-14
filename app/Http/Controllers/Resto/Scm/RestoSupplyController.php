<?php

namespace App\Http\Controllers\Resto\Scm;

use App\Http\Controllers\Controller;
use App\Models\RestoSupply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestoSupplyController extends Controller
{
    public function index()
    {
        $supplies = RestoSupply::where('resto_id', Auth::user()->resto_id)
            ->latest()
            ->paginate(10);

        return view('resto.scm.supplies.index', compact('supplies'));
    }

    public function create()
    {
        return view('resto.scm.supplies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori'    => 'nullable|string|max:255',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'nullable|string|max:50',
        ]);

        $validated['resto_id'] = Auth::user()->resto_id;
        $validated['created_by'] = Auth::id();

        RestoSupply::create($validated);

        return redirect()->route('scmresto.supplies.index')->with('success', 'Inventori berhasil ditambahkan.');
    }

    public function edit(RestoSupply $supply)
    {
        // Bisa tambahkan pengecekan ownership kalau diperlukan
        return view('resto.scm.supplies.edit', compact('supply'));
    }

    public function update(Request $request, RestoSupply $supply)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori'    => 'nullable|string|max:255',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'nullable|string|max:50',
        ]);

        $supply->update($validated);

        return redirect()->route('scmresto.supplies.index')->with('success', 'Inventori berhasil diperbarui.');
    }

    public function destroy(RestoSupply $supply)
    {
        $supply->delete();

        return back()->with('success', 'Inventori berhasil dihapus.');
    }
}
