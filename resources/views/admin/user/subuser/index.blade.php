<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Akun di ' . $parentUser->name) }}
            </h2>
            <a href="{{ route('admin.subusers.create', $parentUser->id) }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                Tambah Subuser
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                {{-- Search Bar --}}
                <form method="GET" class="mb-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                        class="w-full md:w-1/3 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200" />
                </form>

                {{-- Table --}}
                <table class="min-w-full divide-y divide-gray-200 mt-2">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe User</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($subUsers as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($user->usertype) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center flex justify-center gap-2">
                                    <a href="{{ route('admin.subusers.edit', $user->id) }}"
                                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>

                                    <form method="POST" action="{{ route('admin.subusers.destroy', $user->id) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus subuser ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada subuser.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $subUsers->appends(request()->query())->links() }}
                </div>

                {{-- Back Link --}}
                <div class="mt-6">
                    <a href="{{ route('admin.user.user') }}" class="text-blue-600 hover:underline">← Kembali ke daftar user</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
