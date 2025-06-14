<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-gray-800">
                {{ __('Manajemen Transaksi Keuangan Hotel') }}
            </h2>
            <a href="{{ route('finance.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition duration-150 ease-in-out">
                {{-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>  --}}
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Filter Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Transaksi</h3>
                    <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="space-y-1">
                            <label for="type" class="text-sm font-medium text-gray-700">Jenis Transaksi</label>
                            <select name="type" id="type" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">Semua Jenis</option>
                                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label for="status" class="text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label for="start_date" class="text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                        </div>

                        <div class="space-y-1">
                            <label for="end_date" class="text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                onchange="this.form.submit()"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if($finance->count())
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                        onclick="window.location.href='{{ route('finance.index', array_merge(request()->query(), ['sort' => 'no', 'direction' => request('sort') === 'no' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                        No
                                        @if(request('sort') === 'no')
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                        onclick="window.location.href='{{ route('finance.index', array_merge(request()->query(), ['sort' => 'approval_status', 'direction' => request('sort') === 'approval_status' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                        Status
                                        @if(request('sort') === 'approval_status')
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                        onclick="window.location.href='{{ route('finance.index', array_merge(request()->query(), ['sort' => 'transaction_date', 'direction' => request('sort') === 'transaction_date' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                        Tanggal
                                        @if(request('sort') === 'transaction_date')
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                        onclick="window.location.href='{{ route('finance.index', array_merge(request()->query(), ['sort' => 'transaction_type', 'direction' => request('sort') === 'transaction_type' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                        Jenis
                                        @if(request('sort') === 'transaction_type')
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                        onclick="window.location.href='{{ route('finance.index', array_merge(request()->query(), ['sort' => 'category', 'direction' => request('sort') === 'category' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                        Kategori
                                        @if(request('sort') === 'category')
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                        onclick="window.location.href='{{ route('finance.index', array_merge(request()->query(), ['sort' => 'amount', 'direction' => request('sort') === 'amount' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                        Jumlah
                                        @if(request('sort') === 'amount')
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                        onclick="window.location.href='{{ route('finance.index', array_merge(request()->query(), ['sort' => 'payment_method', 'direction' => request('sort') === 'payment_method' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                        Metode
                                        @if(request('sort') === 'payment_method')
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($finance as $trx)
                                    @php
                                        $isToday = \Carbon\Carbon::parse($trx->transaction_date)->isToday();
                                    @endphp
                                    <tr class="{{ $isToday ? 'bg-yellow-50' : 'hover:bg-gray-50' }} transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($trx->approval_status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Disetujui
                                                </span>
                                            @elseif ($trx->approval_status === 'rejected')
                                                <div>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Ditolak
                                                    </span>
                                                    @if ($trx->rejection_note)
                                                        <p class="mt-1 text-xs text-gray-500 italic">"{{ $trx->rejection_note }}"</p>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Menunggu
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trx->transaction_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($trx->transaction_type === 'income')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Pemasukan
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Pengeluaran
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trx->category }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium">
                                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trx->payment_method }}</td>
                                       
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <x-dropdown-action
                                                :edit-url="route('finance.edit', $trx)"
                                                :delete-url="route('finance.destroy', $trx)" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $finance->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada transaksi</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan transaksi keuangan baru.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
