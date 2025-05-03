<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Kamar Hotel') }}
            </h2>
            <a href="{{ route('hotel.rooms.create') }}" class="btn btn-primary">Tambah Kamar</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center px-4 py-2">No</th>
                                    <th scope="col" class="text-center px-4 py-2">Tipe Kamar</th>
                                    <th scope="col" class="text-center px-4 py-2">Jumlah Kamar</th>
                                    <th scope="col" class="text-center px-4 py-2">Harga Kamar</th>
                                    <th scope="col" class="text-center px-4 py-2">Deskripsi</th>
                                    <th scope="col" class="text-center px-4 py-2" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms as $index => $room)
                                    <tr class="text-center">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2">{{ $room->room_type }}</td>
                                        <td class="px-4 py-2">{{ $room->total_rooms }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($room->price_per_room, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2">{{ $room->description }}</td>
                                        <td class="px-4 py-2 flex justify-center gap-2">
                                            <a href="{{ route('hotel.rooms.edit', $room->id) }}"
                                                class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('hotel.rooms.destroy', $room->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus kamar ini?')"
                                                    class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center px-4 py-4">Belum ada data kamar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>