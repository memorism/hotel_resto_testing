<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Tambah User') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8" x-data="{ usertype: '' }">
            <div class="bg-white p-6 shadow-md rounded-lg">
                <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" type="text" name="name"
                            class="block w-full mt-1" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email"
                            class="block w-full mt-1" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" type="password" name="password"
                            class="block w-full mt-1" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                            class="block w-full mt-1" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Tipe User -->
                    <div class="mb-4">
                        <x-input-label for="usertype" :value="__('Tipe User')" />
                        <select id="usertype" name="usertype"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                            x-model="usertype" required>
                            <option value="">-- Pilih Tipe User --</option>
                            <option value="admin">Admin</option>
                            <option value="resto">Restaurant</option>
                            <option value="hotel">Hotel</option>
                        </select>
                        <x-input-error :messages="$errors->get('usertype')" class="mt-2" />
                    </div>

                    <!-- Pilih Hotel (Hanya muncul jika usertype == hotel) -->
                    <div class="mb-4" x-show="usertype === 'hotel'">
                        <x-input-label for="hotel_id" :value="__('Pilih Hotel')" />
                        <select id="hotel_id" name="hotel_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="">-- Pilih Hotel --</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('hotel_id')" class="mt-2" />
                    </div>

                    <!-- Pilih Resto (Hanya muncul jika usertype == resto) -->
                    <div class="mb-4" x-show="usertype === 'resto'">
                        <x-input-label for="resto_id" :value="__('Pilih Restaurant')" />
                        <select id="resto_id" name="resto_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="">-- Pilih Restaurant --</option>
                            @foreach($restos as $resto)
                                <option value="{{ $resto->id }}">{{ $resto->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('resto_id')" class="mt-2" />
                    </div>

                    <!-- Upload Logo -->
                    <div class="mb-4">
                        <x-input-label for="logo" :value="__('Unggah Logo (PNG)')" />
                        <input id="logo" type="file" name="logo"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                            accept="image/*" />
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end space-x-2 mt-6">
                        <a href="{{ route('admin.user.user') }}"
                            class="px-4 py-2 bg-gray-500 text-white font-semibold rounded hover:bg-gray-600 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
