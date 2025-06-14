<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelRestoLink;
use App\Models\Hotel;
use App\Models\Resto;

class HotelRestoLinkController extends Controller
{
    public function index(Request $request)
    {
        $searchHotel = $request->input('search_hotel');
        $perPage = $request->input('per_page', 10);
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $query = HotelRestoLink::query();

        if ($searchHotel) {
            $query->whereHas('hotel', function ($q) use ($searchHotel) {
                $q->where('name', 'like', '%' . $searchHotel . '%');
            });
        }

        // Validate sort column
        $allowedSortColumns = ['hotel_id', 'resto_id', 'created_at'];
        if (!in_array($sort, $allowedSortColumns)) {
            $sort = 'created_at';
        }

        // Validate direction
        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        // Handle sorting for related models if sort column is hotel_id or resto_id
        if ($sort === 'hotel_id') {
            $query->join('hotels', 'hotel_resto_links.hotel_id', '=', 'hotels.id')
                ->orderBy('hotels.name', $direction)
                ->select('hotel_resto_links.*'); // Select all columns from the main table
        } elseif ($sort === 'resto_id') {
            $query->join('restos', 'hotel_resto_links.resto_id', '=', 'restos.id')
                ->orderBy('restos.name', $direction)
                ->select('hotel_resto_links.*'); // Select all columns from the main table
        } else {
            $query->orderBy($sort, $direction);
        }

        // Handle "semua" for per_page
        $perPage = ($perPage === 'semua') ? $query->count() : (int) $perPage;

        $links = $query->with(['hotel', 'resto'])
            ->paginate($perPage)
            ->appends($request->all());

        return view('admin.hotel-resto-links.index', compact('links'));
    }


    public function create()
    {
        $hotels = Hotel::orderBy('name')->get();
        $restos = Resto::orderBy('name')->get();

        return view('admin.hotel-resto-links.create', compact('hotels', 'restos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'resto_id' => 'required|exists:restos,id',
        ]);

        // Cek jika sudah ada relasi yang sama
        $exists = HotelRestoLink::where('hotel_id', $validated['hotel_id'])
            ->where('resto_id', $validated['resto_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['Relasi ini sudah ada.'])->withInput();
        }

        HotelRestoLink::create($validated);

        return redirect()->route('hotel-resto-links.index')->with('success', 'Relasi berhasil ditambahkan.');
    }
    public function destroy(HotelRestoLink $hotelRestoLink)
    {
        $hotelRestoLink->delete();
        return redirect()->route('hotel-resto-links.index')->with('success', 'Relasi berhasil dihapus.');
    }

    public function edit(HotelRestoLink $hotelRestoLink)
    {
        $hotels = Hotel::orderBy('name')->get();
        $restos = Resto::orderBy('name')->get();

        return view('admin.hotel-resto-links.edit', [
            'link' => $hotelRestoLink,
            'hotels' => $hotels,
            'restos' => $restos,
        ]);
    }

    public function update(Request $request, HotelRestoLink $hotelRestoLink)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'resto_id' => 'required|exists:restos,id',
        ]);

        // Cek duplikat selain ID saat ini
        $exists = HotelRestoLink::where('hotel_id', $validated['hotel_id'])
            ->where('resto_id', $validated['resto_id'])
            ->where('id', '!=', $hotelRestoLink->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['Relasi ini sudah ada.'])->withInput();
        }

        $hotelRestoLink->update($validated);

        return redirect()->route('hotel-resto-links.index')->with('success', 'Relasi berhasil diperbarui.');
    }

}

