<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Tambah User') }}
            </h2>
            <a class="invisible btn btn-primary">test</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8" x-data="{ usertype: '' }">
            <div class="bg-white p-6 shadow-md rounded-lg">
                <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" type="text" name="name" class="block w-full mt-1" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" class="block w-full mt-1" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" type="password" name="password" class="block w-full mt-1"
                            required />
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
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 px-3  py-2 text-sm"
                            x-model="usertype" required>
                            <option value=""> Pilih Tipe User</option>
                            <option value="admin">Admin</option>
                            <option value="restonew">Restaurant</option>
                            <option value="hotelnew">Hotel</option>
                        </select>
                        <x-input-error :messages="$errors->get('usertype')" class="mt-2" />
                    </div>

                    <!-- Pilih Hotel (Hanya muncul jika usertype == hotel) -->
                    <div class="mb-4" x-show="usertype === 'hotelnew'">
                        <x-input-label for="hotel_id" :value="__('Pilih Hotel')" />
                        <select id="hotel_id" name="hotel_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 px-3  py-2 text-sm">
                            <option value="">Pilih Hotel</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('hotel_id')" class="mt-2" />
                    </div>

                    <!-- Pilih Resto (Hanya muncul jika usertype == resto) -->
                    <div class="mb-4" x-show="usertype === 'restonew'">
                        <x-input-label for="resto_id" :value="__('Pilih Restaurant')" />
                        <select id="resto_id" name="resto_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 px-3  py-2 text-sm">
                            <option value="">Pilih Restaurant</option>
                            @foreach($restos as $resto)
                                <option value="{{ $resto->id }}">{{ $resto->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('resto_id')" class="mt-2" />
                    </div>

                    <!-- Upload Logo -->
                    <div class="mb-4">
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class=" mr-1 text-indigo-500"></i> Unggah Logo (PNG)
                        </label>

                        <div class="flex items-center space-x-4">
                            <input id="logo" type="file" name="logo"
                                class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                                       file:rounded-md file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-indigo-50
                                       hover:file:bg-indigo-100
                                       rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring focus:ring-indigo-200"
                                accept="image/png,image/jpeg,image/webp" />

                            {{-- Optional: Preview image jika sudah ada --}}
                            @if(isset($currentLogo))
                                <img src="{{ asset('storage/' . $currentLogo) }}" alt="Current Logo"
                                    class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-300" />
                            @endif
                        </div>

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