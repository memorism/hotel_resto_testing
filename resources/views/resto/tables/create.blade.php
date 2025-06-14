<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                {{-- <a href="{{ route('resto.tables.index') }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 transition-all duration-200 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                </a> --}}
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    Tambah Meja Restoran
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('resto.tables.store') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-6">
                            <div class="relative group">
                                <x-form.input 
                                    name="table_code" 
                                    label="Kode Meja" 
                                    required
                                    class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 bg-gray-50 group-hover:bg-white" 
                                />
                                <div class="absolute inset-0 border border-gray-200 rounded-xl pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            </div>

                            <div class="relative group">
                                <x-form.input 
                                    name="capacity" 
                                    label="Kapasitas" 
                                    type="number" 
                                    min="1" 
                                    required
                                    class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 bg-gray-50 group-hover:bg-white" 
                                />
                                <div class="absolute inset-0 border border-gray-200 rounded-xl pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            </div>

                            <div class="relative group">
                                <x-form.select 
                                    name="is_active" 
                                    label="Status" 
                                    :options="['1' => 'Aktif', '0' => 'Tidak Aktif']" 
                                    required
                                    class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 bg-gray-50 group-hover:bg-white" 
                                />
                                <div class="absolute inset-0 border border-gray-200 rounded-xl pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('resto.tables.index') }}"
                                    class="group inline-flex items-center px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Batal
                                </a>
                                <button type="submit"
                                    class="group inline-flex items-center px-6 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transform group-hover:scale-110 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
