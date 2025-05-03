<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Daftar Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-visible shadow-sm sm:rounded-lg relative">
                <div class="p-6 text-gray-900">

                    <!-- Search & Tambah -->
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-3">
                        <form method="GET" action="{{ route('resto.shared_customers.index_resto') }}" class="w-full md:w-1/2">
                            <div class="flex items-center gap-2">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama pelanggan..."
                                    class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-indigo-300">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Cari
                                </button>
                            </div>
                        </form>

                        <a href="{{ route('resto.shared_customers.create_resto') }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-center">
                            Tambah Pelanggan
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto relative z-0">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Nama</th>
                                    <th class="px-4 py-2 text-left">Email</th>
                                    <th class="px-4 py-2 text-left">No. Telepon</th>
                                    <th class="px-4 py-2 text-left">Jenis Kelamin</th>
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($customers as $c)
                                    <tr>
                                        <td class="px-4 py-2">{{ $c->name }}</td>
                                        <td class="px-4 py-2">{{ $c->email ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $c->phone ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            {{ $c->gender === 'L' ? 'Laki-laki' : ($c->gender === 'P' ? 'Perempuan' : '-') }}
                                        </td>
                                        <td class="px-4 py-2 relative overflow-visible z-10">
                                            <x-dropdown-action 
                                                :editUrl="route('resto.shared_customers.edit_resto', $c->id)"
                                                 />
                                        </td>
                                        {{-- :deleteUrl="route('resto.shared_customers.destroy_resto', $c->id)" --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada pelanggan ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
