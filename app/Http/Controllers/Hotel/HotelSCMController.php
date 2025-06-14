<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelSupply;
use Illuminate\Support\Facades\Auth;

class HotelSCMController extends Controller
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

        return view('hotel.hotelscm.index', compact('supplies'));
    }

    public function create()
    {
        return view('hotel.hotelscm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'unit'     => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
        ]);

        HotelSupply::create([
            'hotel_id' => Auth::user()->hotel_id,
            'user_id'  => Auth::id(),
            'name'     => $request->name,
            'category' => $request->category,
            'unit'     => $request->unit,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('hotel.scm.index')
                         ->with('success', 'Inventori berhasil ditambahkan.');
    }

    public function show(HotelSupply $scm)
    {
        if ($scm->hotel_id !== auth()->user()->hotel_id) {
            abort(403);
        }

        $transactions = $scm->transactions()->latest()->paginate(10);

        return view('hotel.hotelscm.show', [
            'supply' => $scm,
            'transactions' => $transactions,
        ]);
    }

    public function edit(HotelSupply $scm)
    {
        if ($scm->hotel_id !== auth()->user()->hotel_id) {
            abort(403);
        }

        return view('hotel.hotelscm.edit', ['supply' => $scm]);
    }

    public function update(Request $request, HotelSupply $scm)
    {
        if ($scm->hotel_id !== auth()->user()->hotel_id) {
            abort(403);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'unit'     => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
        ]);

        $scm->update($request->only(['name', 'category', 'unit', 'quantity']));

        return redirect()->route('hotel.scm.index')
                         ->with('success', 'Inventori berhasil diperbarui.');
    }

    public function destroy(HotelSupply $scm)
    {
        if ($scm->hotel_id !== auth()->user()->hotel_id) {
            abort(403);
        }

        $scm->delete();

        return redirect()->route('hotel.scm.index')
                         ->with('success', 'Inventori berhasil dihapus.');
    }
}
