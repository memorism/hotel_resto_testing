<x-app-layout x-cloak>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Daftar Pesanan Restoran') }}
            </h2>
            {{-- <a href="{{ route('resto.orders.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pesanan
            </a> --}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6">
                    @if (session('success'))
                        <div
                            class="mb-6 p-4 bg-green-50 border border-green-200 text-green-600 rounded-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Filter --}}
                    <div class="mb-6">
                        {{-- Filter Section --}}
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-6">
                            <form method="GET" action="{{ route('resto.orders.index') }}"
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="space-y-2">
                                    <label for="status" class="block text-sm font-medium text-gray-700">
                                        Status Persetujuan
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <select name="status" id="status"
                                            class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm bg-white"
                                            onchange="this.form.submit()">
                                            <option value="">Semua Status</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="search" class="block text-sm font-medium text-gray-700">
                                        Cari (Nama/Item)
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                                            placeholder="Cari item atau customer..."
                                            class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                            onchange="this.form.submit()">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">
                                        Dari Tanggal
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="date" name="start_date" id="start_date"
                                            value="{{ request('start_date') }}"
                                            class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                            onchange="this.form.submit()">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">
                                        Sampai Tanggal
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="date" name="end_date" id="end_date"
                                            value="{{ request('end_date') }}"
                                            class="block w-full rounded-lg py-2.5 pl-10 pr-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                            onchange="this.form.submit()">
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Bulk Actions --}}
                        <div class="flex justify-end gap-3 mt-6">
                            <form method="POST" action="{{ route('resto.orders.bulkApprove') }}" id="bulkApproveForm">
                                @csrf
                                <button type="submit" onclick="return handleBulkApprove()"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Approve Terpilih
                                </button>
                            </form>
                            <button type="button" onclick="openBulkRejectModal()"
                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm transition duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Tolak Terpilih
                            </button>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200" id="bulkWrapper">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 border-b border-gray-200">
                                        <div class="flex items-center justify-center">
                                            <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'no', 'direction' => request('sort') == 'no' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        No
                                        @if (request('sort') == 'no')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'approval_status', 'direction' => request('sort') == 'approval_status' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Status
                                        @if (request('sort') == 'approval_status')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort') == 'customer_name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Diterima Oleh
                                        @if (request('sort') == 'customer_name')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'order_date', 'direction' => request('sort') == 'order_date' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Tanggal
                                        @if (request('sort') == 'order_date')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'time_order', 'direction' => request('sort') == 'time_order' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Waktu
                                        @if (request('sort') == 'time_order')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'item_name', 'direction' => request('sort') == 'item_name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Item
                                        @if (request('sort') == 'item_name')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'item_type', 'direction' => request('sort') == 'item_type' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Jenis
                                        @if (request('sort') == 'item_type')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-right text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'item_price', 'direction' => request('sort') == 'item_price' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Harga
                                        @if (request('sort') == 'item_price')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-center text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'quantity', 'direction' => request('sort') == 'quantity' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Qty
                                        @if (request('sort') == 'quantity')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-right text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'transaction_amount', 'direction' => request('sort') == 'transaction_amount' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Total
                                        @if (request('sort') == 'transaction_amount')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'transaction_type', 'direction' => request('sort') == 'transaction_type' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Tipe Transaksi
                                        @if (request('sort') == 'transaction_type')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th class="sticky top-0 z-10 bg-gray-50 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 border-b border-gray-200 cursor-pointer"
                                        onclick="window.location.href = '{{ route('resto.orders.index', array_merge(request()->query(), ['sort' => 'type_of_order', 'direction' => request('sort') == 'type_of_order' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                        Tipe Pesanan
                                        @if (request('sort') == 'type_of_order')
                                            <span class="ml-1">
                                                @if (request('direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            </span>
                                        @endif
                                    </th>
                                    <th
                                        class="sticky top-0 right-0 z-20 bg-gray-50 px-3 py-3.5 text-center text-sm font-semibold text-gray-900 border-b border-gray-200">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        {{-- <td>{{ $order->id }}</td> --}}
                                        <td class="whitespace-nowrap px-3 py-4">
                                            <div class="flex items-center justify-center">
                                                @if($order->approval_status === 'pending')
                                                    <input type="checkbox"
                                                        class="order-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                        value="{{ $order->id }}">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-500">{{ $loop->iteration }}
                                        </td>
                                        {{-- <td class="whitespace-nowrap px-3 py-4">
                                            @if ($order->approval_status === 'pending')
                                            <span
                                                class="inline-flex items-center rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                                                <svg class="mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Menunggu
                                            </span>
                                            @elseif ($order->approval_status === 'approved')
                                            <span
                                                class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/20">
                                                <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Disetujui
                                            </span>
                                            @elseif ($order->approval_status === 'rejected')
                                            <div>
                                                <span
                                                    class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-600/20">
                                                    <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor"
                                                        viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Ditolak
                                                </span>
                                                @if ($order->rejection_note)
                                                <div class="mt-1 text-xs text-red-600 italic">
                                                    {{ $order->rejection_note }}
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </td> --}}
                                        <td class="whitespace-nowrap px-3 py-4">
                                            @if ($order->approval_status === 'pending')
                                                <span
                                                    class="inline-flex items-center rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                                                    <svg class="mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor"
                                                        viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Menunggu
                                                </span>
                                            @elseif ($order->approval_status === 'approved')
                                                <span
                                                    class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/20">
                                                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                                        viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Disetujui
                                                </span>
                                            @elseif ($order->approval_status === 'rejected')
                                                <div>
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-600/20">
                                                        <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor"
                                                            viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3" />
                                                        </svg>
                                                        Ditolak
                                                    </span>
                                                    @if ($f->rejection_note)
                                                        <div class="mt-1 text-xs text-red-600 italic">
                                                            {{ $order->rejection_note }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                            {{ $order->customer->name ?? '-' }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-500">{{ $order->order_date }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-500">{{ $order->time_order }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-900 font-medium">
                                            {{ $order->item_name }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-500">{{ $order->item_type }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-right text-gray-500">
                                            {{ number_format($order->item_price) }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-center text-gray-500">
                                            {{ $order->quantity }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-right font-medium text-gray-900">
                                            {{ number_format($order->transaction_amount) }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                            {{ $order->transaction_type }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                            {{ $order->type_of_order }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-right text-sm font-medium sticky right-0 bg-white">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('resto.orders.edit', $order) }}"
                                                    class="inline-flex items-center px-2.5 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm transition-colors duration-150">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('resto.orders.destroy', $order) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-2.5 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm transition-colors duration-150">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $orders->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bulk Reject Modal --}}
    <div id="bulkRejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="min-h-screen px-4 text-center">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        Tolak Pesanan Terpilih
                    </h3>
                    <button type="button" onclick="closeBulkRejectModal()" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('resto.orders.bulkReject') }}">
                    @csrf
                    <div id="selectedOrdersContainer"></div>
                    <div class="mt-4">
                        <label for="bulk_rejection_note" class="block text-sm font-medium text-gray-700">
                            Alasan Penolakan
                        </label>
                        <div class="mt-1">
                            <textarea name="rejection_note" id="bulk_rejection_note" rows="4" required
                                class="block w-full rounded-lg shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Masukkan alasan penolakan..."></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeBulkRejectModal()"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Konfirmasi Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        function toggleSelectAll(source) {
            document.querySelectorAll('.order-checkbox').forEach(cb => cb.checked = source.checked);
        }

        function handleBulkApprove() {
            const form = document.getElementById('bulkApproveForm');
            const selected = document.querySelectorAll('.order-checkbox:checked');

            if (selected.length === 0) {
                alert('Pilih minimal satu pesanan terlebih dahulu.');
                return false;
            }

            selected.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_orders[]';
                input.value = cb.value;
                form.appendChild(input);
            });

            return confirm('Yakin ingin menyetujui pesanan yang dipilih?');
        }

        function openBulkRejectModal() {
            const selected = document.querySelectorAll('.order-checkbox:checked');
            if (selected.length === 0) {
                alert('Pilih minimal satu pesanan terlebih dahulu.');
                return;
            }

            const container = document.getElementById('selectedOrdersContainer');
            container.innerHTML = '';
            selected.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_orders[]';
                input.value = cb.value;
                container.appendChild(input);
            });

            document.getElementById('bulkRejectModal').classList.remove('hidden');
        }

        function closeBulkRejectModal() {
            document.getElementById('bulkRejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>