<?php

namespace App\Http\Controllers\Resto;

use App\Http\Controllers\Controller;
use App\Models\RestoSupply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestoSupplyRestonewController extends Controller
{
    public function index(Request $request)
    {
        $supplies = RestoSupply::where('resto_id', Auth::user()->resto_id)
            ->when($request->search, function ($query, $search) {
                $query->where('nama_barang', 'like', "%$search%");
            })
            ->when($request->category, function ($query, $category) {
                $query->where('kategori', $category);
            })
            ->orderBy('nama_barang')
            ->paginate(10);

        // Get unique categories for filter dropdown
        $categories = RestoSupply::where('resto_id', Auth::user()->resto_id)
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori');

        return view('resto.scmresto.index', compact('supplies', 'categories'));
    }

    public function create()
    {
        return view('resto.scmresto.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'stok' => 'required|integer|min:0',
            'satuan' => 'nullable|string|max:50',
        ]);

        $validated['resto_id'] = Auth::user()->resto_id;
        $validated['created_by'] = Auth::id();

        RestoSupply::create($validated);

        return redirect()->route('resto.supplies.index')->with('success', 'Inventori berhasil ditambahkan.');
    }

    public function edit(RestoSupply $supply)
    {
        return view('resto.scmresto.edit', compact('supply'));
    }

    public function update(Request $request, RestoSupply $supply)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'stok' => 'required|integer|min:0',
            'satuan' => 'nullable|string|max:50',
        ]);

        $supply->update($validated);

        return redirect()->route('resto.supplies.index')->with('success', 'Inventori berhasil diperbarui.');
    }

    public function destroy(RestoSupply $supply)
    {
        $supply->delete();
        return back()->with('success', 'Inventori berhasil dihapus.');
    }

    public function show(RestoSupply $supply)
    {
        // Cek apakah barang milik resto yang sedang login
        if ($supply->resto_id !== auth()->user()->resto_id) {
            abort(403);
        }

        $transactions = $supply->transactions()->latest()->paginate(10);

        return view('resto.scmresto.show', compact('supply', 'transactions'));
    }

}
