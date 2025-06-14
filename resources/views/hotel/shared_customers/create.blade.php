<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Tambah Pelanggan Hotel') }}
            </h2>
            {{-- <a href="{{ route('hotel.shared_customers.index') }}" 
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a> --}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <form action="{{ route('hotel.shared_customers.store') }}" method="POST">
                        @csrf

                        <!-- Personal Information Section -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-form.input 
                                    name="name" 
                                    label="Nama" 
                                    required 
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                />
                                <x-form.input 
                                    name="email" 
                                    label="Email" 
                                    type="email"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                />
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kontak</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-form.input 
                                    name="phone" 
                                    label="No. Telepon"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                />
                                <x-form.select 
                                    name="gender" 
                                    label="Jenis Kelamin" 
                                    :options="['L' => 'Laki-laki', 'P' => 'Perempuan']"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                />
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Tambahan</h3>
                            <div class="grid grid-cols-1 gap-6">
                                <x-form.input 
                                    name="birth_date" 
                                    label="Tanggal Lahir" 
                                    type="date"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                />
                                <x-form.textarea 
                                    name="address" 
                                    label="Alamat"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    rows="4"
                                />
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-4">
                            <a href="{{ route('hotel.shared_customers.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
