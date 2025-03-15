<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" type="text" name="name" class="form-control"
                                value="{{ $user->name }}" required />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" type="email" name="email" class="form-control"
                                value="{{ $user->email }}" required />
                        </div>

                        <!-- Password Lama (Wajib diisi jika ingin mengganti password) -->
                        <div class="mt-4">
                            <x-input-label for="old_password" :value="__('Password Lama')" />
                            <x-text-input id="old_password" type="password" name="old_password" class="form-control"
                                required />
                            @error('old_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Baru (Opsional, hanya jika ingin mengganti password) -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password Baru (Opsional)')" />
                            <x-text-input id="password" type="password" name="password" class="form-control" />
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                class="form-control" />
                        </div>



                        <!-- Tipe User -->
                        <div class="mt-4">
                            <x-input-label for="usertype" :value="__('Tipe User')" />
                            <select name="usertype" id="usertype" class="form-control" required>
                                <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="resto" {{ $user->usertype == 'resto' ? 'selected' : '' }}>Restaurant
                                </option>
                                <option value="hotel" {{ $user->usertype == 'hotel' ? 'selected' : '' }}>Hotel</option>
                            </select>
                        </div>

                        <!-- Upload Logo -->
                        <div class="mt-4">
                            <x-input-label for="logo" :value="__('Unggah Logo Baru (Opsional)')" />
                            <input id="logo" type="file" name="logo" class="form-control" accept="image/*" />
                        </div>

                        <!-- Menampilkan Logo Lama -->
                        <div class="mt-4">
                            <p>Logo Saat Ini:</p>
                            @if($user->logo)
                                <img src="{{ asset('storage/' . $user->logo) }}" width="80" class="rounded-md">
                            @else
                                <span>Tidak ada logo</span>
                            @endif
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.user.user') }}"
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