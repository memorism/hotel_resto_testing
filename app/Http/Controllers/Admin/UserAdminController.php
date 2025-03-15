<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'usertype', 'created_at', 'logo')->get();
        return view('admin.user.user', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create'); 
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'usertype' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public'); // Simpan di storage/public/logos/
        }

        // Simpan user baru ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype,
            'logo' => $logoPath, // Simpan hanya PATH gambar
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
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'usertype' => 'required|string',
            'old_password' => 'required|string|min:8', 
            'password' => 'nullable|string|confirmed|min:8', 
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('logo')) {
            if ($user->logo) {
                Storage::disk('public')->delete($user->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $user->logo = $logoPath;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->usertype = $request->usertype;
        $user->save();

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

}
