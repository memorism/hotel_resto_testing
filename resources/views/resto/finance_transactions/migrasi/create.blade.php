<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{-- <a href="{{ route('financeresto.import.history') }}" class="mr-4">
                <svg class="w-6 h-6 text-gray-600 hover:text-gray-900 transition-colors duration-150" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a> --}}
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Upload Excel Keuangan Restoran
            </h2>
            <a href="https://docs.google.com/spreadsheets/d/1JKv6OKEMTFMoyVZSHYo7JMIVezkde8Kt/export?format=xlsx"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out"
                target="_blank" rel="noopener noreferrer">
                Download Template Excel
            </a>

        </div>
    </x-slot>

    <div class="py-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('financeresto.import') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div>
                        <label for="file_name" class="block text-sm font-medium text-gray-700 mb-1">Nama File</label>
                        <input type="text" id="file_name" name="file_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150"
                            required>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150"
                            placeholder="Masukkan deskripsi file..."></textarea>
                    </div>

                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File Excel</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 transition-colors duration-150">
                            <div class="space-y-1 text-center w-full">
                                <!-- Area Upload Default -->
                                <div id="upload-default" class="space-y-1">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file"
                                            class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload file</span>
                                            <input id="file" name="file" type="file" accept=".xlsx,.xls" class="sr-only"
                                                required onchange="handleFileSelect(this)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        Excel files only (.xlsx, .xls)
                                    </p>
                                </div>

                                <!-- Preview File yang Dipilih -->
                                <div id="file-preview" class="hidden space-y-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span id="file-name" class="text-sm font-medium text-gray-900"></span>
                                    </div>
                                    <div class="flex justify-center">
                                        <button type="button" onclick="removeFile()"
                                            class="inline-flex items-center px-3 py-1 text-sm text-red-600 hover:text-red-700 focus:outline-none">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus File
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('file')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end mt-4">
                        <a href="{{ route('financeresto.import.history') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back
                        </a>
                        <button type="submit"
                            class="flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Upload & Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function handleFileSelect(input) {
            const file = input.files[0];
            if (file) {
                // Update nama file
                document.getElementById('file-name').textContent = file.name;

                // Tampilkan preview dan sembunyikan area upload default
                document.getElementById('upload-default').classList.add('hidden');
                document.getElementById('file-preview').classList.remove('hidden');
            }
        }

        function removeFile() {
            // Reset input file
            const fileInput = document.getElementById('file');
            fileInput.value = '';

            // Sembunyikan preview dan tampilkan area upload default
            document.getElementById('file-preview').classList.add('hidden');
            document.getElementById('upload-default').classList.remove('hidden');
        }

        // Tambahkan drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-indigo-500');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-indigo-500');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const file = dt.files[0];
            const fileInput = document.getElementById('file');

            // Hanya terima file excel
            if (file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
                file.type === 'application/vnd.ms-excel') {
                fileInput.files = dt.files;
                handleFileSelect(fileInput);
            } else {
                alert('Hanya file Excel yang diperbolehkan (.xlsx, .xls)');
            }
        }
    </script>
</x-app-layout>