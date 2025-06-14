<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Tambah Transaksi Inventori') }}
            </h2>
            {{-- <a href="{{ route('scm.transactions.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a> --}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form method="POST" action="{{ route('scm.transactions.store') }}" class="p-6 space-y-6">
                    @csrf

                    {{-- Pilih Inventori --}}
                    <div class="space-y-2">
                        <label for="supply_id" class="block text-sm font-medium text-gray-700">
                            Pilih Inventori <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <select name="supply_id" id="supply_id"
                                class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm bg-white">
                                <option value="">Pilih Inventori</option>
                                @foreach($supplies as $supply)
                                    <option value="{{ $supply->id }}" {{ old('supply_id') == $supply->id ? 'selected' : '' }}>
                                        {{ $supply->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('supply_id')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipe Transaksi --}}
                    <div class="space-y-2">
                        <label for="type" class="block text-sm font-medium text-gray-700">
                            Tipe Transaksi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </div>
                            <select name="type" id="type"
                                class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm bg-white">
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Masuk</option>
                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Keluar</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('type')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="space-y-2">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">
                            Jumlah <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                            </div>
                            <input type="number" id="quantity" name="quantity" min="1" value="{{ old('quantity') }}"
                                required
                                class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                placeholder="Masukkan jumlah">
                        </div>
                        @error('quantity')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="space-y-2">
                        <label for="transaction_date" class="block text-sm font-medium text-gray-700">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" id="transaction_date" name="transaction_date"
                                value="{{ old('transaction_date') }}" required
                                class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        @error('transaction_date')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    <div class="space-y-2">
                        <label for="note" class="block text-sm font-medium text-gray-700">
                            Catatan
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="pointer-events-none absolute inset-y-3 left-0 flex items-start pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <textarea id="note" name="note" rows="3"
                                class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm resize-none"
                                placeholder="Tambahkan catatan transaksi...">{{ old('note') }}</textarea>
                        </div>
                        @error('note')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <a href="{{ route('scm.transactions.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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