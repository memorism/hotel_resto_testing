<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                Manajemen Transaksi Keuangan Hotel
            </h2>
            <a href="{{ route('finance.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                + Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter Form -->
            <div class="bg-white p-6 rounded-md shadow mb-6">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bulan</label>
                        <select name="month" class="mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="">Semua</option>
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis</label>
                        <select name="type" class="mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="">Semua</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow hover:bg-indigo-700">
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
                                        <td class="px-4 py-2 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('finance.edit', $trx) }}"
                                                    class="px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-md hover:bg-yellow-600">
                                                    Ubah
                                                </a>
                                                <form method="POST"
                                                   action="{{ route('finance.destroy', $trx) }}"
                                                    style="display:inline;"  onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
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
