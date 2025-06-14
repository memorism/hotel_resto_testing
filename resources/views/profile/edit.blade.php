<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Profil Pengguna') }}
                </h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500">Kelola informasi profil dan keamanan akun Anda</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Update Profile Information -->
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete User Account -->
            {{-- <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-200">
                <div class="p-8">
                    <!-- Header Section -->
                    <div class="flex items-center justify-between pb-5 mb-6 border-b border-gray-200">
                        <div>
                            <h3 class="text-lg font-semibold text-red-600">Hapus Akun</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-red-50 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>