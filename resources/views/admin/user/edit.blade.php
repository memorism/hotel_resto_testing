@php
    $displayUsertype = match ($user->usertype) {
        'admin' => 'Admin',
        'restonew' => 'Restaurant',
        'hotelnew' => 'Hotel',
        default => ucfirst($user->usertype),
    };
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Edit User') }}
                </h2>
            </div>
            {{-- <a href="{{ route('admin.user.user') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a> --}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-8">
                    <!-- Header Section -->
                    <div class="flex items-center justify-between pb-5 mb-6 border-b border-gray-200">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Form Edit User</h3>
                            <p class="mt-1 text-sm text-gray-500">Perbarui informasi akun pengguna.</p>
                        </div>
                        <div class="h-12 w-12 bg-blue-50 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="p-4 mb-6 rounded-lg bg-red-50 border border-red-200">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-red-700">
                                    <ul class="list-disc space-y-1 pl-5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Basic Information Section -->
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="name" value="Nama" class="text-sm font-medium text-gray-700" />
                                    <div class="mt-1">
                                        <x-text-input id="name" type="text" name="name"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            value="{{ old('name', $user->name) }}" required />
                                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="email" value="Email"
                                        class="text-sm font-medium text-gray-700" />
                                    <div class="mt-1">
                                        <x-text-input id="email" type="email" name="email"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            value="{{ old('email', $user->email) }}" required
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                            title="Please enter a valid email address (e.g., example@domain.com)" />
                                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="usertype" value="Tipe User"
                                        class="text-sm font-medium text-gray-700" />
                                    <div class="mt-1">
                                        <div class="flex items-center">
                                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                                @if($user->usertype == 'admin') bg-purple-100 text-purple-800
                                                @elseif($user->usertype == 'restonew') bg-green-100 text-green-800
                                                @elseif($user->usertype == 'hotelnew') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $displayUsertype }}
                                            </span>
                                        </div>
                                        <input type="hidden" name="usertype" value="{{ $user->usertype }}">
                                        @error('usertype') <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="space-y-6 pt-6 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-base font-medium text-gray-900">Ubah Password</h4>
                                    <span class="text-sm text-gray-500">Opsional</span>
                                </div>

                                <div>
                                    <x-input-label for="old_password" value="Password Lama"
                                        class="text-sm font-medium text-gray-700" />
                                    <div class="mt-1">
                                        <x-text-input id="old_password" type="password" name="old_password"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                        @error('old_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="password" value="Password Baru"
                                        class="text-sm font-medium text-gray-700" />
                                    <div class="mt-1">
                                        <x-text-input id="password" type="password" name="password"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" value="Konfirmasi Password"
                                        class="text-sm font-medium text-gray-700" />
                                    <div class="mt-1">
                                        <x-text-input id="password_confirmation" type="password"
                                            name="password_confirmation"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                        @error('password_confirmation') <p class="mt-1 text-sm text-red-600">
                                            {{ $message }}
                                        </p> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Logo Section -->
                            <div class="space-y-6 pt-6 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-base font-medium text-gray-900">Logo</h4>
                                    <span class="text-sm text-gray-500">Opsional</span>
                                </div>

                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        @if ($user->logo)
                                            <img src="{{ asset('storage/' . $user->logo) }}" alt="Logo"
                                                class="h-16 w-16 rounded-lg object-cover ring-2 ring-gray-200">
                                        @else
                                            <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="logo" id="logo"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            accept="image/*" />
                                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                        @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            @if ($user->usertype === 'hotelnew')
                                <input type="hidden" name="hotel_id" value="{{ $user->hotel_id }}">
                            @endif

                            @if ($user->usertype === 'restonew')
                                <input type="hidden" name="resto_id" value="{{ $user->resto_id }}">
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.user.user') }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>