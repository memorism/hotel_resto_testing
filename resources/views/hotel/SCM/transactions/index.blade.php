<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Riwayat Transaksi Barang</h2>
            <a href="{{ route('scm.transactions.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 rounded shadow">
                @if($transactions->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-sm border border-gray-300">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 border">Tanggal</th>
                                    <th class="px-4 py-2 border">Barang</th>
                                    <th class="px-4 py-2 border">Tipe</th>
                                    <th class="px-4 py-2 border">Jumlah</th>
                                    <th class="px-4 py-2 border">Catatan</th>
                                    <th class="px-4 py-2 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $trx)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border">
                                            {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}</td>
                                        <td class="px-4 py-2 border">{{ $trx->supply->name ?? '-' }}</td>
                                        <td class="px-4 py-2 border capitalize">{{ $trx->type }}</td>
                                        <td class="px-4 py-2 border">{{ $trx->quantity }}</td>
                                        <td class="px-4 py-2 border">{{ $trx->note ?? '-' }}</td>
                                        <td class="px-4 py-2 border text-center relative">
                                            <x-dropdown-action
                                                :delete-url="route('scm.transactions.destroy', $trx)" />
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <p class="text-gray-600">Belum ada transaksi.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>