<section>
    <header>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui informasi profil dan alamat email akun Anda.') }}
        </p>
    </header>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <div>
            <label for="usertype" class="block text-sm font-medium text-gray-700">Tipe Pengguna</label>
            <input id="usertype" name="usertype" type="text"
                value="{{ old('usertype', $user->usertype === 'resto' ? 'Restaurant' : $user->usertype) }}"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" disabled>
            @if($errors->has('usertype'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->first('usertype') }}</p>
            @endif
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" required>
            @if($errors->has('name'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" required>
            @if($errors->has('email'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->first('email') }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-600">
                        {{ __('Alamat email Anda belum terverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600">
                            {{ __('Link verifikasi baru telah dikirim ke email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600">Berhasil disimpan.</p>
            @endif
        </div>
    </form>
</section>