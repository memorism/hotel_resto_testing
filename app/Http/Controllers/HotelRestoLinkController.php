<?php

namespace App\Http\Controllers;

use App\Models\HotelRestoLink;
use App\Models\Hotel;
use App\Models\Resto;
use Illuminate\Http\Request;

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

        // Handle "semua" for per_page
        $perPage = ($perPage === 'semua') ? $query->count() : (int) $perPage;

        $links = $query->with(['hotel', 'resto'])
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->appends($request->all());

        return view('admin.hotel-resto-links.index', compact('links'));
    }

    public function create()
    {
        $hotels = Hotel::all();
        $restos = Resto::all();
        return view('admin.hotel-resto-links.create', compact('hotels', 'restos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'resto_id' => 'required|exists:restos,id|unique:hotel_resto_links,resto_id,NULL,id,hotel_id,' . $request->hotel_id,
        ]);

        HotelRestoLink::create($request->all());

        return redirect()->route('hotel-resto-links.index')->with('success', 'Relasi berhasil ditambahkan.');
    }

    public function edit(HotelRestoLink $link)
    {
        $hotels = Hotel::all();
        $restos = Resto::all();
        return view('admin.hotel-resto-links.edit', compact('link', 'hotels', 'restos'));
    }

    public function update(Request $request, HotelRestoLink $link)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'resto_id' => 'required|exists:restos,id|unique:hotel_resto_links,resto_id,' . $link->id . ',id,hotel_id,' . $request->hotel_id,
        ]);

        $link->update($request->all());

        return redirect()->route('hotel-resto-links.index')->with('success', 'Relasi berhasil diperbarui.');
    }

    public function destroy(HotelRestoLink $link)
    {
        $link->delete();
        return redirect()->route('hotel-resto-links.index')->with('success', 'Relasi berhasil dihapus.');
    }
}