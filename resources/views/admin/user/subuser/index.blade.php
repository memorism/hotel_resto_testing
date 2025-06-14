<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Akun di ' . $parentUser->name) }}
                </h2>
            </div>
            <a href="{{ route('admin.subusers.create', $parentUser->id) }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                {{-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> --}}
                Tambah Subuser
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                <!-- Search and Filter Section -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama atau email..."
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <select name="status"
                                class="rounded-lg p-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="deleted" {{ request('status') == 'deleted' ? 'selected' : '' }}>Terhapus
                                </option>
                            </select>

                            <button type="submit"
                                class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293-.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onclick="window.location.href='{{ route('admin.user.subuser.index', array_merge(['id' => $parentUser->id], request()->query(), ['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    Nama
                                    @if(request('sort') === 'name')
                                        <span class="ml-1">
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onclick="window.location.href='{{ route('admin.user.subuser.index', array_merge(['id' => $parentUser->id], request()->query(), ['sort' => 'email', 'direction' => request('sort') === 'email' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    Email
                                    @if(request('sort') === 'email')
                                        <span class="ml-1">
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onclick="window.location.href='{{ route('admin.user.subuser.index', array_merge(['id' => $parentUser->id], request()->query(), ['sort' => 'usertype', 'direction' => request('sort') === 'usertype' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}'">
                                    Tipe User
                                    @if(request('sort') === 'usertype')
                                        <span class="ml-1">
                                            @if(request('direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        </span>
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($subUsers as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                        @if($user->usertype == 'admin') bg-purple-100 text-purple-800
                                                                        @elseif($user->usertype == 'restonew') bg-green-100 text-green-800
                                                                        @elseif($user->usertype == 'hotelnew') bg-blue-100 text-blue-800
                                                                        @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($user->usertype) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <x-dropdown-action
                                            :edit-url="!$user->trashed() ? route('admin.subusers.edit', $user->id) : null"
                                            :delete-url="!$user->trashed() ? route('admin.subusers.destroy', $user->id) : null"
                                            :restore-url="$user->trashed() ? route('admin.subusers.restore', $user->id) : null"
                                            :is-restore="$user->trashed()" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-center items-center text-center py-6">
                                            <div class="text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada subuser</h3>
                                                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan subuser baru.
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Section -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.user.user') }}"
                            class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                            <svg class="mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke daftar user
                        </a>

                        {{-- Uncomment if pagination is needed --}}
                        <div>
                            {{ $subUsers->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>