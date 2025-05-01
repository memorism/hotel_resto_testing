<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">
                Upload Data Migrasi Keuangan
            </h2>
            <a href="{{ asset('storage/template_finance.xlsx') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                📥 Download Template Excel
            </a>

        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('finance.migrasi.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 font-medium mb-1">File Excel <span
                                class="text-red-500">*</span></label>
                        <input type="file" name="file" accept=".xlsx,.xls" required
                            class="w-full border px-3 py-2 rounded shadow-sm">
                        @error('file') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 font-medium mb-1">Deskripsi</label>
                        <textarea name="description" rows="3"
                            class="w-full border px-3 py-2 rounded shadow-sm">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('finance.migrasi.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Kembali
                        </a>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>