<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Profil Pengguna') }}
            </h2>
            <a class="invisible btn btn-primary">test</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Update Profile Information -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Profil</h3>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Ubah Kata Sandi</h3>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Delete User Account -->
            {{-- <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-600 mb-4">Hapus Akun</h3>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>