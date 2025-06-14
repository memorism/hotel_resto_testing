<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Tambah Inventori') }}
            </h2>
            {{-- <a href="{{ route('hotel.scm.index') }}"
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
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Detail Inventori</h3>

                    <form method="POST" action="{{ route('hotel.scm.store') }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                    Inventori</label>
                                <input type="text" name="name" id="name"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out"
                                    placeholder="Masukkan nama Inventori" required>
                            </div>

                            <div>
                                <label for="category"
                                    class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <input type="text" name="category" id="category"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out"
                                    placeholder="Masukkan kategori Inventori">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah
                                        Awal</label>
                                    <input type="number" name="quantity" id="quantity" min="0"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out"
                                        placeholder="0" required>
                                </div>

                                <div>
                                    <label for="unit"
                                        class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                                    <input type="text" name="unit" id="unit"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out"
                                        placeholder="pcs/kg/dll" required>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 pt-6">
                                <a href="{{ route('hotel.scm.index') }}"
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