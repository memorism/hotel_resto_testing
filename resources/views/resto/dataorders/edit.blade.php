<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Upload Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Edit File Upload</h3>

                    <!-- Menampilkan pesan error -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form untuk edit file -->
                    <form action="{{ route('resto.dataorders.update', $upload->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mb-4">
                            <label for="file" class="block text-gray-700 font-medium">Upload File Baru
                                (opsional):</label>
                            <input type="file" id="file" name="file"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="file_name" class="block text-gray-700 font-medium">Nama File:</label>
                            <input type="text" id="file_name" name="file_name"
                                value="{{ old('file_name', $upload->file_name) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-medium">Deskripsi:</label>
                            <textarea id="description" name="description"
                                class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $upload->description) }}</textarea>
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-700">
                                Simpan Perubahan
                            </button>

                            <a href="{{ route('resto.dataorders.index') }}"
                                class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-600">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>