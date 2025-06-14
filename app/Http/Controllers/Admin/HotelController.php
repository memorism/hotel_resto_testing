<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $city = $request->input('city');
        $perPage = $request->input('per_page', 10);
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $query = Hotel::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($city) {
            $query->where('city', $city);
        }

        // Validate sort column
        $allowedSortColumns = ['name', 'address', 'phone', 'email', 'created_at'];
        if (!in_array($sort, $allowedSortColumns)) {
            $sort = 'created_at';
        }

        // Validate direction
        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        // Handle "semua" for per_page
        $perPage = ($perPage === 'semua') ? $query->count() : (int) $perPage;

        $hotels = $query->orderBy($sort, $direction)->paginate($perPage)->appends($request->all());

        $cities = Hotel::select('city')->distinct()->pluck('city');

        return view('admin.hotel.index', compact('hotels', 'cities'));
    }

    public function create()
    {
        return view('admin.hotel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:hotels',
            'phone' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048', // Max 2MB
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('hotel_logos', 'public');
        }

        Hotel::create($validated);

        return redirect()->route('admin.hotel.index')->with('success', 'Hotel berhasil ditambahkan.');
    }

    public function edit(Hotel $hotel)
    {
        return view('admin.hotel.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:hotels,email,' . $hotel->id,
            'phone' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($hotel->logo) {
                Storage::disk('public')->delete($hotel->logo);
            }
            $validated['logo'] = $request->file('logo')->store('hotel_logos', 'public');
        }

        $hotel->update($validated);

        return redirect()->route('admin.hotel.index')->with('success', 'Hotel berhasil diperbarui.');
    }

    public function destroy(Hotel $hotel)
    {
        // Delete logo if exists
        if ($hotel->logo) {
            Storage::disk('public')->delete($hotel->logo);
        }
        $hotel->delete();

        return redirect()->route('admin.hotel.index')->with('success', 'Hotel berhasil dihapus.');
    }
}