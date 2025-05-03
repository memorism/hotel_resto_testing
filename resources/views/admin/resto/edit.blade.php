<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Edit Resto ' . $resto->name) }}
            </h2>
            <a class="invisible btn btn-primary">test</a>
        </div>
    </x-slot>



    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-md rounded-lg border border-gray-200">
                {{-- Judul --}}
                <h3 class="text-lg font-semibold text-gray-700 mb-6">Form Edit Data Resto</h3>

                {{-- Form --}}
                <form action="{{ route('admin.resto.update', $resto->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Isi form terpisah --}}
                    @include('admin.resto.form', ['resto' => $resto])

                    {{-- Tombol --}}
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
                </form>
            </div>
        </div>
    </div>
</x-app-layout>