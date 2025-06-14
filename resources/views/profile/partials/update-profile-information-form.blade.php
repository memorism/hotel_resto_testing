<section class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-8">
        <!-- Header Section -->
        <div class="flex items-center justify-between pb-5 mb-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Informasi Profil</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Perbarui informasi profil dan alamat email akun Anda.') }}
                </p>
            </div>
            <div class="h-12 w-12 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
        </div>

        <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Basic Information Section -->
            <div class="space-y-6">
                <div>
                    <label for="usertype" class="text-sm font-medium text-gray-700">Tipe Pengguna</label>
                    <div class="mt-1">
                        <input id="usertype" name="usertype" type="text"
                            value="{{ old('usertype', $user->usertype === 'resto' ? 'Restaurant' : $user->usertype) }}"
                            class="block w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            disabled>
                        @if($errors->has('usertype'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->first('usertype') }}</p>
                        @endif
                    </div>
                </div>

                <div>
                    <label for="name" class="text-sm font-medium text-gray-700">Nama</label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                        @if($errors->has('name'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                </div>

                <div>
                    <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                        @if($errors->has('email'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-2 p-4 rounded-lg bg-yellow-50 border border-yellow-200">
                            <div class="flex">
                                <svg class="h-5 w-5 text-yellow-400 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="text-sm text-yellow-700">
                                        {{ __('Alamat email Anda belum terverifikasi.') }}
                                    </p>
                                    <button form="send-verification"
                                        class="mt-2 text-sm font-medium text-yellow-700 hover:text-yellow-600 underline">
                                        {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                                    </button>
                                </div>
                            </div>

                            @if (session('status') === 'verification-link-sent')
                                <div class="mt-4 p-3 rounded-lg bg-green-50 border border-green-200">
                                    <p class="text-sm text-green-700">
                                        {{ __('Link verifikasi baru telah dikirim ke email Anda.') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan
                </button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-green-600 bg-green-50 px-3 py-2 rounded-lg border border-green-200">
                        Berhasil disimpan
                    </p>
                @endif
            </div>
        </form>
    </div>
</section>