<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Manajemen Barang</h2>
            <a href="{{ route('scm.supplies.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Tambah Barang
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="bg-white p-4 rounded shadow max-w-7xl mx-auto">
            @if($supplies->count())
                <table class="min-w-full table-auto text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Nama Barang</th>
                            <th class="px-4 py-2 border">kategori</th>
                            <th class="px-4 py-2 border">jumlah</th>
                            <th class="px-4 py-2 border">Satuan</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supplies as $supply)
                            <tr>
                                <td class="px-4 py-2 border">{{ $supply->name }}</td>
                                <td class="px-4 py-2 border">{{ $supply->category }}</td>
                                <td class="px-4 py-2 border">{{ $supply->quantity }}</td>
                                <td class="px-4 py-2 border">{{ $supply->unit }}</td>
                                <td class="px-4 py-2 border text-center relative">
                                    <x-dropdown-action :edit-url="route('scm.supplies.edit', $supply)"
                                        :delete-url="route('scm.supplies.destroy', $supply)" />
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $supplies->links() }}</div>
            @else
                <p class="text-gray-500">Belum ada data barang.</p>
            @endif
        </div>
    </div>
</x-app-layout>