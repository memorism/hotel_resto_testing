<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Barang</h2>
    </x-slot>

    <div class="py-6">
        <div class="bg-white p-6 rounded shadow max-w-2xl mx-auto">
            <form method="POST" action="{{ route('scm.supplies.update', $supply) }}">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium">Nama Barang</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2"
                        value="{{ old('name', $supply->name) }}" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Kategori</label>
                    <input type="text" name="category" class="w-full border rounded px-3 py-2"
                        value="{{ old('category', $supply->category) }}">
                    @error('category') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Satuan</label>
                    <input type="text" name="unit" class="w-full border rounded px-3 py-2"
                        value="{{ old('unit', $supply->unit) }}" required>
                    @error('unit') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Jumlah Saat Ini</label>
                    <input type="number"  name="quantity" class="w-full border rounded px-3 py-"
                        value="{{ old('quantity', $supply->quantity) }}" required>
                        @error('quantity') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('scm.supplies.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>