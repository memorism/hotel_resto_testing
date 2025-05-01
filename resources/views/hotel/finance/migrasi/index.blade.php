<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">
                Histori Data Migrasi Keuangan
            </h2>
            <a href="{{ route('finance.migrasi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($uploads->count())
                    <table class="w-full table-auto text-sm text-left border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">Nama File</th>
                                <th class="border px-4 py-2">Deskripsi</th>
                                <th class="border px-4 py-2">Diupload Oleh</th>
                                <th class="border px-4 py-2">Tanggal</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($uploads as $upload)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $upload->file_name }}</td>
                                    <td class="border px-4 py-2">{{ $upload->description ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $upload->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $upload->created_at->format('d M Y, H:i') }}</td>
                                    <td class="border px-4 py-2">
                                        <form action="{{ route('finance.migrasi.destroy', $upload->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus histori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600">Belum ada data migrasi keuangan yang diupload.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
