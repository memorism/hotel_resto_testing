
@php
    if ($user->usertype == 'admin') {
        $displayUsertype = 'Admin';
    } elseif ($user->usertype == 'restonew') {
        $displayUsertype = 'Restaurant';
    } elseif ($user->usertype == 'hotelnew') {
        $displayUsertype = 'Hotel';
    } else {
        $displayUsertype = ucfirst($user->usertype);
    }
@endphp




<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-md rounded-lg">
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" type="text" name="name" class="block w-full mt-1"
                            :value="$user->name" required />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" class="block w-full mt-1"
                            :value="$user->email" required />
                    </div>

                    <!-- Password Lama -->
                    <div class="mb-4">
                        <x-input-label for="old_password" :value="__('Password Lama')" />
                        <x-text-input id="old_password" type="password" name="old_password" class="block w-full mt-1" required />
                        @error('old_password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password Baru')" />
                        <x-text-input id="password" type="password" name="password" class="block w-full mt-1" />
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation" class="block w-full mt-1" />
                    </div>

                    <!-- Tipe User -->
                    <div class="mb-4">
                        <x-input-label for="usertype" :value="__('Tipe User')" />
                        <input type="text" name="usertype" id="usertype" class="form-control"
                               value="{{ $displayUsertype }}" readonly>
                    </div>

                    <!-- Upload Logo -->
                    <div class="mb-4">
                        <x-input-label for="logo" :value="__('Unggah Logo Baru (PNG)')" />
                        <input id="logo" type="file" name="logo"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                            accept="image/*" />
                    </div>

                    <!-- Logo Saat Ini -->
                    <div class="mb-4">
                        <x-input-label :value="__('Logo Saat Ini')" />
                        @if($user->logo)
                            <img src="{{ asset('storage/' . $user->logo) }}" class="w-20 h-20 object-cover rounded-md mt-2">
                        @else
                            <p class="text-gray-500 text-sm mt-1">Tidak ada logo</p>
                        @endif
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end space-x-2 mt-6">
                        <a href="{{ route('admin.user.user') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
