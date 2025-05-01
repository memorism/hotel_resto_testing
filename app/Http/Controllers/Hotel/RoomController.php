<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelRoom;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoomController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $hotelId = auth()->user()->hotel_id;
        $rooms = HotelRoom::where('hotel_id', $hotelId)->get();

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

        HotelRoom::create([
            'hotel_id' => auth()->user()->hotel_id,
            'user_id' => auth()->id(),
            'room_type' => $request->room_type,
            'description' => $request->description,
            'total_rooms' => $request->total_rooms,
            'price_per_room' => $request->price_per_room,
        ]);

        return redirect()->route('hotel.rooms.rooms')->with('success', 'Data kamar berhasil ditambahkan.');
    }

    public function edit(HotelRoom $room)
    {
        if ($room->hotel_id !== auth()->user()->hotel_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('hotel.rooms.edit', compact('room'));
    }

    public function update(Request $request, HotelRoom $room)
    {
        if ($room->hotel_id !== auth()->user()->hotel_id) {
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

    public function destroy(HotelRoom $room)
    {
        if ($room->hotel_id !== auth()->user()->hotel_id) {
            abort(403, 'Unauthorized action.');
        }

        $room->delete();

        return redirect()->route('hotel.rooms.rooms')->with('success', 'Kamar berhasil dihapus.');
    }
}
