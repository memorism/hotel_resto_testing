<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Pesanan Restoran') }}
            </h2>
            <a href="{{ route('cashierresto.orders.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pesanan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Filter dan Pencarian --}}
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            {{-- Search --}}
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                                <div class="relative">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        placeholder="Nama customer / item"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-10"
                                        onchange="this.form.submit()">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status"
                                    class="w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Menunggu</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        Ditolak</option>
                                </select>
                            </div>

                            {{-- Dari Tanggal --}}
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari
                                    Tanggal</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    onchange="this.form.submit()">
                            </div>

                            {{-- Sampai Tanggal --}}
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai
                                    Tanggal</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    onchange="this.form.submit()">
                            </div>

                            {{-- Jumlah Per Halaman --}}
                            <div>
                                <label for="perPage"
                                    class="block text-sm font-medium text-gray-700 mb-1">Tampilkan</label>
                                <select name="perPage" id="perPage"
                                    class="w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    onchange="this.form.submit()">
                                    <option value="5" {{ request('perPage') == '5' ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10</option>
                                    <option value="all" {{ request('perPage') == 'all' ? 'selected' : '' }}>Semua</option>
                                </select>

                            </div>

                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=customer_name&direction={{ request('sort') === 'customer_name' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Konsumen
                                            @if(request('sort') === 'customer_name')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=received_by&direction={{ request('sort') === 'received_by' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Gender
                                            @if(request('sort') === 'received_by')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=order_date&direction={{ request('sort') === 'order_date' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Tanggal
                                            @if(request('sort') === 'order_date')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=time_order&direction={{ request('sort') === 'time_order' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Waktu
                                            @if(request('sort') === 'time_order')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=item_name&direction={{ request('sort') === 'item_name' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Item
                                            @if(request('sort') === 'item_name')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=item_type&direction={{ request('sort') === 'item_type' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Jenis
                                            @if(request('sort') === 'item_type')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=item_price&direction={{ request('sort') === 'item_price' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Harga
                                            @if(request('sort') === 'item_price')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=quantity&direction={{ request('sort') === 'quantity' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Qty
                                            @if(request('sort') === 'quantity')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=transaction_amount&direction={{ request('sort') === 'transaction_amount' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Total
                                            @if(request('sort') === 'transaction_amount')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=transaction_type&direction={{ request('sort') === 'transaction_type' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Transaksi
                                            @if(request('sort') === 'transaction_type')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=type_of_order&direction={{ request('sort') === 'type_of_order' && request('direction') === 'asc' ? 'desc' : 'asc' }}"
                                            class="flex items-center">
                                            Tipe Pesanan
                                            @if(request('sort') === 'type_of_order')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 sticky right-0 bg-gray-50">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">
                                            @if ($order->approval_status === 'pending')
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Menunggu
                                                </span>
                                            @elseif ($order->approval_status === 'approved')
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Disetujui
                                                </span>
                                            @elseif ($order->approval_status === 'rejected')
                                                <div>
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Ditolak
                                                    </span>
                                                    @if ($order->rejection_note)
                                                        <div class="text-xs text-red-500 italic mt-1">
                                                            {{ $order->rejection_note }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $order->customer->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $order->received_by }}</td>
                                        <td class="px-6 py-4">{{ $order->order_date }}</td>
                                        <td class="px-6 py-4">{{ $order->time_order }}</td>
                                        <td class="px-6 py-4">{{ $order->item_name }}</td>
                                        <td class="px-6 py-4">{{ $order->item_type }}</td>
                                        <td class="px-6 py-4">{{ number_format($order->item_price, 2) }}</td>
                                        <td class="px-6 py-4">{{ $order->quantity }}</td>
                                        <td class="px-6 py-4">{{ number_format($order->transaction_amount, 2) }}</td>
                                        <td class="px-6 py-4">{{ $order->transaction_type }}</td>
                                        <td class="px-6 py-4">{{ $order->type_of_order }}</td>
                                        <td class="px-6 py-4 sticky right-0 bg-white">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('cashierresto.orders.edit', $order) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('cashierresto.orders.destroy', $order) }}"
                                                    method="POST" onsubmit="return confirm('Yakin hapus?')"
                                                    class="inline-block">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data pesanan ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="px-6 py-4">
                                {{ $orders->appends(request()->all())->links() }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>