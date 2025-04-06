<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Upload File') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('resto.dataorders.create') }}" class="btn btn-primary">Unggah File</a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 text-gray-800">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 text-sm">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">No</th>
                                    <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Nama File</th>
                                    <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Tanggal Upload</th>
                                    <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($uploads as $upload)
                                    <tr>
                                        <td class="text-center px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="text-center px-4 py-2">{{ $upload->file_name }}</td>
                                        <td class="text-center px-4 py-2">{{ $upload->description }}</td>
                                        <td class="text-center px-4 py-2">{{ $upload->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td class="text-center px-4 py-2 space-x-1">
                                            <a href="{{ route('resto.dataorders.show', $upload->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded font-semibold">Lihat</a>
                                            <a href="{{ route('resto.dataorders.edit', $upload->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded font-semibold">Edit</a>
                                            <form action="{{ route('resto.dataorders.destroy', $upload->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus file ini?');" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center px-4 py-4 text-gray-500 font-medium">Belum ada file yang diunggah.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>