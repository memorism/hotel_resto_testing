<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Hotel;

class HotelAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotel::query();

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $hotels = $query->orderBy('created_at', 'desc')->paginate(10);
        $cities = Hotel::select('city')->distinct()->pluck('city')->filter()->values();

        return view('admin.hotel.index', compact('hotels', 'cities'));
    }

    public function create()
    {
        return view('admin.hotel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'street'        => 'nullable|string|max:255',
            'village'       => 'nullable|string|max:255',
            'district'      => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'province'      => 'nullable|string|max:255',
            'postal_code'   => 'nullable|string|max:20',
            'phone'         => 'nullable|string|max:50',
            'email'         => 'nullable|email|max:255',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = $request->hasFile('logo') 
            ? $request->file('logo')->store('logos/hotels', 'public') 
            : null;

        Hotel::create([
            'name'          => $request->name,
            'street'        => $request->street,
            'village'       => $request->village,
            'district'      => $request->district,
            'city'          => $request->city,
            'province'      => $request->province,
            'postal_code'   => $request->postal_code,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'logo'          => $logoPath,
        ]);

        return redirect()->route('admin.hotel.index')->with('success', 'Hotel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.hotel.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'street'        => 'nullable|string|max:255',
            'village'       => 'nullable|string|max:255',
            'district'      => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'province'      => 'nullable|string|max:255',
            'postal_code'   => 'nullable|string|max:20',
            'phone'         => 'nullable|string|max:50',
            'email'         => 'nullable|email|max:255',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($hotel->logo) {
                Storage::disk('public')->delete($hotel->logo);
            }
            $hotel->logo = $request->file('logo')->store('logos/hotels', 'public');
        }

        $hotel->update([
            'name'          => $request->name,
            'street'        => $request->street,
            'village'       => $request->village,
            'district'      => $request->district,
            'city'          => $request->city,
            'province'      => $request->province,
            'postal_code'   => $request->postal_code,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'logo'          => $hotel->logo,
        ]);

        return redirect()->route('admin.hotel.index')->with('success', 'Hotel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);

        if ($hotel->logo) {
            Storage::disk('public')->delete($hotel->logo);
        }

        $hotel->delete();

        return redirect()->route('admin.hotel.index')->with('success', 'Hotel berhasil dihapus!');
    }
}
