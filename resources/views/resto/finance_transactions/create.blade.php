<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Transaksi Keuangan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('financeresto.finances.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal -->
                            <div class="space-y-1">
                                <label for="tanggal" class="block text-sm font-medium text-gray-700">
                                    Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal" id="tanggal" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    value="{{ old('tanggal', date('Y-m-d')) }}">
                            </div>

                            <!-- Jenis Transaksi -->
                            <div class="space-y-1">
                                <label for="jenis" class="block text-sm font-medium text-gray-700">
                                    Jenis Transaksi <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis" id="jenis" required
                                    class="mt-1 block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Pilih Jenis Transaksi</option>
                                    <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>
                                        Pemasukan</option>
                                    <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>
                                        Pengeluaran</option>
                                </select>
                            </div>

                            <!-- Nominal -->
                            <div class="space-y-1 md:col-span-2">
                                <label for="nominal" class="block text-sm font-medium text-gray-700">
                                    Nominal (Rp) <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="nominal" id="nominal" required
                                        class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="0" value="{{ old('nominal') }}">
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="space-y-1 md:col-span-2">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">
                                    Keterangan <span class="text-gray-400">(Opsional)</span>
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Tambahkan keterangan transaksi">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-5">
                            <a href="{{ route('financeresto.finances.index') }}"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>