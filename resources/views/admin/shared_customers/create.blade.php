<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                {{-- <a href="{{ route('admin.shared_customers.index') }}" class="inline-flex items-center mr-4 text-gray-600 hover:text-gray-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a> --}}
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Tambah Pelanggan Global
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.shared_customers.store') }}" method="POST">
                        @csrf

                        <!-- Informasi Dasar -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-form.input 
                                    name="name" 
                                    label="Nama" 
                                    required />
                                
                                <x-form.select 
                                    name="gender" 
                                    label="Jenis Kelamin" 
                                    :options="['L' => 'Laki-laki', 'P' => 'Perempuan']" />

                                <x-form.input 
                                    name="birth_date" 
                                    label="Tanggal Lahir" 
                                    type="date" />
                            </div>
                        </div>

                        <!-- Kontak -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kontak</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-form.input 
                                    name="email" 
                                    label="Email" 
                                    type="email" />
                                
                                <x-form.input 
                                    name="phone" 
                                    label="No. Telepon" />

                                <div class="md:col-span-2">
                                    <x-form.textarea 
                                        name="address" 
                                        label="Alamat" 
                                        rows="3" />
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.shared_customers.index') }}"
                                class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 shadow-sm transition-colors duration-150">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors duration-150">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Pelanggan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
