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
    public function index()
    {
        $users = User::whereIn('usertype', ['admin', 'hotel', 'resto'])
            ->select('id', 'name', 'email', 'usertype', 'created_at')
            ->get();

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
            'usertype' => 'required|in:admin,hotel,resto',
            'hotel_id' => 'nullable|exists:hotels,id',
            'resto_id' => 'nullable|exists:restos,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->usertype === 'hotel' && !$request->hotel_id) {
            return back()->withErrors(['hotel_id' => 'Hotel wajib dipilih untuk usertype hotel']);
        }

        if ($request->usertype === 'resto' && !$request->resto_id) {
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
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'usertype' => 'required|in:admin,hotel,resto',
            'hotel_id' => 'nullable|exists:hotels,id',
            'resto_id' => 'nullable|exists:restos,id',
            'old_password' => 'required|string|min:8',
            'password' => 'required|string|confirmed|min:8',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
        }

        if ($request->usertype === 'hotel' && !$request->hotel_id) {
            return back()->withErrors(['hotel_id' => 'Hotel wajib dipilih untuk usertype hotel']);
        }

        if ($request->usertype === 'resto' && !$request->resto_id) {
            return back()->withErrors(['resto_id' => 'Resto wajib dipilih untuk usertype resto']);
        }

        if ($request->hasFile('logo')) {
            if ($user->logo && Storage::disk('public')->exists($user->logo)) {
                Storage::disk('public')->delete($user->logo);
            }
            $user->logo = $request->file('logo')->store('logos/users', 'public');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype,
            'hotel_id' => $request->hotel_id,
            'resto_id' => $request->resto_id,
            'logo' => $user->logo,
        ]);

        return redirect()->route('admin.user.user')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->logo && Storage::disk('public')->exists($user->logo)) {
            Storage::disk('public')->delete($user->logo);
        }

        $user->delete();

        return redirect()->route('admin.user.user')->with('success', 'User berhasil dihapus!');
    }

    public function showSubUser($id)
    {
        $parentUser = User::findOrFail($id);

        if ($parentUser->usertype === 'hotel' && $parentUser->hotel_id) {
            $subUsers = User::where('hotel_id', $parentUser->hotel_id)
                ->whereNotIn('usertype', ['admin', 'hotel', 'resto'])
                ->get();
        } elseif ($parentUser->usertype === 'resto' && $parentUser->resto_id) {
            $subUsers = User::where('resto_id', $parentUser->resto_id)
                ->whereNotIn('usertype', ['admin', 'hotel', 'resto'])
                ->get();
        } else {
            $subUsers = collect();
        }

        return view('admin.user.subusers', compact('parentUser', 'subUsers'));
    }
}
