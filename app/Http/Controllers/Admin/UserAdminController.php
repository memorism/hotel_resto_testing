<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\hotel;
use App\Models\resto;

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


    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
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
            ? $request->file('logo')->store('logos', 'public')
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

        if ($user->logo) {
            return response()->file(storage_path('app/public/' . $user->logo));
        }

        return response()->file(public_path('images/default.png')); // Jika tidak ada logo
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
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
            if ($user->logo) {
                Storage::disk('public')->delete($user->logo);
            }
            $user->logo = $request->file('logo')->store('logos', 'public');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype,
            'hotel_id' => $request->hotel_id,
            'resto_id' => $request->resto_id,
        ]);

        return redirect()->route('admin.user.user')->with('success', 'User berhasil diperbarui!');
    }


    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->logo) {
            Storage::disk('public')->delete($user->logo);
        }

        $user->delete();

        return redirect()->route('admin.user.user')->with('success', 'User berhasil dihapus!');
    }

    public function showSubUser($id)
    {
        $parentUser = User::findOrFail($id); // Ambil parent user (hotel/resto)
    
        if ($parentUser->usertype === 'hotel') {
            if ($parentUser->hotel_id === null) {
                // Hotel belum punya hotel_id → subUser kosong
                $subUsers = collect();
            } else {
                $subUsers = User::whereNotNull('hotel_id') // Pastikan ada hotel_id
                    ->where('hotel_id', $parentUser->hotel_id)
                    ->whereNotIn('usertype', ['hotel', 'admin', 'resto'])
                    ->get();
            }
        } elseif ($parentUser->usertype === 'resto') {
            if ($parentUser->resto_id === null) {
                // Resto belum punya resto_id → subUser kosong
                $subUsers = collect();
            } else {
                $subUsers = User::whereNotNull('resto_id') // Pastikan ada resto_id
                    ->where('resto_id', $parentUser->resto_id)
                    ->whereNotIn('usertype', ['hotel', 'admin', 'resto'])
                    ->get();
            }
        } else {
            abort(404, 'User ini bukan hotel atau resto.');
        }
    
        return view('admin.user.subusers', compact('parentUser', 'subUsers'));
    }
    
}
