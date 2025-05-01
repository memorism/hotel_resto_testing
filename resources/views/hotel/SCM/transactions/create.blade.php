<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Tambah Transaksi Barang</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded">
                <form method="POST" action="{{ route('scm.transactions.store') }}">
                    @csrf

                    {{-- Pilih Barang --}}
                    <div class="mb-4">
                        <label for="supply_id" class="block text-gray-700 font-medium">Pilih Barang</label>
                        <select name="supply_id" id="supply_id" class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            @foreach($supplies as $supply)
                                <option value="{{ $supply->id }}" {{ old('supply_id') == $supply->id ? 'selected' : '' }}>
                                    {{ $supply->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supply_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipe Transaksi --}}
                    <div class="mb-4">
                        <label for="type" class="block font-medium text-gray-700">Tipe Transaksi</label>
                        <select name="type" id="type" class="w-full border rounded px-3 py-2">
                            <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Masuk</option>
                            <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Keluar</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="mb-4">
                        <label for="quantity" class="block font-medium text-gray-700">Jumlah</label>
                        <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity') }}"
                            class="w-full border rounded px-3 py-2" required>
                        @error('quantity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-4">
                        <label for="transaction_date" class="block font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="transaction_date" id="transaction_date"
                            value="{{ old('transaction_date') }}" class="w-full border rounded px-3 py-2" required>
                        @error('transaction_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    <div class="mb-4">
                        <label for="note" class="block font-medium text-gray-700">Catatan</label>
                        <textarea name="note" id="note" rows="3"
                            class="w-full border rounded px-3 py-2">{{ old('note') }}</textarea>
                        @error('note')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('scm.transactions.index') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>