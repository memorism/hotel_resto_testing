<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Tambah Restaurant') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-md rounded-lg">
                
                {{-- Title Section --}}
                <h3 class="text-lg font-semibold text-gray-700 mb-6">
                    Formulir Informasi Restaurant
                </h3>

                {{-- Form --}}
                <form action="{{ route('admin.resto.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    {{-- Include partial form --}}
                    @include('admin.resto.form')

                    {{-- Button Section --}}
                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('admin.resto.index') }}" 
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                Batal
                            </a>
                            <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Simpan
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
