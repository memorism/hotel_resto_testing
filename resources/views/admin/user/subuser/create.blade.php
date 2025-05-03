<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Tambah Subuser') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-md rounded-lg">
                <form action="{{ route('admin.subusers.store', $parentUser->id) }}" method="POST">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Subuser')" />
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


                    <!-- Role Subuser -->
                    <div class="mb-4">
                        <x-input-label for="usertype" :value="__('Tipe Subuser')" />
                        <select id="usertype" name="usertype"
                            class="block w-full mt-1 border-gray-300 rounded-md  px-3 py-2 shadow-sm focus:ring focus:ring-indigo-200"
                            required>
                            <option value=""> Pilih Role </option>
                            @if($parentUser->usertype === 'hotelnew')
                                <option value="frontofficehotel">Front Office</option>
                                <option value="financehotel">Finance</option>
                                <option value="scmhotel">SCM</option>
                            @elseif($parentUser->usertype === 'restonew')
                                <option value="frontofficeresto">Front Office</option>
                                <option value="financeresto">Finance</option>
                                <option value="scmresto">SCM</option>
                            @endif
                        </select>
                        <x-input-error :messages="$errors->get('usertype')" class="mt-2" />
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end space-x-2 mt-6">
                        <a href="{{ route('admin.user.subuser.index', $parentUser->id) }}"
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