<section class="space-y-6">
    <header>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Setelah akun Anda dihapus, semua data dan sumber daya yang terkait akan dihapus secara permanen. Pastikan Anda telah menyimpan data yang dibutuhkan sebelum melanjutkan.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded shadow-sm transition"
    >
        {{ __('Hapus Akun') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-semibold text-gray-800">
                {{ __('Yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                {{ __('Semua data Anda akan terhapus secara permanen. Masukkan kata sandi untuk konfirmasi.') }}
            </p>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:ring focus:ring-red-300"
                    placeholder="Masukkan kata sandi Anda"
                    required
                >
                @if ($errors->userDeletion->has('password'))
                    <p class="text-sm text-red-600 mt-1">
                        {{ $errors->userDeletion->first('password') }}
                    </p>
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
