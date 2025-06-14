<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Resto;

class RestoAdminController extends Controller
{
    /**
     * Tampilkan semua resto.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $city = $request->input('city');
        $perPage = $request->input('per_page', 10);
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $query = Resto::query();

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

        $restos = $query->orderBy($sort, $direction)->paginate($perPage)->appends($request->all());

        $cities = Resto::select('city')->distinct()->pluck('city');

        return view('admin.resto.index', compact('restos', 'cities'));
    }

    /**
     * Tampilkan form tambah resto.
     */
    public function create()
    {
        return view('admin.resto.create');
    }

    /**
     * Simpan resto baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = $request->hasFile('logo')
            ? $request->file('logo')->store('logos/restos', 'public')
            : null;

        Resto::create([
            'name' => $request->name,
            'street' => $request->street,
            'village' => $request->village,
            'district' => $request->district,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
            'email' => $request->email,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.resto.index')->with('success', 'Resto berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit resto.
     */
    public function edit($id)
    {
        $resto = Resto::findOrFail($id);
        return view('admin.resto.edit', compact('resto'));
    }

    /**
     * Update data resto.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $resto = Resto::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($resto->logo && Storage::disk('public')->exists($resto->logo)) {
                Storage::disk('public')->delete($resto->logo);
            }
            $resto->logo = $request->file('logo')->store('logos/restos', 'public');
        }

        $resto->update([
            'name' => $request->name,
            'street' => $request->street,
            'village' => $request->village,
            'district' => $request->district,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
            'email' => $request->email,
            'logo' => $resto->logo,
        ]);

        return redirect()->route('admin.resto.index')->with('success', 'Resto berhasil diperbarui!');
    }

    /**
     * Hapus resto.
     */
    public function destroy($id): RedirectResponse
    {
        $resto = Resto::findOrFail($id);

        if ($resto->logo && Storage::disk('public')->exists($resto->logo)) {
            Storage::disk('public')->delete($resto->logo);
        }

        $resto->delete();

        return redirect()->route('admin.resto.index')->with('success', 'Resto berhasil dihapus!');
    }
}
