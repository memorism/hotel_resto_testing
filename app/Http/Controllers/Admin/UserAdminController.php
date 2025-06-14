<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Resto;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $usertype = $request->input('usertype');
        $perPage = $request->input('per_page', 10);
        $showDeleted = $request->boolean('show_deleted');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $query = User::query();

        if ($showDeleted) {
            $query->withTrashed();
        }

        $query->whereIn('usertype', ['admin', 'hotelnew', 'restonew']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($usertype) {
            $query->where('usertype', $usertype);
        }

        // Validate sort column
        $allowedSortColumns = ['name', 'email', 'usertype', 'created_at'];
        if (!in_array($sort, $allowedSortColumns)) {
            $sort = 'created_at';
        }

        // Validate direction
        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        $perPage = $perPage === 'semua' ? $query->count() : (int) $perPage;

        $users = $query->select('id', 'name', 'email', 'usertype', 'logo', 'created_at', 'deleted_at')
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->appends($request->all()); // biar query string tetap jalan

        return view('admin.user.user', compact('users'));
    }



    public function create()
    {
        $hotels = Hotel::all();
        $restos = Resto::all();
        return view('admin.user.create', compact('hotels', 'restos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'usertype' => 'required|in:admin,hotelnew,restonew',
            'hotel_id' => 'nullable|exists:hotels,id',
            'resto_id' => 'nullable|exists:restos,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->usertype === 'hotelnew' && !$request->hotel_id) {
            return back()->withErrors(['hotel_id' => 'Hotel wajib dipilih untuk usertype hotel']);
        }

        if ($request->usertype === 'restonew' && !$request->resto_id) {
            return back()->withErrors(['resto_id' => 'Resto wajib dipilih untuk usertype resto']);
        }

        $logoPath = $request->hasFile('logo')
            ? $request->file('logo')->store('logos/users', 'public')
            : null;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype,
            'hotel_id' => $request->hotel_id,
            'resto_id' => $request->resto_id,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.user.user')->with('success', 'User berhasil ditambahkan!');
    }

    public function showLogo($id)
    {
        $user = User::findOrFail($id);

        if ($user->logo && Storage::disk('public')->exists($user->logo)) {
            return response()->file(storage_path('app/public/' . $user->logo));
        }

        return response()->file(public_path('images/default.png'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $hotels = Hotel::all();
        $restos = Resto::all();
        return view('admin.user.edit', compact('user', 'hotels', 'restos'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // dd($request->all());

        $user = User::findOrFail($id);

        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'usertype' => 'required|in:admin,hotelnew,restonew',
            'hotel_id' => 'nullable|exists:hotels,id',
            'resto_id' => 'nullable|exists:restos,id',
            'old_password' => 'required|string|min:8',
            'password' => 'nullable|string|confirmed|min:8',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        // Cek password lama
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
        }

        // Validasi tambahan berdasarkan usertype
        if ($request->usertype === 'hotelnew' && !$request->hotel_id) {
            return back()->withErrors(['hotel_id' => 'Hotel wajib dipilih untuk usertype hotel']);
        }

        if ($request->usertype === 'restonew' && !$request->resto_id) {
            return back()->withErrors(['resto_id' => 'Resto wajib dipilih untuk usertype resto']);
        }

        // Ambil data dasar
        $data = $request->only(['name', 'email', 'usertype', 'hotel_id', 'resto_id']);

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Proses upload logo
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($user->logo && Storage::disk('public')->exists($user->logo)) {
                Storage::disk('public')->delete($user->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos/users', 'public');
        }

        // Update user
        $user->update($data);

        return redirect()->route('admin.user.user')->with('success', 'User berhasil diperbarui!');

    }


    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Delete related sub-accounts based on usertype
        if ($user->usertype === 'hotelnew') {
            User::where('hotel_id', $user->hotel_id)
                ->whereNotIn('usertype', ['admin', 'hotelnew', 'restonew'])
                ->delete();
        } elseif ($user->usertype === 'restonew') {
            User::where('resto_id', $user->resto_id)
                ->whereNotIn('usertype', ['admin', 'hotelnew', 'restonew'])
                ->delete();
        }

        if ($user->logo && Storage::disk('public')->exists($user->logo)) {
            Storage::disk('public')->delete($user->logo);
        }

        $user->delete();

        return redirect()->route('admin.user.user')->with('success', 'User dan sub-akun terkait berhasil dihapus!');
    }

    public function restore($id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        // Restore related sub-accounts based on usertype
        if ($user->usertype === 'hotelnew') {
            User::withTrashed()
                ->where('hotel_id', $user->hotel_id)
                ->whereNotIn('usertype', ['admin', 'hotelnew', 'restonew'])
                ->restore();
        } elseif ($user->usertype === 'restonew') {
            User::withTrashed()
                ->where('resto_id', $user->resto_id)
                ->whereNotIn('usertype', ['admin', 'hotelnew', 'restonew'])
                ->restore();
        }

        $user->restore();

        return redirect()->route('admin.user.user')->with('success', 'User dan sub-akun terkait berhasil dipulihkan!');
    }

    // public function showSubUser($id)
    // {
    //     $parentUser = User::findOrFail($id);

    //     if ($parentUser->usertype === 'hotelnew' && $parentUser->hotel_id) {
    //         $subUsers = User::where('hotel_id', $parentUser->hotel_id)
    //             ->whereNotIn('usertype', ['admin', 'hotelnew', 'restonew'])
    //             ->get();
    //     } elseif ($parentUser->usertype === 'restonew' && $parentUser->resto_id) {
    //         $subUsers = User::where('resto_id', $parentUser->resto_id)
    //             ->whereNotIn('usertype', ['admin', 'hotelnew', 'restonew'])
    //             ->get();
    //     } else {
    //         $subUsers = collect();
    //     }

    //     return view('admin.user.subusers', compact('parentUser', 'subUsers'));
    // }
}

