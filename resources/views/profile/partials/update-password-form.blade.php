<section>
    <header>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk keamanan maksimal.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700">Kata Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-blue-200" autocomplete="current-password" required>
            @if ($errors->updatePassword->has('current_password'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-blue-200" autocomplete="new-password" required>
            @if ($errors->updatePassword->has('password'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-blue-200" autocomplete="new-password" required>
            @if ($errors->updatePassword->has('password_confirmation'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                Simpan
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >Berhasil disimpan.</p>
            @endif
        </div>
    </form>
</section>
