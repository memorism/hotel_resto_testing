<?php

namespace App\Http\Controllers\Resto;

use App\Http\Controllers\Controller;
use App\Models\Resto;
use App\Models\RestoTable;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RestoTableController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $restoId = auth()->user()->resto_id;
        $tables = RestoTable::where('resto_id', $restoId)->latest()->paginate(10);

        return view('resto.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('resto.tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_code' => 'required|string|max:20|unique:resto_tables,table_code',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'required|in:0,1',
        ]);

        RestoTable::create([
            'resto_id' => auth()->user()->resto_id,
            'table_code' => $request->table_code,
            'capacity' => $request->capacity,
            'is_active' => $request->is_active,
            


        ]);

        return redirect()->route('resto.tables.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit(RestoTable $table)
    {
        // $this->authorize('update', $table);

        return view('resto.tables.edit', compact('table'));
    }

    public function update(Request $request, RestoTable $table)
    {
        // $this->authorize('update', $table);

        $request->validate([
            'table_code' => 'required|string|max:20|unique:resto_tables,table_code,' . $table->id,
            'capacity' => 'required|integer|min:1',
            'is_active' => 'required|in:0,1',
        ]);

        $table->update([
            'table_code' => $request->table_code,
            'capacity' => $request->capacity,
            'is_active' => $request->is_active,
            

        ]);

        return redirect()->route('resto.tables.index')->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy(RestoTable $table)
    {
        // $this->authorize('delete', $table);

        $table->delete();
        return back()->with('success', 'Meja berhasil dihapus.');
    }
}
