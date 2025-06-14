<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Resto;
use Illuminate\Support\Facades\Hash;

class AdminSubuserController extends Controller
{
    public function index($id, Request $request)
    {
        $parentUser = User::findOrFail($id);

        $query = User::query()
            ->whereNotIn('usertype', ['admin', 'hotelnew', 'restonew']);

        if ($parentUser->usertype === 'hotelnew') {
            $query->where('hotel_id', $parentUser->hotel_id);
        } elseif ($parentUser->usertype === 'restonew') {
            $query->where('resto_id', $parentUser->resto_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Handle status filter
        if ($request->status === 'deleted') {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');
        }

        // Handle sorting
        $sort = $request->get('sort', 'name'); // Default sort by name
        $direction = $request->get('direction', 'asc'); // Default direction ascending

        // Validate sort column
        $allowedSortColumns = ['name', 'email', 'usertype'];
        if (!in_array($sort, $allowedSortColumns)) {
            $sort = 'name';
        }

        $query->orderBy($sort, $direction);

        $subUsers = $query->paginate(10);

        return view('admin.user.subuser.index', compact('parentUser', 'subUsers'));
    }


    public function create($id)
    {
        $parentUser = User::findOrFail($id);
        return view('admin.user.subuser.create', compact('parentUser'));
    }


    public function store(Request $request, $id)
    {
        $parentUser = User::findOrFail($id); // tambahkan ini untuk dapat hotel/resto ID

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'usertype' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->usertype = $request->usertype;

        // pengaitan ke hotel/resto berdasarkan parent
        if ($parentUser->usertype === 'hotelnew') {
            $user->hotel_id = $parentUser->hotel_id;
        } elseif ($parentUser->usertype === 'restonew') {
            $user->resto_id = $parentUser->resto_id;
        }

        $user->save();


        return redirect()->route('admin.user.subuser.index', $id)->with('success', 'Subuser berhasil ditambahkan.');
    }


    public function edit($subuserId)
    {
        $subuser = User::findOrFail($subuserId);

        $parentUser = $subuser->hotel_id
            ? User::where('hotel_id', $subuser->hotel_id)->where('usertype', 'hotelnew')->first()
            : User::where('resto_id', $subuser->resto_id)->where('usertype', 'restonew')->first();

        return view('admin.user.subuser.edit', compact('subuser', 'parentUser'));
    }


    public function update(Request $request, $subuserId)
    {
        $subuser = User::findOrFail($subuserId);

        // Validasi
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $subuser->id,
            'usertype' => 'required|string',
            'old_password' => 'required|string', // ⬅️ Wajib isi password lama apa pun perubahan
        ];

        // Jika password baru ingin diganti
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|confirmed|min:6';
        }

        $validated = $request->validate($rules);

        // Selalu cek password lama
        if (!Hash::check($request->old_password, $subuser->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.'])->withInput();
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $subuser->password = Hash::make($request->password);
        }

        // Update data lainnya
        $subuser->name = $request->name;
        $subuser->email = $request->email;
        $subuser->usertype = $request->usertype;
        $subuser->save();

        // Redirect ke parent user
        $redirectId = $subuser->hotel_id
            ? User::where('hotel_id', $subuser->hotel_id)->where('usertype', 'hotelnew')->value('id')
            : User::where('resto_id', $subuser->resto_id)->where('usertype', 'restonew')->value('id');

        return redirect()->route('admin.user.subuser.index', $redirectId)
            ->with('success', 'Subuser berhasil diperbarui.');
    }


    public function destroy($subuserId)
    {
        $subuser = User::findOrFail($subuserId);
        $redirectId = $subuser->hotel_id
            ? User::where('hotel_id', $subuser->hotel_id)->where('usertype', 'hotelnew')->value('id')
            : User::where('resto_id', $subuser->resto_id)->where('usertype', 'restonew')->value('id');

        $subuser->delete(); // This will now perform a soft delete

        return redirect()->route('admin.user.subuser.index', $redirectId)
            ->with('success', 'Subuser berhasil dihapus.');
    }

    public function restore($subuserId)
    {
        $subuser = User::withTrashed()->findOrFail($subuserId);
        $redirectId = $subuser->hotel_id
            ? User::where('hotel_id', $subuser->hotel_id)->where('usertype', 'hotelnew')->value('id')
            : User::where('resto_id', $subuser->resto_id)->where('usertype', 'restonew')->value('id');

        $subuser->restore();

        return redirect()->route('admin.user.subuser.index', $redirectId)
            ->with('success', 'Subuser berhasil dipulihkan.');
    }

}

