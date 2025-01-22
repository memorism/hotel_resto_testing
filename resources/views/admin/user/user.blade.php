<x-app-layout>
    {{-- header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('User') }}
            </h2>
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                Tambah User
            </a>
        </div>
    </x-slot>

    {{-- isi --}}
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center px-4 py-2">No</th>
                                    <th scope="col" class="text-center px-4 py-2">Nama Pengguna</th>
                                    <th scope="col" class="text-center px-4 py-2">Email Pengguna</th>
                                    <th scope="col" class="text-center px-4 py-2">Tipe User</th>
                                    <th scope="col" class="text-center px-4 py-2">Waktu Pembuatan Akun</th>
                                    <th scope="col" class="text-center px-4 py-2" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="text-center px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="text-center px-4 py-2">{{ $user->name }}</td>
                                        <td class="text-center px-4 py-2">{{ $user->email }}</td>
                                        <td class="text-center px-4 py-2">
                                            @if($user->usertype == 'admin')
                                                Admin
                                            @elseif($user->usertype == 'resto')
                                                Restaurant
                                            @elseif($user->usertype == 'hotel')
                                                Hotel
                                            @else
                                                {{ ucfirst($user->usertype) }} <!-- Jika ada tipe user lain yang belum ditangani -->
                                            @endif
                                        </td>
                                                                                <td class="text-center px-4 py-2">{{ $user->created_at->format('H:i:s | d M Y ') }}</td>
                                        <td class="text-center px-4 py-2">
                                            <form method="POST" action="{{ route('admin.user.destroy', $user->id) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE') <!-- Menandakan metode DELETE -->
                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600">
                                                    {{ __('Delete') }}
                                                </button>
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
    </div>
</x-app-layout>

@if(session('success'))
    <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md">
        {{ session('success') }}
    </div>
@endif
