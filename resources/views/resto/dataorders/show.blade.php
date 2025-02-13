<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('File Upload Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">
                        File Name: {{ $upload->file_name }}
                    </h3>
                    <ul class="mt-2 text-gray-700">
                        <li><strong>Uploaded By:</strong> {{ $upload->user->name }}</li>
                        <li><strong>Upload Date:</strong> {{ $upload->created_at->format('Y-m-d H:i:s') }}</li>
                        <li><strong>Description:</strong> {{ $upload->description ?? 'No description provided' }}</li>
                    </ul>

                    <h3 class="mt-6 text-lg font-semibold">Related Orders</h3>
                    @if ($orders->isEmpty())
                        <p class="mt-2">No data found for this file.</p>
                    @else
                        {{-- Filter dan Pencarian --}}
                        <div class="flex justify-between items-center mb-4">
                            <!-- Filter Per Halaman -->
                            <div class="flex items-center">
                                <label for="perPage" class="mr-2">Tampilkan</label>
                                <select id="perPage" class="form-select form-select-sm"
                                    onchange="window.location.href=this.value">
                                    <option
                                        value="{{ route('resto.dataorders.show', ['uploadId' => $upload->id, 'perPage' => 10]) }}"
                                        {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                    <option
                                        value="{{ route('resto.dataorders.show', ['uploadId' => $upload->id, 'perPage' => 20]) }}"
                                        {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                                    <option
                                        value="{{ route('resto.dataorders.show', ['uploadId' => $upload->id, 'perPage' => 50]) }}"
                                        {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                </select>
                                <label for="perPage" class="ml-2">data</label>
                            </div>

                            {{-- Pencarian --}}
                            <div class="flex items-center">
                                <form action="{{ route('resto.dataorders.show', ['uploadId' => $upload->id]) }}"
                                    method="GET">
                                    <input type="text" name="search" id="search" class="form-input form-input-sm"
                                        placeholder="Search..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary btn-sm ml-2">Search</button>
                                </form>
                            </div>
                        </div>

                        <!-- Table with Data -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full border divide-y divide-gray-200 table-auto">
                                <thead class="bg-gray-50 sticky top-0 z-10">
                                    <tr>
                                        <th class="text-center px-4 py-2">No</th>
                                        <th class="text-center px-4 py-2">Diterima Oleh</th>
                                        <th class="text-center px-4 py-2">Tanggal</th>
                                        <th class="text-center px-4 py-2">Waktu</th>
                                        <th class="text-center px-4 py-2">Item</th>
                                        <th class="text-center px-4 py-2">Jenis</th>
                                        <th class="text-center px-4 py-2">Harga</th>
                                        <th class="text-center px-4 py-2">Qty</th>
                                        <th class="text-center px-4 py-2">Total</th>
                                        <th class="text-center px-4 py-2">Tipe Transaksi</th>
                                        <th class="text-center px-4 py-2">Tipe Pesanan</th>
                                        <th class="text-center px-4 py-2 sticky right-0 bg-white">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center px-4 py-2">{{ $loop->iteration }}</td>
                                            <td class="text-center px-4 py-2">{{ $order->received_by }}</td>
                                            <td class="text-center px-4 py-2">{{ $order->order_date }}</td>
                                            <td class="text-center px-4 py-2">{{ $order->time_order }}</td>
                                            <td class="text-center px-4 py-2">{{ $order->item_name }}</td>
                                            <td class="text-center px-4 py-2">{{ $order->item_type }}</td>
                                            <td class="text-center px-4 py-2">{{ number_format($order->item_price, 2) }}</td>
                                            <td class="text-center px-4 py-2">{{ $order->quantity }}</td>
                                            <td class="text-center px-4 py-2">{{ number_format($order->transaction_amount, 2) }}
                                            </td>
                                            <td class="text-center px-4 py-2">{{ $order->transaction_type }}</td>
                                            <td class="text-center px-4 py-2">{{ $order->type_of_order }}</td>
                                            <td class="text-center px-4 py-2 sticky right-0 bg-white">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('resto.orders.edit', $order) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('resto.orders.destroy', $order) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin hapus?')">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $orders->appends(['search' => request('search'), 'perPage' => request('perPage')])->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>