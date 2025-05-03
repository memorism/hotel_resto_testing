<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Akun di ' . $parentUser->name) }}
            </h2>
            <a href="{{ route('admin.subusers.create', $parentUser->id) }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                Tambah Subuser
            </a>
        </div>
    </x-slot>

    {{-- Content --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">

                {{-- Search Bar --}}
                <div class="p-4 border-gray-200">
                    <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email..."
                            class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 text-sm" />
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm">
                            Cari
                        </button>
                    </form>
                </div>

                {{-- Table --}}
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-700 font-semibold">
                            <tr>
                                <th class="px-6 py-3 text-left">No</th>
                                <th class="px-6 py-3 text-left">Nama</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-left">Tipe User</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($subUsers as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">
                                            {{ ucfirst($user->usertype) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <x-dropdown-action
                                            :edit-url="route('admin.subusers.edit', $user->id)"
                                            :delete-url="route('admin.subusers.destroy', $user->id)" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada subuser.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                {{-- <div class="p-4">
                    {{ $subUsers->appends(request()->query())->links() }}
                </div> --}}

                {{-- Back Link --}}
                <div class="p-4">
                    <a href="{{ route('admin.user.user') }}" class="text-blue-600 hover:underline text-sm">
                        ← Kembali ke daftar user
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
