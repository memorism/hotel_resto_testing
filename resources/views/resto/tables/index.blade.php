<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Daftar Meja Restoran</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <!-- Tombol Tambah -->
                <div class="flex justify-between items-center mb-4">
            
                    <a href="{{route('resto.tables.create') }}" class="bg-green-600 hover:bg-green-700">
                        Tambah Meja
                    </a>

                    <!-- Optional: Search Bar -->
                    <x-form.input name="search" placeholder="Cari kode meja..." class="w-1/3" />
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Kode Meja</th>
                                <th class="px-4 py-2 text-left">Kapasitas</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($tables as $table)
                                <tr>
                                    <td class="px-4 py-2">{{ $table->table_code }}</td>
                                    <td class="px-4 py-2">{{ $table->capacity }} orang</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            {{ $table->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $table->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 relative">
                                        <x-dropdown-action 
                                            :editUrl="route('resto.tables.edit', $table->id)"
                                            :deleteUrl="route('resto.tables.destroy', $table->id)" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada data meja.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $tables->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
