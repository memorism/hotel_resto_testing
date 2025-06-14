<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
                    {{ __('Daftar Pelanggan') }}
                </h2>
                <a href="{{ route('shared_customers.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700">
                    Tambah Pelanggan
                </a>
            </div>

            {{-- SEARCH BAR --}}
            <form action="{{ route('shared_customers.index') }}" method="GET" class="mb-6">
                <label for="search" class="sr-only">Cari:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Cari nama, nomor telepon, atau email..."
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2">
            </form>

            {{-- FILTER DROPDOWN --}}
            <div class="flex justify-between items-center mb-6">
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        id="options-menu" aria-haspopup="true" aria-expanded="true">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd" />
                        </svg>
                        Filter Data
                    </button>

                    <div x-show="open"
                        class="origin-top-left absolute left-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                        style="display: none;">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                            <form action="{{ route('shared_customers.index') }}" method="GET" class="p-4 space-y-4">
                                @if (request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <div class="space-y-1">
                                    <label for="gender" class="block text-sm font-medium text-gray-700">Jenis
                                        Kelamin:</label>
                                    <select name="gender" id="gender"
                                        class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="">Semua</option>
                                        <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                </div>

                                <div class="space-y-1">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal
                                        Pendaftaran:</label>
                                    <input type="date" name="start_date" id="start_date"
                                        value="{{ request('start_date') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>

                                <div class="space-y-1">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal
                                        Pendaftaran:</label>
                                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>

                                <div class="flex justify-end space-x-2 mt-4">
                                    <button type="button"
                                        @click="open = false; window.location.href = '{{ route('shared_customers.index') }}'"
                                        class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                        Reset
                                    </button>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                        Terapkan Filter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    No</th>
                                <th scope="col" class="px-6 py-3 cursor-pointer"
                                    onclick="window.location.href = '{{ route('shared_customers.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    Nama
                                    @if (request('sort') == 'name')
                                        <span class="ml-1">
                                            @if (request('direction') == 'asc')
                                                &uarr;
                                            @else
                                                &darr;
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 cursor-pointer"
                                    onclick="window.location.href = '{{ route('shared_customers.index', array_merge(request()->query(), ['sort' => 'phone', 'direction' => request('sort') == 'phone' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    No. Telepon
                                    @if (request('sort') == 'phone')
                                        <span class="ml-1">
                                            @if (request('direction') == 'asc')
                                                &uarr;
                                            @else
                                                &darr;
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 cursor-pointer"
                                    onclick="window.location.href = '{{ route('shared_customers.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => request('sort') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    Email
                                    @if (request('sort') == 'email')
                                        <span class="ml-1">
                                            @if (request('direction') == 'asc')
                                                &uarr;
                                            @else
                                                &darr;
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 cursor-pointer"
                                    onclick="window.location.href = '{{ route('shared_customers.index', array_merge(request()->query(), ['sort' => 'gender', 'direction' => request('sort') == 'gender' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    Jenis Kelamin
                                    @if (request('sort') == 'gender')
                                        <span class="ml-1">
                                            @if (request('direction') == 'asc')
                                                &uarr;
                                            @else
                                                &darr;
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 cursor-pointer"
                                    onclick="window.location.href = '{{ route('shared_customers.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
                                    Tanggal Dibuat
                                    @if (request('sort') == 'created_at')
                                        <span class="ml-1">
                                            @if (request('direction') == 'asc')
                                                &uarr;
                                            @else
                                                &darr;
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $index => $customer)
                                <tr class="border-b">
                                    <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">{{ $customer->name }}</td>
                                    <td class="px-6 py-4">{{ $customer->phone ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $customer->email ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        {{ $customer->gender === 'L' ? 'Laki-laki' : ($customer->gender === 'P' ? 'Perempuan' : '-') }}
                                    </td>
                                    <td class="px-6 py-4">{{ $customer->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <x-dropdown-action :viewUrl="route('shared_customers.show', $customer->id)"
                                            :editUrl="route('shared_customers.edit', $customer->id)"
                                            :deleteUrl="route('shared_customers.destroy', $customer->id)" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data pelanggan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>