<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Upload Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Edit Upload Order</h3>

                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Form Edit Upload Order -->
                    <form action="{{ route('hotel.databooking.update', $uploadOrder->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama File -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="file_name">Nama File</label>
                            <input type="text" name="file_name" id="file_name"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                                value="{{ old('file_name', $uploadOrder->file_name) }}" required>
                            @error('file_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="description">Deskripsi</label>
                            <textarea name="description" id="description"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                                required>{{ old('description', $uploadOrder->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload File Baru -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="file">Upload File Baru (Opsional)</label>
                            <input type="file" name="file" id="file"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
                            <small class="text-gray-500">Jika Anda mengunggah file baru, data yang lama akan dihapus dan diimport ulang.</small>
                            @error('file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-4 flex space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('hotel.databooking.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
