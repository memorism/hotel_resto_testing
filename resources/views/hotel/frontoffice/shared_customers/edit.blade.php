<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Edit Pelanggan Hotel') }}
            </h2>
            {{-- <a href="{{ route('hotel.frontoffice.shared_customers.index_hotel') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a> --}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <form action="{{ route('hotel.frontoffice.shared_customers.update_hotel', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Data Pribadi Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Data Pribadi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-form.input 
                                    name="name" 
                                    label="Nama" 
                                    :value="$customer->name"
                                    required 
                                    placeholder="Masukkan nama lengkap"
                                />
                                <x-form.input 
                                    name="email" 
                                    label="Email" 
                                    type="email" 
                                    :value="$customer->email"
                                    placeholder="contoh@email.com"
                                />
                            </div>
                        </div>

                        <!-- Informasi Kontak Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Informasi Kontak</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-form.input 
                                    name="phone" 
                                    label="No. Telepon"
                                    :value="$customer->phone"
                                    placeholder="Contoh: 08123456789"
                                />
                                <x-form.select 
                                    name="gender" 
                                    label="Jenis Kelamin" 
                                    :options="['L' => 'Laki-laki', 'P' => 'Perempuan']"
                                    :selected="$customer->gender"
                                />
                                <x-form.input 
                                    name="birth_date" 
                                    label="Tanggal Lahir" 
                                    type="date"
                                    :value="$customer->birth_date"
                                />
                                <div class="md:col-span-2">
                                    <x-form.textarea 
                                        name="address" 
                                        label="Alamat"
                                        :value="$customer->address"
                                        placeholder="Masukkan alamat lengkap"
                                        rows="3"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('hotel.frontoffice.shared_customers.index_hotel') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
