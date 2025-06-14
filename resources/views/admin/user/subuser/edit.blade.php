<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Edit Subuser') }}
                </h2>
            </div>
            {{-- <a href="{{ route('admin.user.subuser.index', $parentUser->id) }}"
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
                            <h3 class="text-lg font-semibold text-gray-900">Form Edit Subuser</h3>
                            <p class="mt-1 text-sm text-gray-500">Perbarui informasi akun subuser.</p>
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

                    <form action="{{ route('admin.subusers.update', $subuser->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information Section -->
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="name" value="Nama" class="text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <x-text-input id="name" type="text" name="name"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        value="{{ old('name', $subuser->name) }}" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="email" value="Email" class="text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <x-text-input id="email" type="email" name="email"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        value="{{ old('email', $subuser->email) }}" required
                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                        title="Please enter a valid email address (e.g., example@domain.com)" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="space-y-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <h4 class="text-base font-medium text-gray-900">Password</h4>
                                <span class="text-sm text-gray-500">Password lama wajib diisi</span>
                            </div>

                            <div>
                                <x-input-label for="old_password" value="Password Lama"
                                    class="text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <x-text-input id="old_password" type="password" name="old_password"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required />
                                    <x-input-error :messages="$errors->get('old_password')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="password" value="Password Baru (Opsional)"
                                    class="text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <x-text-input id="password" type="password" name="password"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" value="Konfirmasi Password Baru"
                                    class="text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <x-text-input id="password_confirmation" type="password"
                                        name="password_confirmation"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Role Section -->
                        <div class="space-y-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <h4 class="text-base font-medium text-gray-900">Role</h4>
                            </div>

                            <div>
                                <x-input-label for="usertype" value="Pilih Role"
                                    class="text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <select id="usertype" name="usertype"
                                        class="block w-full p-2 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required>
                                        @php
                                            $roles = $parentUser->usertype === 'hotelnew'
                                                ? ['frontofficehotel' => 'Front Office ', 'financehotel' => 'Finance ', 'scmhotel' => 'SCM ']
                                                : ['cashierresto' => 'Cashier', 'financeresto' => 'Finance', 'scmresto' => 'SCM'];
                                        @endphp

                                        @foreach($roles as $key => $label)
                                            <option value="{{ $key }}" @selected(old('usertype', $subuser->usertype) == $key)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('usertype')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.user.subuser.index', $parentUser->id) }}"
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
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>