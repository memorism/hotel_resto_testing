<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Tambah User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama -->
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" type="text" name="name" class="form-control" required />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" type="email" name="email" class="form-control" required />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" type="password" name="password" class="form-control" required />
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                class="form-control" required />
                        </div>

                        <!-- Tipe User -->
                        <div class="mt-4">
                            <x-input-label for="usertype" :value="__('Tipe User')" />
                            <select name="usertype" id="usertype" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="resto">Restaurant</option>
                                <option value="hotel">Hotel</option>
                            </select>
                        </div>

                        <!-- Upload Logo -->
                        <div class="mt-4">
                            <x-input-label for="logo" :value="__('Unggah Logo')" />
                            <input id="logo" type="file" name="logo" class="form-control" accept="image/*" />
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">
                                Simpan
                            </button>
                            <a href="{{ url()->previous() }}"
                                class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>