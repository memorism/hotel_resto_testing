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

    public function index(Request $request)
    {
        $restoId = auth()->user()->resto_id;
        $search = $request->input('search');

        $tables = RestoTable::where('resto_id', $restoId)
            ->when($search, function ($query) use ($search) {
                $query->where('table_code', 'like', '%' . $search . '%');
            })
            ->when($request->sort, function ($query) use ($request) {
                $direction = $request->direction === 'asc' ? 'asc' : 'desc';
                switch ($request->sort) {
                    case 'no':
                        $query->orderBy('id', $direction);
                        break;
                    case 'table_code':
                        $query->orderBy('table_code', $direction);
                        break;
                    case 'capacity':
                        $query->orderBy('capacity', $direction);
                        break;
                    case 'is_active':
                        $query->orderBy('is_active', $direction);
                        break;
                    default:
                        $query->orderBy($request->sort, $direction);
                }
            }, function ($query) {
                $query->latest();
            })
            ->paginate(10)
            ->appends($request->all());

        return view('resto.tables.index', compact('tables', 'search'));
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
