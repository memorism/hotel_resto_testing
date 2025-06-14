<section class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-8">
        <!-- Header Section -->
        <div class="flex items-center justify-between pb-5 mb-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Ubah Password</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk keamanan maksimal.') }}
                </p>
            </div>
            <div class="h-12 w-12 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <!-- Current Password -->
            <div class="space-y-6">
                <div>
                    <label for="update_password_current_password" class="text-sm font-medium text-gray-700">
                        Kata Sandi Saat Ini
                    </label>
                    <div class="mt-1">
                        <input id="update_password_current_password" name="current_password" type="password"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            autocomplete="current-password" required>
                        @if ($errors->updatePassword->has('current_password'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('current_password') }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- New Password -->
                <div>
                    <label for="update_password_password" class="text-sm font-medium text-gray-700">
                        Kata Sandi Baru
                    </label>
                    <div class="mt-1">
                        <input id="update_password_password" name="password" type="password"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            autocomplete="new-password" required>
                        @if ($errors->updatePassword->has('password'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="update_password_password_confirmation" class="text-sm font-medium text-gray-700">
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <div class="mt-1">
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            autocomplete="new-password" required>
                        @if ($errors->updatePassword->has('password_confirmation'))
                            <p class="mt-2 text-sm text-red-600">
                                {{ $errors->updatePassword->first('password_confirmation') }}</p>
                        @endif
                    </div>
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

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-green-600 bg-green-50 px-3 py-2 rounded-lg border border-green-200">
                        Berhasil disimpan
                    </p>
                @endif
            </div>
        </form>
    </div>
</section>