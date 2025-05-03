<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Data Migrasi Booking (Excel)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 p-3 text-green-700 bg-green-100 border border-green-300 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-300 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('hotel.frontoffice.migrasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama File <span class="text-red-500">*</span></label>
                        <input type="text" name="file_name" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih File Excel <span class="text-red-500">*</span></label>
                        <input type="file" name="file" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Optional)</label>
                        <input type="text" name="description"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-2">
                        <a href="{{ route('hotel.frontoffice.migrasi.index') }}"
                            class="w-full sm:w-auto text-center bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>