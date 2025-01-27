<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Tambah Data') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <div class="min-w-full align-middle">
    
                        <h2 class="text-2xl font-bold mb-4">Tambah Booking Baru</h2>
    
                        @if (session('success'))
                            <div class="alert alert-success bg-green-500 text-white p-3 rounded-md">
                                {{ session('success') }}
                            </div>
                        @endif
    
                        <!-- Form untuk Input Manual + Upload Excel -->
                         <form method="POST" action=" {{ route('hotel.databooking.storeImport') }} " enctype="multipart/form-data">
                            @csrf
    
                            <!-- Nama File -->
                           <div>
                                <x-input-label for="file_name" :value="__('Nama File')" />
                                <x-text-input id="file_name" class="block mt-1 w-full" type="text" name="file_name"
                                    :value="old('file_name')" autofocus autocomplete="file_name" />
                                <x-input-error :messages="$errors->get('file_name')" class="mt-2" />
                            </div>
    
                            <!-- Deskripsi -->
                            <div class="mt-4">
                                <x-input-label for="description" :value="__('Deskripsi')" />
                                <textarea id="description" name="description"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    rows="3">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
    
                            <!-- Upload File Excel -->
                            <div class="mt-4" >
                                <x-input-label for="file" :value="__('Pilih File Excel (Opsional)')" />
                                <input id="file" type="file" name="file"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            </div> 
    
                            <!-- Tombol Aksi -->
                            <div class="flex items-center justify-end mt-4">
                                <a href="{{ route('hotel.databooking.index') }}"
                                    class="ms-4 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md shadow-md">
                                    {{ __('Kembali') }}
                                </a>
    
                                <button type="submit"
                                    class="ms-4 px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-md shadow-md">
                                    {{ __('Simpan Data') }}
                                </button>
                            </div>
    
                        </form>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</x-app-layout>
