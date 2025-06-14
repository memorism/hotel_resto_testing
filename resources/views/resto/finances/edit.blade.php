<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
                {{ __('Edit Transaksi Keuangan Resto') }}
            </h2>
            {{-- <a href="{{ route('resto.finances.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a> --}}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('resto.finances.update', $finance->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Tanggal --}}
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal" id="tanggal" required
                                    value="{{ \Carbon\Carbon::parse($finance->tanggal)->format('Y-m-d') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            {{-- Jenis Transaksi --}}
                            <div>
                                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Transaksi <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis" id="jenis" required
                                    class="w-full rounded-lg border-gray-300 p-2 shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="pemasukan" {{ $finance->jenis === 'pemasukan' ? 'selected' : '' }}>
                                        Pemasukan</option>
                                    <option value="pengeluaran" {{ $finance->jenis === 'pengeluaran' ? 'selected' : '' }}>
                                        Pengeluaran</option>
                                </select>
                            </div>

                            {{-- Nominal --}}
                            <div class="md:col-span-2">
                                <label for="nominal" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nominal (Rp) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="nominal" id="nominal" required step="0.01"
                                        value="{{ $finance->nominal }}"
                                        class="w-full rounded-lg border-gray-300 pl-12 pr-4 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        placeholder="0">
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="md:col-span-2">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="4"
                                    class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Masukkan keterangan transaksi...">{{ $finance->keterangan }}</textarea>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('resto.finances.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>