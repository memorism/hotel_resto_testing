<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Laporan Gabungan Hotel & Resto') }}
            </h2>
            <a class="invisible btn btn-primary">test</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <!-- Filter Section -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <!-- Search Bars -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full max-w-2xl">
                            <form method="GET" action="{{ route('combined-reports.index') }}">
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="combined_search" placeholder="Cari nama hotel/resto..."
                                        value="{{ request('combined_search') }}"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                </div>
                            </form>
                        </div>

                        <!-- Filter Dropdown -->
                        <div class="relative ml-4" x-data="{ open: false }" x-cloak>
                            <button @click="open = !open" type="button"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <form method="GET" action="{{ route('combined-reports.index') }}" class="p-4 space-y-4">
                                    <!-- Date Filter -->
                                    <div>
                                        <label for="tanggal"
                                            class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                        <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                                    </div>

                                    <!-- Items Per Page -->
                                    <div>
                                        <label for="per_page"
                                            class="block text-sm font-medium text-gray-700 mb-1">Jumlah Data</label>
                                        <select name="per_page" id="per_page"
                                            class="block w-full rounded-lg p-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Data
                                            </option>
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data
                                            </option>
                                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data
                                            </option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data
                                            </option>
                                            <option value="semua" {{ request('per_page') == 'semua' ? 'selected' : '' }}>
                                                Semua Data</option>
                                        </select>
                                    </div>

                                    <!-- Show Zero Income Toggle -->
                                    <div class="flex items-center">
                                        <input type="checkbox" name="show_zero_income" id="show_zero_income" value="1"
                                            {{ request('show_zero_income') ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <label for="show_zero_income" class="ml-2 text-sm text-gray-600">Tampilkan
                                            laporan tanpa pendapatan</label>
                                    </div>

                                    <!-- Filter Button -->
                                    <div class="pt-2">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Terapkan Filter
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="p-6">
                    @if($reports->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                            onclick="window.location.href='{{ route('combined-reports.index', array_merge(request()->query(), ['sort' => 'tanggal', 'direction' => request('sort') === 'tanggal' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                            Tanggal
                                            @if(request('sort') === 'tanggal')
                                                <span class="ml-1">
                                                    @if(request('direction') === 'asc')
                                                        ↑
                                                    @else
                                                        ↓
                                                    @endif
                                                </span>
                                            @endif
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                            onclick="window.location.href='{{ route('combined-reports.index', array_merge(request()->query(), ['sort' => 'hotel_id', 'direction' => request('sort') === 'hotel_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                            Hotel
                                            @if(request('sort') === 'hotel_id')
                                                <span class="ml-1">
                                                    @if(request('direction') === 'asc')
                                                        ↑
                                                    @else
                                                        ↓
                                                    @endif
                                                </span>
                                            @endif
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                            onclick="window.location.href='{{ route('combined-reports.index', array_merge(request()->query(), ['sort' => 'resto_id', 'direction' => request('sort') === 'resto_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                            Resto
                                            @if(request('sort') === 'resto_id')
                                                <span class="ml-1">
                                                    @if(request('direction') === 'asc')
                                                        ↑
                                                    @else
                                                        ↓
                                                    @endif
                                                </span>
                                            @endif
                                        </th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Booking</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tamu</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Okupansi</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Utilisasi Meja</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                            onclick="window.location.href='{{ route('combined-reports.index', array_merge(request()->query(), ['sort' => 'total_income', 'direction' => request('sort') === 'total_income' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                            Total Income
                                            @if(request('sort') === 'total_income')
                                                <span class="ml-1">
                                                    @if(request('direction') === 'asc')
                                                        ↑
                                                    @else
                                                        ↓
                                                    @endif
                                                </span>
                                            @endif
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                            onclick="window.location.href='{{ route('combined-reports.index', array_merge(request()->query(), ['sort' => 'total_expense', 'direction' => request('sort') === 'total_expense' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                            Total Expense
                                            @if(request('sort') === 'total_expense')
                                                <span class="ml-1">
                                                    @if(request('direction') === 'asc')
                                                        ↑
                                                    @else
                                                        ↓
                                                    @endif
                                                </span>
                                            @endif
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                            onclick="window.location.href='{{ route('combined-reports.index', array_merge(request()->query(), ['sort' => 'net_profit', 'direction' => request('sort') === 'net_profit' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                            Profit
                                            @if(request('sort') === 'net_profit')
                                                <span class="ml-1">
                                                    @if(request('direction') === 'asc')
                                                        ↑
                                                    @else
                                                        ↓
                                                    @endif
                                                </span>
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reports as $report)
                                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                    {{ $report->tanggal->format('d M Y') }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                    {{ $report->hotel->name ?? '-' }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                    {{ $report->resto->name ?? '-' }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                                    {{ $report->total_booking }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                                    {{ $report->total_tamu }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                                    <span
                                                                        class="px-2 py-1 text-xs font-medium rounded-full 
                                                                                                                                                                                                {{ $report->total_okupansi >= 70 ? 'bg-green-100 text-green-800' :
                                        ($report->total_okupansi >= 40 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                                        {{ $report->total_okupansi }}%
                                                                    </span>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                                    <span
                                                                        class="px-2 py-1 text-xs font-medium rounded-full 
                                                                                                                                                                                                {{ ($report->table_utilization_rate ?? 0) >= 70 ? 'bg-green-100 text-green-800' :
                                        (($report->table_utilization_rate ?? 0) >= 40 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                                        {{ $report->table_utilization_rate ?? '-' }}%
                                                                    </span>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                                                    Rp{{ number_format($report->total_income, 0, ',', '.') }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                                                    Rp{{ number_format($report->total_expense, 0, ',', '.') }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                                    <span
                                                                        class="text-sm font-medium {{ $report->net_profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                                        Rp{{ number_format($report->net_profit, 0, ',', '.') }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $reports->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
                            <p class="mt-1 text-sm text-gray-500">Tidak ada data laporan yang ditemukan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>