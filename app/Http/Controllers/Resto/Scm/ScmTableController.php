<?php

namespace App\Http\Controllers\Resto\Scm;

use App\Http\Controllers\Controller;
use App\Models\RestoTable;
use Illuminate\Http\Request;

class ScmTableController extends Controller
{
    public function index(Request $request)
    {
        $restoId = auth()->user()->resto_id;
        $search = $request->input('search');

        $tables = RestoTable::where('resto_id', $restoId)
            ->when($search, function ($query) use ($search) {
                $query->where('table_code', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('resto.scm.tables.index', compact('tables', 'search'));
    }

    public function create()
    {
        return view('resto.scm.tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_code' => 'required|string|max:20|unique:resto_tables,table_code',
            'capacity'   => 'required|integer|min:1',
            'is_active'  => 'required|in:0,1',
        ]);

        RestoTable::create([
            'resto_id'   => auth()->user()->resto_id,
            'table_code' => $request->table_code,
            'capacity'   => $request->capacity,
            'is_active'  => $request->is_active,
        ]);

        return redirect()->route('scmresto.tables.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit(RestoTable $table)
    {
        return view('resto.scm.tables.edit', compact('table'));
    }

    public function update(Request $request, RestoTable $table)
    {
        $request->validate([
            'table_code' => 'required|string|max:20|unique:resto_tables,table_code,' . $table->id,
            'capacity'   => 'required|integer|min:1',
            'is_active'  => 'required|in:0,1',
        ]);

        $table->update([
            'table_code' => $request->table_code,
            'capacity'   => $request->capacity,
            'is_active'  => $request->is_active,
        ]);

        return redirect()->route('scmresto.tables.index')->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy(RestoTable $table)
    {
        $table->delete();
        return back()->with('success', 'Meja berhasil dihapus.');
    }
}
