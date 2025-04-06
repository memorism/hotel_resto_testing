<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class RoomController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $rooms = Room::where('user_id', auth()->id())->get();
        return view('hotel.rooms.rooms', compact('rooms'));
    }

    public function create()
    {
        return view('hotel.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_type' => 'required|string',
            'description' => 'nullable|string',
            'total_rooms' => 'required|integer|min:1',
            'price_per_room' => 'required|numeric|min:0',
        ]);

        Room::create([
            'room_type' => $request->room_type,
            'description' => $request->description,
            'total_rooms' => $request->total_rooms,
            'price_per_room' => $request->price_per_room,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('hotel.rooms.rooms')->with('success', 'Data kamar berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
            if ($room->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    } // Optional: keamanan supaya user tidak bisa edit kamar hotel lain
        return view('hotel.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
            if ($room->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

        $request->validate([
            'room_type' => 'required|string',
            'description' => 'nullable|string',
            'total_rooms' => 'required|integer|min:1',
            'price_per_room' => 'required|numeric|min:0',
        ]);

        $room->update($request->only('room_type', 'description', 'total_rooms', 'price_per_room'));

        return redirect()->route('hotel.rooms.rooms')->with('success', 'Data kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $this->authorize('delete', $room);
        $room->delete();
        return redirect()->route('hotel.rooms.rooms')->with('success', 'Kamar berhasil dihapus.');
    }

}
