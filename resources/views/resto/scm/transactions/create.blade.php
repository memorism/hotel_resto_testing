<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('scmresto.transactions.index') }}" class="mr-4">
                <svg class="w-6 h-6 text-gray-600 hover:text-gray-900 transition-colors duration-150" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Tambah Transaksi Inventori
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Form Header -->
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Transaksi</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Lengkapi informasi transaksi Inventori di bawah ini
                    </p>
                </div>

                <!-- Form Content -->
                <form action="{{ route('scmresto.transactions.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Inventori --}}
                        <div class="md:col-span-2">
                            <label for="resto_supply_id" class="block text-sm font-medium p-2 text-gray-700 mb-1">
                                Nama Inventori <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 p-2 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <select name="resto_supply_id" id="resto_supply_id"
                                    class="pl-10 block w-full py-2 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                    <option value="">Pilih Inventori</option>
                                    @foreach ($supplies as $supply)
                                        <option value="{{ $supply->id }}" class="py-2">
                                            {{ $supply->nama_barang }}
                                            <span class="text-gray-500">(Stok: {{ $supply->stok }})</span>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" id="tanggal" name="tanggal" required
                                    class="pl-10 block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        {{-- Jumlah --}}
                        <div>
                            <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">
                                Jumlah <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                </div>
                                <input type="number" id="jumlah" name="jumlah" min="1" required
                                    class="pl-10 block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Masukkan jumlah">
                            </div>
                        </div>

                        {{-- Jenis Transaksi --}}
                        <div>
                            <label for="jenis_transaksi" class="block text-sm font-medium text-gray-700 mb-1">
                                Jenis Transaksi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </div>
                                <select name="jenis_transaksi" id="jenis_transaksi"
                                    class="pl-10 block w-full py-2 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="masuk" class="text-green-600">Masuk</option>
                                    <option value="keluar" class="text-red-600">Keluar</option>
                                </select>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="md:col-span-2">
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">
                                Keterangan
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute top-3 left-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                </div>
                                <textarea id="keterangan" name="keterangan" rows="6"
                                    class="pl-10 block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Tambahkan keterangan transaksi (opsional)"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                        <a href="{{ route('scmresto.transactions.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>