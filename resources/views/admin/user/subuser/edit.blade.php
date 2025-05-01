<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Edit Subuser') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-md rounded-lg">
                <form action="{{ route('admin.subusers.update', $subuser->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" type="text" name="name" class="block w-full mt-1"
                            value="{{ old('name', $subuser->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" class="block w-full mt-1"
                            value="{{ old('email', $subuser->email) }}" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password Lama -->
                    <div class="mb-4">
                        <x-input-label for="old_password" :value="__('Password Lama')" />
                        <x-text-input id="old_password" type="password" name="old_password" class="block w-full mt-1" />
                        <x-input-error :messages="$errors->get('old_password')" class="mt-2" />
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password Baru')" />
                        <x-text-input id="password" type="password" name="password" class="block w-full mt-1" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                            class="block w-full mt-1" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>


                    <div class="mb-4">
                        <x-input-label for="usertype" :value="__('Role')" />
                        <select id="usertype" name="usertype" class="block w-full mt-1 border-gray-300 rounded-md"
                            required>
                            @php
                                $roles = $parentUser->usertype === 'hotelnew'
                                    ? ['frontofficehotel', 'financehotel', 'scmhotel']
                                    : ['frontofficeresto', 'financeresto', 'scmresto'];
                            @endphp

                            @foreach($roles as $role)
                                <option value="{{ $role }}" @selected($subuser->usertype == $role)>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('usertype')" class="mt-2" />
                    </div>

                    <div class="flex justify-end space-x-2 mt-6">
                        <a href="{{ route('admin.user.subuser.index', $parentUser->id) }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>