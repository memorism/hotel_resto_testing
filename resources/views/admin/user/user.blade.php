<x-app-layout>
    {{-- header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Akun Anggota') }}
            </h2>
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                Tambah Akun
            </a>
        </div>
    </x-slot>

    {{-- alert --}}
    @if(session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    {{-- isi --}}
    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">

                {{-- Search Bar --}}
                <div class="pt-4 pb-2 px-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 flex-wrap">
                        <form method="GET" action="{{ route('admin.user.user') }}" class="flex flex-wrap gap-2 w-full">
                            <input type="text" name="search" placeholder="Cari nama/email..."
                                value="{{ request('search') }}"
                                class="rounded-md border-gray-300 focus:ring focus:ring-indigo-200 text-sm px-3 py-2 w-full sm:w-48" />

                            <select name="usertype"
                                class="rounded-md border-gray-300 focus:ring focus:ring-indigo-200 text-sm px-3 py-2 w-full sm:w-40">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('usertype') == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="hotelnew" {{ request('usertype') == 'hotelnew' ? 'selected' : '' }}>Hotel
                                </option>
                                <option value="restonew" {{ request('usertype') == 'restonew' ? 'selected' : '' }}>
                                    Restaurant</option>
                            </select>

                            <select name="per_page"
                                class="rounded-md border-gray-300 focus:ring focus:ring-indigo-200 text-sm px-3 py-2 w-full sm:w-28">
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="semua" {{ request('per_page') == 'semua' ? 'selected' : '' }}>Semua
                                </option>
                            </select>

                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm w-full sm:w-auto">
                                Filter
                            </button>
                        </form>
                    </div>
                </div>


                {{-- Table --}}
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700 font-semibold">
                            <tr>
                                <th class="text-center px-4 py-3">No</th>
                                <th class="text-center px-4 py-3">Logo</th>
                                <th class="text-left px-4 py-3">Nama Pengguna</th>
                                <th class="text-left px-4 py-3">Email Pengguna</th>
                                <th class="text-center px-4 py-3">Tipe User</th>
                                <th class="text-center px-4 py-3">Waktu Pembuatan</th>
                                <th class="text-center px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="text-center px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="text-center px-4 py-3">
                                        @if($user->logo)
                                            <img src="{{ asset('storage/' . $user->logo) }}" alt="User Logo"
                                                class="h-10 w-10 object-cover rounded-full mx-auto ring-1 ring-gray-300" />
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $user->email }}</td>
                                    <td class="text-center px-4 py-3">
                                        <span
                                            class="inline-block px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">
                                            @if($user->usertype == 'admin')
                                                Admin
                                            @elseif($user->usertype == 'restonew')
                                                Restaurant
                                            @elseif($user->usertype == 'hotelnew')
                                                Hotel
                                            @else
                                                {{ ucfirst($user->usertype) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center px-4 py-3 text-gray-500">
                                        {{ $user->created_at->format('H:i | d M Y') }}
                                    </td>
                                    <td class="text-center px-4 py-2">
                                        <x-dropdown-action
                                            :view-url="in_array($user->usertype, ['hotelnew', 'restonew']) ? route('admin.user.subuser.index', $user->id) : null"
                                            :edit-url="route('admin.user.edit', $user->id)"
                                            :delete-url="route('admin.user.destroy', $user->id)" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (opsional jika pakai paginate) --}}
                <div class="p-6 border-t">{{ $users->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>