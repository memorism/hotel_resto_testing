<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Upload Data Migrasi Booking') }}
            </h2>
            <a href="https://docs.google.com/spreadsheets/d/14uDrumUY-nFqigFN-YDuhTjBzTbCfSkk/export?format=xlsx"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out"
                target="_blank" rel="noopener noreferrer">
                Download Template Excel
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-600 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('hotel.frontoffice.migrasi.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Informasi File Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Informasi File</h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama File <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="file_name" required placeholder="Masukkan nama file"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        File Excel <span class="text-red-500">*</span>
                                    </label>
                                    <div
                                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-150 ease-in-out">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                fill="none" viewBox="0 0 48 48" id="upload-icon">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-4h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex flex-col items-center text-sm text-gray-600">
                                                <label for="file-upload"
                                                    class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Upload file</span>
                                                    <input id="file-upload" name="file" type="file" class="sr-only"
                                                        required accept=".xlsx,.xls" onchange="updateFileName(this)">
                                                </label>
                                                <p class="mt-1">atau drag and drop</p>
                                                <div class="mt-2 flex items-center gap-2" id="file-info"
                                                    style="display: none;">
                                                    <p id="selected-file" class="text-sm text-gray-500"></p>
                                                    <button type="button" onclick="clearFile()"
                                                        class="inline-flex items-center p-1 text-red-600 hover:text-red-800 transition-colors duration-150">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-500">Excel file (XLS, XLSX)</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Keterangan
                                    </label>
                                    <textarea name="description" rows="3" placeholder="Tambahkan keterangan (opsional)"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('hotel.frontoffice.migrasi.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Upload File
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0]?.name;
            const fileInfo = document.getElementById('file-info');
            const selectedFile = document.getElementById('selected-file');
            const dropzone = input.closest('.border-dashed');

            if (fileName) {
                selectedFile.textContent = fileName;
                fileInfo.style.display = 'flex';
                dropzone.classList.add('border-green-500', 'bg-green-50');
            } else {
                fileInfo.style.display = 'none';
                dropzone.classList.remove('border-green-500', 'bg-green-50');
            }
        }

        function clearFile() {
            const fileInput = document.getElementById('file-upload');
            const fileInfo = document.getElementById('file-info');
            const dropzone = fileInput.closest('.border-dashed');

            // Reset file input
            fileInput.value = '';

            // Hide file info
            fileInfo.style.display = 'none';

            // Reset dropzone styling
            dropzone.classList.remove('border-green-500', 'bg-green-50');
        }

        // Drag and drop functionality
        const dropzone = document.querySelector('div[class*="border-dashed"]');
        const fileInput = document.getElementById('file-upload');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropzone.classList.add('border-blue-500', 'bg-blue-50');
        }

        function unhighlight(e) {
            dropzone.classList.remove('border-blue-500', 'bg-blue-50');
            const fileName = fileInput.files[0]?.name;
            if (fileName) {
                dropzone.classList.add('border-green-500', 'bg-green-50');
            }
        }

        dropzone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                fileInput.files = files;
                updateFileName(fileInput);
            }
        }
    </script>
</x-app-layout>