<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kamar Hotel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-md rounded-md">
                <form action="{{ route('hotel.rooms.update', $room->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="room_type" class="block font-medium text-sm text-gray-700">Tipe Kamar</label>
                        <input type="text" name="room_type" id="room_type"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               value="{{ old('room_type', $room->room_type) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                  rows="3">{{ old('description', $room->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="total_rooms" class="block font-medium text-sm text-gray-700">Jumlah Kamar</label>
                        <input type="number" name="total_rooms" id="total_rooms" min="1"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               value="{{ old('total_rooms', $room->total_rooms) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="price_per_room" class="block font-medium text-sm text-gray-700">Harga per Kamar</label>
                        <input type="number" name="price_per_room" id="price_per_room" step="0.01"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               value="{{ old('price_per_room', $room->price_per_room) }}" required>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('hotel.rooms.rooms') }}"
                           class="mr-4 px-4 py-2 bg-gray-300 text-black rounded-md hover:bg-gray-400">Batal</a>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
