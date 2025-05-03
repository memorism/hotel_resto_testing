<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Manajemen Transaksi Keuangan Hotel') }}
            </h2>
            <a href="{{ route('finance.create') }}" class="btn btn-primary">
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter Form -->
                <div class="bg-white p-6 rounded-md shadow mb-6">
                <form method="GET" class="flex flex-col sm:flex-row sm:items-end gap-2 flex-wrap">
                    
                    {{-- Bulan --}}
                    <div class="w-full sm:w-40">
                        <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                        <select name="month" id="month"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200  py-2 px-3 text-sm">
                            <option value="">Semua</option>
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jenis --}}
                    <div class="w-full sm:w-40">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                        <select name="type" id="type"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 py-2 px-3 text-sm">
                            <option value="">Semua</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>

                    {{-- Tombol --}}
                    <div class="w-full sm:w-auto">
                        <button type="submit"
                            class="w-full sm:w-auto bg-indigo-600 text-white px-4 py-2 rounded-md shadow hover:bg-indigo-700 text-sm">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="bg-white p-6 rounded-md shadow">
                @if($finance->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border border-gray-200">
                            <thead class="bg-gray-50 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 border">Tanggal</th>
                                    <th class="px-4 py-2 border">Jenis</th>
                                    <th class="px-4 py-2 border">Kategori</th>
                                    <th class="px-4 py-2 border text-right">Jumlah</th>
                                    <th class="px-4 py-2 border">Metode</th>
                                    <th class="px-4 py-2 border text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($finance as $trx)
                                    @php
                                        $isToday = \Carbon\Carbon::parse($trx->transaction_date)->isToday();
                                    @endphp
                                    <tr class="{{ $isToday ? 'bg-yellow-50' : 'hover:bg-gray-50' }}">
                                        <td class="px-4 py-2">{{ $trx->transaction_date }}</td>
                                        <td class="px-4 py-2">
                                            @if($trx->transaction_type === 'income')
                                                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Pemasukan</span>
                                            @else
                                                <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Pengeluaran</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">{{ $trx->category }}</td>
                                        <td class="px-4 py-2 text-right">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2">{{ $trx->payment_method }}</td>
                                        <td class="px-4 py-2 text-center relative z-0">
                                            <x-dropdown-action
                                                :edit-url="route('finance.edit', $trx)"
                                                :delete-url="route('finance.destroy', $trx)" />
                                        </td>
                                        
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $finance->links() }}
                    </div>
                @else
                    <div class="text-gray-500 text-center py-6">
                        Belum ada transaksi keuangan.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
