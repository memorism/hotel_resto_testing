<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Tambah Kamar Hotel') }}
            </h2>
            {{-- <a href="{{ route('hotel.rooms.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a> --}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Detail Kamar</h3>

                    <form action="{{ route('hotel.rooms.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="room_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe
                                    Kamar</label>
                                <input type="text" name="room_type" id="room_type"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out"
                                    value="{{ old('room_type') }}" placeholder="Masukkan tipe kamar" required>
                                @error('room_type')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea name="description" id="description"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out"
                                    rows="3" placeholder="Masukkan deskripsi kamar">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="total_rooms" class="block text-sm font-medium text-gray-700 mb-1">Jumlah
                                        Kamar</label>
                                    <input type="number" name="total_rooms" id="total_rooms" min="1"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out"
                                        value="{{ old('total_rooms') }}" placeholder="0" required>
                                    @error('total_rooms')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="price_per_room"
                                        class="block text-sm font-medium text-gray-700 mb-1">Harga per Kamar</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                                        <input type="number" name="price_per_room" id="price_per_room" step="0.01"
                                            class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out"
                                            value="{{ old('price_per_room') }}" placeholder="0" required>
                                    </div>
                                    @error('price_per_room')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 pt-6">
                                <a href="{{ route('hotel.rooms.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>