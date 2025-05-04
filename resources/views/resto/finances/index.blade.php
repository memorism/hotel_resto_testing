<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Data Keuangan Resto
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <form method="GET" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keterangan..."
                               class="border-gray-300 rounded px-3 py-2 text-sm w-64 shadow-sm">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded">
                            Cari
                        </button>
                    </form>

                    <a href="{{ route('resto.finances.create') }}"
                       class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded">
                        Tambah Transaksi
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Jenis</th>
                                <th class="px-4 py-2 text-left">Keterangan</th>
                                <th class="px-4 py-2 text-right">Nominal</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($finances as $f)
                                <tr>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($f->tanggal)->format('d M Y') }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($f->jenis) }}</td>
                                    <td class="px-4 py-2">{{ $f->keterangan ?? '-' }}</td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($f->nominal, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <x-dropdown-action
                                            :editUrl="route('resto.finances.edit', $f->id)"
                                            :deleteUrl="route('resto.finances.destroy', $f->id)"
                                        />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center px-4 py-6 text-gray-500">
                                        Tidak ada data keuangan ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $finances->appends(request()->all())->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
