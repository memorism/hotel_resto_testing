<?php

namespace App\Http\Controllers\Hotel\SCM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelSupply;
use Illuminate\Support\Facades\Auth;

class HotelSupplyController extends Controller
{
    public function index(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;

        $supplies = HotelSupply::where('hotel_id', $hotelId)
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('category', 'like', "%$search%");
            })
            ->orderBy('name')
            ->paginate(10);

        return view('hotel.scm.supplies.index', compact('supplies'));
    }

    public function create()
    {
        return view('hotel.scm.supplies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
        ]);

        HotelSupply::create([
            'hotel_id' => Auth::user()->hotel_id,
            'user_id' => Auth::id(),
            'name' => $request->name,
            'category' => $request->category,
            'unit' => $request->unit,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('scm.supplies.index')
            ->with('success', 'Inventori berhasil ditambahkan.');
    }

    public function edit(HotelSupply $supply)
    {
        $this->authorizeHotel($supply);
        return view('hotel.scm.supplies.edit', compact('supply'));
    }

    public function update(Request $request, HotelSupply $supply)
    {
        $this->authorizeHotel($supply);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
        ]);

        $supply->update($request->only(['name', 'category', 'unit', 'quantity']));

        return redirect()->route('scm.supplies.index')
            ->with('success', 'Inventori berhasil diperbarui.');
    }

    public function destroy(HotelSupply $supply)
    {
        $this->authorizeHotel($supply);
        $supply->delete();

        return redirect()->route('scm.supplies.index')
            ->with('success', 'Inventori berhasil dihapus.');
    }

    private function authorizeHotel(HotelSupply $supply)
    {
        if ($supply->hotel_id !== Auth::user()->hotel_id) {
            abort(403, 'Akses ditolak.');
        }
    }
}
