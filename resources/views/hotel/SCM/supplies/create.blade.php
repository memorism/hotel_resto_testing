<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Tambah Barang</h2>
    </x-slot>

    <div class="py-6">
        <div class="bg-white p-6 rounded shadow max-w-2xl mx-auto">
            <form method="POST" action="{{ route('scm.supplies.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium">Nama Barang</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Kategori</label>
                    <input type="text" name="category" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Jumlah Awal</label>
                    <input type="number" name="quantity" min="0" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Satuan</label>
                    <input type="text" name="unit" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('scm.supplies.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>