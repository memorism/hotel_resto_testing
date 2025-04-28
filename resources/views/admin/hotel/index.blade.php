<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
                {{ __('Hotel') }}
            </h2>
            <a href="{{ route('admin.hotel.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                Tambah Hotel
            </a>
        </div>
    </x-slot>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md">
            {{ session('success') }}
        </div>
    @endif



    {{-- Content --}}
    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="overflow-x-auto border-b border-gray-200 bg-white p-6">
                    {{-- Search dan Filter --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                        <form action="{{ route('admin.hotel.index') }}" method="GET"
                            class="flex flex-col sm:flex-row gap-2">
                            <input type="text" name="search" placeholder="Cari nama hotel..."
                                value="{{ request('search') }}"
                                class="rounded-md border-gray-300 focus:ring focus:ring-indigo-200 text-sm px-3 py-2 w-48">

                            <select name="city"
                                class="rounded-md border-gray-300 focus:ring focus:ring-indigo-200 text-sm px-3 py-2 w-48">
                                <option value="">-- Filter Kota --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm">
                                Cari
                            </button>
                            <a href="{{ route('admin.hotel.index') }}"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition text-sm">
                                Reset
                            </a>
                        </form>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-center">No</th>
                                <th class="px-4 py-2 text-center">Logo</th>
                                <th class="px-4 py-2">Nama Hotel</th>
                                <th class="px-4 py-2">Alamat Lengkap</th>
                                <th class="px-4 py-2">Telepon</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2 text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($hotels as $hotel)
                                                    <tr class="hover:bg-gray-50 transition">
                                                        <td class="text-center px-4 py-2">{{ $loop->iteration }}</td>
                                                        <td class="text-center px-4 py-2">
                                                            @if($hotel->logo)
                                                                <img src="{{ asset('storage/' . $hotel->logo) }}" width="50" alt="Hotel Logo"
                                                                    class="mx-auto">
                                                            @else
                                                                <span class="text-gray-400">Tidak ada logo</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-2">{{ $hotel->name }}</td>
                                                        <td class="px-4 py-2">
                                                            {{
                                implode(', ', array_filter([
                                    $hotel->street,
                                    $hotel->village,
                                    $hotel->district,
                                    $hotel->city,
                                    $hotel->province,
                                    $hotel->postal_code
                                ]))
                                                                }}
                                                        </td>
                                                        <td class="px-4 py-2">{{ $hotel->phone }}</td>
                                                        <td class="px-4 py-2">{{ $hotel->email }}</td>
                                                        <td class="text-center px-4 py-2 flex justify-center space-x-2">
                                                            <a href="{{ route('admin.hotel.edit', $hotel->id) }}"
                                                                class="px-4 py-2 bg-yellow-500 text-white font-semibold rounded-md hover:bg-yellow-600">
                                                                Edit
                                                            </a>
                                                            <form method="POST" action="{{ route('admin.hotel.destroy', $hotel->id) }}"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus hotel ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600">
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada hotel.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $hotels->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>