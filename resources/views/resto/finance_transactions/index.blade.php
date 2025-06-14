<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Keuangan Resto') }}
            </h2>
            <a href="{{ route('financeresto.finances.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search and Filter -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form method="GET" class="flex gap-4 items-end">
                            <div class="flex-1">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Transaksi</label>
                                <div class="relative">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        placeholder="Cari berdasarkan keterangan..."
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-10">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=status&direction={{ request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc' }}" class="flex items-center">
                                            Status
                                            @if(request('sort') === 'status')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=tanggal&direction={{ request('sort') === 'tanggal' && request('direction') === 'asc' ? 'desc' : 'asc' }}" class="flex items-center">
                                            Tanggal
                                            @if(request('sort') === 'tanggal')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=jenis&direction={{ request('sort') === 'jenis' && request('direction') === 'asc' ? 'desc' : 'asc' }}" class="flex items-center">
                                            Jenis
                                            @if(request('sort') === 'jenis')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <a href="?sort=keterangan&direction={{ request('sort') === 'keterangan' && request('direction') === 'asc' ? 'desc' : 'asc' }}" class="flex items-center">
                                            Keterangan
                                            @if(request('sort') === 'keterangan')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        <a href="?sort=nominal&direction={{ request('sort') === 'nominal' && request('direction') === 'asc' ? 'desc' : 'asc' }}" class="flex items-center justify-end">
                                            Nominal
                                            @if(request('sort') === 'nominal')
                                                <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($finances as $f)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">
                                            @if ($f->approval_status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Disetujui
                                                </span>
                                            @elseif ($f->approval_status === 'rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Ditolak
                                                </span>
                                                @if ($f->rejection_note)
                                                    <div class="text-xs text-red-500 mt-1">
                                                        {{ $f->rejection_note }}
                                                    </div>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Menunggu
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($f->tanggal)->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            @if($f->jenis === 'pemasukan')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Pemasukan
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Pengeluaran
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $f->keterangan ?? '-' }}</td>
                                        <td class="px-6 py-4 text-right font-medium {{ $f->jenis === 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                            Rp {{ number_format($f->nominal, 0, ',', '.') }}
                                        </td>
                                       
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center space-x-3">
                                                <a href="{{ route('financeresto.finances.edit', $f->id) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('financeresto.finances.destroy', $f->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data keuangan ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $finances->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>