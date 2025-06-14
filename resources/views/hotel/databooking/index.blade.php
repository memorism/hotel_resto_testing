<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark mb-0">
                {{ __('Data Hotel') }}
            </h2>
            <div>
                <a href="{{ route('hotel.databooking.create') }}" class="btn btn-primary  px-4">
                    Tambah Data
                </a>

            </div>
        </div>
        
        
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <div class="mb-4 flex justify-between">
                        <div class="flex justify-between items-center mb-4">
                            <label for="per_page" class="mr-2">Tampilkan</label>
                            <select name="per_page" id="per_page" class="form-select form-select-sm"
                                onchange="updatePerPage(this.value)">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            </select>

                            <script>
                                function updatePerPage(value) {
                                    let params = new URLSearchParams(window.location.search);
                                    params.set('per_page', value);  // Tambahkan atau update per_page
                                    window.location.search = params.toString();
                                }
                            </script>
                            <label for="per_page" class="ml-2">data</label>
                        </div>
                        <div class="flex items-center">
                            <form action="{{ route('hotel.booking.index') }}" method="GET" class="flex">
                                <input type="text" name="search" id="search" class="form-input form-input-sm"
                                    placeholder="Nama File" value="{{ request('search') }}">
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                <button type="submit" class="btn btn-primary btn-sm ml-2">Cari</button>
                            </form>
                        </div>

                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-black-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="text-center px-4 py-2">No</th>
                                    <th class="text-center px-4 py-2">Nama File</th>
                                    <th class="text-center px-4 py-2">Deskripsi</th>
                                    <th class="text-center px-4 py-2">Tanggal Upload</th>
                                    <th class="text-center px-4 py-2" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($uploadOrders as $uploadOrder)
                                    <tr>
                                        <td class="text-center px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="text-center px-4 py-2">{{ $uploadOrder->file_name }}</td>
                                        <td class="text-center px-4 py-2">{{ $uploadOrder->description }}</td>
                                        <td class="text-center px-4 py-2">
                                            {{ $uploadOrder->created_at->format('H:i:s | d M Y ') }}
                                        </td>
                                        <td class="text-center px-4 py-2">
                                            <div class="flex justify-center gap-2">
                                                <!-- Tombol View -->
                                                {{-- {{ route('hotel.databooking.show', $uploadOrder->id) }} --}}
                                                <a href="{{ route('hotel.databooking.viewUploadOrder', $uploadOrder->id) }}"
                                                    class="px-3 py-1 bg-blue-500 text-white text-sm font-semibold rounded-md hover:bg-blue-600 text-decoration-none">
                                                    Lihat
                                                </a>
                                                                                              

                                                <!-- Tombol Update -->
                                                <a href="{{ route('hotel.databooking.edit', $uploadOrder->id) }}"
                                                    class="px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-md hover:bg-yellow-600 text-decoration-none">
                                                    Edit
                                                </a>

                                                <!-- Tombol Delete -->
                                                <form method="POST"
                                                    action="{{ route('hotel.databooking.destroy', $uploadOrder->id) }}"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $uploadOrders->appends(['search' => request('search'), 'per_page' => request('per_page', 10)])->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>