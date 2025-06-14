<x-app-layout x-cloak>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Manajemen Transaksi Keuangan Hotel  ') }}
            </h2>
            {{-- <a href="{{ route('hotel.finance.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                {{-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> --}}
                Tambah Data
            </a> --}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    <div class="min-w-full">
                        {{-- SEARCH BAR --}}
                        <form action="{{ route('hotel.finance.index') }}" method="GET" class="mb-6">
                            <label for="search" class="sr-only">Cari:</label>
                            <input type="text" name="search" id="search"
                                value="{{ request('search') }}" placeholder="Cari deskripsi, kategori, atau metode pembayaran..."
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2">
                        </form>

                        {{-- FILTER DROPDOWN & BULK ACTION --}}
                        <div class="flex justify-between items-center mb-6 no-animation">
                            <div class="relative inline-block text-left no-animation" x-data="{ open: false }" @click.outside="open = false">
                                <div class="no-animation">
                                    <button type="button" @click="open = !open"
                                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 no-animation"
                                        id="options-menu" aria-haspopup="true" aria-expanded="true">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Filter Data
                                    </button>
                                </div>

                                <div x-show="open"
                                    class="origin-top-left absolute left-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 no-animation"
                                    style="display: none;">
                                    <div class="py-1" role="menu" aria-orientation="vertical"
                                        aria-labelledby="options-menu">
                                        <form action="{{ route('hotel.finance.index') }}" method="GET"
                                            class="p-4 space-y-4">
                                            @if (request('search'))
                                                <input type="hidden" name="search" value="{{ request('search') }}">
                                            @endif
                                            <div class="space-y-1">
                                                <label for="type"
                                                    class="block text-sm font-medium text-gray-700">Jenis:</label>
                                                <select name="type" id="type"
                                                    class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                    <option value="">Semua</option>
                                                    <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>
                                                        Pemasukan</option>
                                                    <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>
                                                        Pengeluaran</option>
                                                </select>
                                            </div>

                                            <div class="space-y-1">
                                                <label for="status"
                                                    class="block text-sm font-medium text-gray-700">Status:</label>
                                                <select name="status" id="status"
                                                    class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                    <option value="">Semua</option>
                                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                                        Disetujui</option>
                                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                                        Ditolak</option>
                                                </select>
                                            </div>

                                            <div class="space-y-1">
                                                <label for="start_date"
                                                    class="block text-sm font-medium text-gray-700">Dari Tanggal:</label>
                                                <input type="date" name="start_date" id="start_date"
                                                    value="{{ request('start_date') }}"
                                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                            </div>

                                            <div class="space-y-1">
                                                <label for="end_date"
                                                    class="block text-sm font-medium text-gray-700">Sampai Tanggal:</label>
                                                <input type="date" name="end_date" id="end_date"
                                                    value="{{ request('end_date') }}"
                                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                            </div>

                                            <div class="flex justify-end space-x-2 mt-4">
                                                <button type="button"
                                                    @click="open = false; window.location.href = '{{ route('hotel.finance.index', array_merge(request()->query(), ['sort' => request('sort'), 'direction' => request('direction')])) }}'"
                                                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                                    Reset
                                                </button>
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                                    Terapkan Filter
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Bulk Actions -->
                            <div x-data="{ showModal: false }" class="flex gap-3 items-center min-w-fit no-animation">
                                <form id="bulkActionForm" method="POST" action="{{ route('hotel.finance.bulk-action') }}"
                                    class="no-animation">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 no-animation">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Approve Terpilih
                                    </button>
                                </form>
                                <button type="button" @click="showModal = true"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 no-animation">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak Terpilih
                                </button>

                                <!-- Bulk Reject Modal -->
                                <div x-show="showModal" x-cloak
                                    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                                    <div @click.away="showModal = false"
                                        class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                                        <h2 class="text-xl font-bold text-gray-900 mb-4">Tolak Transaksi Terpilih</h2>
                                        <form id="bulkRejectForm" method="POST"
                                            action="{{ route('hotel.finance.bulk-reject') }}">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="bulk_rejection_note"
                                                    class="block text-sm font-medium text-gray-700 mb-2">
                                                    Alasan Penolakan:
                                                </label>
                                                <textarea name="rejection_note" id="bulk_rejection_note" rows="4" required
                                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none"
                                                    placeholder="Masukkan alasan penolakan..."></textarea>
                                            </div>
                                            <div class="flex justify-end gap-3">
                                                <button type="button" @click="showModal = false"
                                                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                                    Batal
                                                </button>
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                                    Konfirmasi Tolak
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table Section -->
                        @if($finance->count())
                            <div class="overflow-x-auto border rounded-xl">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-center">
                                                <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            </th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                No</th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.finance.index', array_merge(request()->query(), ['sort' => 'status', 'direction' => request('sort') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                                Status
                                                @if (request('sort') == 'status')
                                                    <span class="ml-1">
                                                        @if (request('direction') == 'asc')
                                                            &uarr;
                                                        @else
                                                            &darr;
                                                        @endif
                                                    </span>
                                                @endif
                                            </th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.finance.index', array_merge(request()->query(), ['sort' => 'date', 'direction' => request('sort') == 'date' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                                Tanggal
                                                @if (request('sort') == 'date')
                                                    <span class="ml-1">
                                                        @if (request('direction') == 'asc')
                                                            &uarr;
                                                        @else
                                                            &darr;
                                                        @endif
                                                    </span>
                                                @endif
                                            </th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.finance.index', array_merge(request()->query(), ['sort' => 'type', 'direction' => request('sort') == 'type' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                                Jenis
                                                @if (request('sort') == 'type')
                                                    <span class="ml-1">
                                                        @if (request('direction') == 'asc')
                                                            &uarr;
                                                        @else
                                                            &darr;
                                                        @endif
                                                    </span>
                                                @endif
                                            </th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.finance.index', array_merge(request()->query(), ['sort' => 'category', 'direction' => request('sort') == 'category' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                                Kategori
                                                @if (request('sort') == 'category')
                                                    <span class="ml-1">
                                                        @if (request('direction') == 'asc')
                                                            &uarr;
                                                        @else
                                                            &darr;
                                                        @endif
                                                    </span>
                                                @endif
                                            </th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.finance.index', array_merge(request()->query(), ['sort' => 'subcategory', 'direction' => request('sort') == 'subcategory' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                                Sub Kategori
                                                @if (request('sort') == 'subcategory')
                                                    <span class="ml-1">
                                                        @if (request('direction') == 'asc')
                                                            &uarr;
                                                        @else
                                                            &darr;
                                                        @endif
                                                    </span>
                                                @endif
                                            </th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center cursor-pointer"
                                                onclick="window.location.href = '{{ route('hotel.finance.index', array_merge(request()->query(), ['sort' => 'amount', 'direction' => request('sort') == 'amount' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                                Jumlah
                                                @if (request('sort') == 'amount')
                                                    <span class="ml-1">
                                                        @if (request('direction') == 'asc')
                                                            &uarr;
                                                        @else
                                                            &darr;
                                                        @endif
                                                    </span>
                                                @endif
                                            </th>
                                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($finance as $trx)
                                            @php
                                                $isToday = \Carbon\Carbon::parse($trx->transaction_date)->isToday();
                                            @endphp
                                            <tr
                                                class="{{ $isToday ? 'bg-yellow-50' : 'hover:bg-gray-50' }} transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($trx->approval_status === 'pending')
                                                        <input type="checkbox" name="selected_transactions[]" value="{{ $trx->id }}"
                                                            class="transaction-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">{{ $loop->iteration }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if($trx->approval_status === 'approved')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Disetujui
                                                        </span>
                                                    @elseif($trx->approval_status === 'rejected')
                                                        <div class="space-y-1">
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                Ditolak
                                                            </span>
                                                            @if($trx->rejection_note)
                                                                <div class="text-xs text-gray-500 italic">
                                                                    "{{ $trx->rejection_note }}"</div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Menunggu
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $trx->transaction_date }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if($trx->transaction_type === 'income')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Pemasukan
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Pengeluaran
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $trx->category }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $trx->subcategory }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                    <x-dropdown-action 
                                                        :editUrl="route('hotel.finance.edit', $trx)"
                                                        :deleteUrl="route('hotel.finance.destroy', $trx)"/>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6">
                                {{ $finance->links() }}
                            </div>
                        @else
                            <div class="text-center py-8">
                                <span class="text-gray-500 text-sm">Belum ada transaksi keuangan.</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Select all checkboxes
        document.getElementById('selectAll').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.transaction-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            console.log('Select All Checkbox Changed. All checkboxes checked:', this.checked);
        });

        // Add selected IDs to forms before submit
        document.getElementById('bulkActionForm').addEventListener('submit', function (e) {
            console.log('Bulk Approve Form Submission Initiated.');
            const selectedIds = document.querySelectorAll('.transaction-checkbox:checked');
            console.log('Selected IDs for Approve:', selectedIds);

            if (selectedIds.length === 0) {
                e.preventDefault();
                alert('Pilih setidaknya satu transaksi untuk persetujuan.');
                console.log('No transactions selected for approval.');
                return;
            }

            // Clear any existing hidden inputs
            this.querySelectorAll('input[name="selected_transactions[]"]').forEach(input => input.remove());
            console.log('Cleared existing hidden inputs for approval.');

            // Add new hidden inputs for selected IDs
            selectedIds.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_transactions[]';
                input.value = checkbox.value;
                this.appendChild(input);
                console.log('Added hidden input for ID:', checkbox.value);
            });
            console.log('Bulk Approve Form ready for submission.');
        });

        document.getElementById('bulkRejectForm').addEventListener('submit', function (e) {
            console.log('Bulk Reject Form Submission Initiated.');
            const selectedIds = document.querySelectorAll('.transaction-checkbox:checked');
            console.log('Selected IDs for Reject:', selectedIds);

            if (selectedIds.length === 0) {
                e.preventDefault();
                alert('Pilih setidaknya satu transaksi untuk penolakan.');
                console.log('No transactions selected for rejection.');
                return;
            }

            // Clear any existing hidden inputs
            this.querySelectorAll('input[name="selected_transactions[]"]').forEach(input => input.remove());
            console.log('Cleared existing hidden inputs for rejection.');

            // Add new hidden inputs for selected IDs
            selectedIds.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_transactions[]';
                input.value = checkbox.value;
                this.appendChild(input);
                console.log('Added hidden input for ID:', checkbox.value);
            });

            // Add rejection note to the form
            const rejectionNoteInput = document.createElement('input');
            rejectionNoteInput.type = 'hidden';
            rejectionNoteInput.name = 'rejection_note';
            rejectionNoteInput.value = document.getElementById('bulk_rejection_note').value;
            this.appendChild(rejectionNoteInput);
            console.log('Added rejection note. Bulk Reject Form ready for submission.');
        });
    </script>
</x-app-layout>