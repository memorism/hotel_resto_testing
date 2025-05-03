<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Data Semua Pelanggan') }}
            </h2>
            <a href="{{ route('admin.shared_customers.create') }}" class="btn btn-primary">
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <!-- Filter Section -->
                <form method="GET" class="flex flex-wrap items-center gap-4 mb-4">
                    {{-- Search --}}
                    <div class="flex flex-col">
                        <label for="search" class="text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Cari nama/email/telepon..."
                               class="border-gray-300 rounded shadow-sm px-3 py-2 w-64 focus:ring-indigo-500">
                    </div>
                
                    {{-- Source --}}
                    <div class="flex flex-col">
                        <label for="source" class="text-sm font-medium text-gray-700 mb-1">Sumber</label>
                        <select name="source" id="source"
                                class="border-gray-300 rounded px-3 py-2 shadow-sm w-48 focus:ring-indigo-500">
                            <option value="">Semua Sumber</option>
                            <option value="hotel" {{ request('source') == 'hotel' ? 'selected' : '' }}>Hotel</option>
                            <option value="resto" {{ request('source') == 'resto' ? 'selected' : '' }}>Resto</option>
                        </select>
                    </div>
                
                    {{-- With Deleted --}}
                    <div class="flex items-center mt-6">
                        <input type="checkbox" name="with_deleted" id="with_deleted" value="1"
                               {{ request('with_deleted') ? 'checked' : '' }}
                               class="text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 mr-2">
                        <label for="with_deleted" class="text-sm text-gray-700">Tampilkan yang terhapus</label>
                    </div>
                
                    {{-- Button --}}
                    <div class="mt-6">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow-sm">
                            Filter
                        </button>
                    </div>
                </form>
                

        
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                        <thead class="bg-gray-50">
                            <tr >
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-left">Email</th>
                                <th class="px-4 py-2 text-left">No. Telepon</th>
                                <th class="px-4 py-2 text-left">Jenis Kelamin</th>
                                <th class="px-4 py-2 text-left">Alamat</th>
                                <th ></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($customers as $c)
                                <tr>
                                    <td class="px-4 py-2">{{ $c->name }}</td>
                                    <td class="px-4 py-2">{{ $c->email ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $c->phone ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $c->address ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        {{ $c->gender === 'L' ? 'Laki-laki' : ($c->gender === 'P' ? 'Perempuan' : '-') }}
                                    </td>
                                    <td class="relative">
                                        <x-dropdown-action 
                                            :editUrl="!$c->trashed() ? route('admin.shared_customers.edit', $c->id) : null"
                                            :deleteUrl="!$c->trashed() ? route('admin.shared_customers.destroy', $c->id) : null"
                                            :restoreUrl="$c->trashed() ? route('admin.shared_customers.restore', $c->id) : null" 
                                            :isRestore="$c->trashed()"/>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada data ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $customers->appends(request()->all())->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
