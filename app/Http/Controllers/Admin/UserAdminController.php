<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'usertype', 'created_at')->get();
        return view('admin.user.user', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create'); // Memindahkan auth.register ke admin.user.create
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
            'usertype' => 'required|string'
        ]);

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype, // Pastikan ada di database
        ]);

        return redirect()->route('admin.user.user')->with('success', 'User berhasil ditambahkan!');
    }

    public function destroy($id): RedirectResponse
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->route('admin.user.user')->with('success', 'User berhasil dihapus!');
    }
}
