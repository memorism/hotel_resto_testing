<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Upload History') }}
            </h2>
            <div>
                <a href="{{ route('resto.dataorders.create') }}" class="btn btn-primary">Upload File</a>
                <a href="{{ asset('storage/resto_orders_template.xlsx') }}" class="btn btn-info px-4" download>Download Template Excel</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full border divide-y divide-gray-200 table-auto">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="text-center px-4 py-2">No</th>
                                <th class="text-center px-4 py-2">File Name</th>
                                <th class="text-center px-4 py-2">Description</th>
                                <th class="text-center px-4 py-2">Uploaded At</th>
                                <th class="text-center px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uploads as $upload)
                                <tr>
                                    <td class="text-center px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="text-center px-4 py-2">{{ $upload->file_name }}</td>
                                    <td class="text-center px-4 py-2">{{ $upload->description }}</td>
                                    <td class="text-center px-4 py-2">{{ $upload->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="text-center px-4 py-2">
                                        <a href="{{ route('resto.dataorders.show', $upload->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('resto.dataorders.edit', $upload->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('resto.dataorders.destroy', $upload->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus file ini?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
