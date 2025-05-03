<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Hotel') }}
            </h2>
            <a href="{{ route('admin.hotel.create') }}" class="btn btn-primary">
                Tambah Data
            </a>
        </div>
    </x-slot>
    {{-- Alert --}}
    @if(session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    {{-- Content --}}
    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">


                {{-- Search & Filter --}}
                <div class="pt-4 pb-0.5 px-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-1 gap-4">
                        <form action="{{ route('admin.hotel.index') }}" method="GET"
                            class="flex flex-col sm:flex-row gap-2">

                            <input type="text" name="search" placeholder="Cari nama hotel..."
                                value="{{ request('search') }}"
                                class="rounded-md border-gray-300 focus:ring focus:ring-indigo-200 text-sm px-3 py-2 w-48" />

                            <select name="city"
                                class="rounded-md border-gray-300 focus:ring focus:ring-indigo-200 text-sm px-3 py-2 w-48">
                                <option value="">Filter Kota</option>
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
                        </form>
                    </div>
                </div>

                <div class="p-6 overflow-x-auto">

                    {{-- Table --}}
                    <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-center">No</th>
                                <th class="px-4 py-2 text-center">Logo</th>
                                <th class="px-4 py-2">Nama Hotel</th>
                                <th class="px-4 py-2">Alamat Lengkap</th>
                                <th class="px-4 py-2">Telepon</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="text-center px-4 py-2"></th>
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
                                                            <td class="px-4 py-2 whitespace-nowrap">{{ $hotel->name }}</td>
                                                            <td class="px-4 py-2">
                                                                {{ implode(', ', array_filter([
                                    $hotel->street,
                                    $hotel->village,
                                    $hotel->district,
                                    $hotel->city,
                                    $hotel->province,
                                    $hotel->postal_code
                                ])) }}
                                                            </td>
                                                            <td class="px-4 py-2">{{ $hotel->phone }}</td>
                                                            <td class="px-4 py-2">{{ $hotel->email }}</td>
                                                            <td class="text-center px-4 py-2 relative">
                                                                <x-dropdown-action 
                                                                :edit-url="route('admin.hotel.edit', $hotel->id)"
                                                                :delete-url="route('admin.hotel.destroy', $hotel->id)" />
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
    </div>
</x-app-layout>