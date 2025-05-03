<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class=" fw-semibold fs-4 text-dark">
                {{ __('Tambah Data') }}
            </h2>
            <a href="{{ asset('storage/template_bookings.xlsx') }}" class="btn btn-primary">
                Download Template Excel
            </a>        
        </div>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Booking Baru</h2>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('hotel.databooking.storeImport') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="file" :value="__('Pilih File Excel (Opsional)')" />
                        <input id="file" type="file" name="file"
                            class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                        <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="file_name" :value="__('Nama File')" />
                        <x-text-input id="file_name" class="block mt-1 w-full" type="text" name="file_name"
                            :value="old('file_name')" autofocus autocomplete="file_name" />
                        <x-input-error :messages="$errors->get('file_name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea id="description" name="description"
                            class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300"
                            rows="3">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div id="previewContainer" class="mb-6 hidden">
                        <h3 class="font-semibold text-gray-700 mb-2">📄 Pratinjau Data Excel</h3>
                        <div class="overflow-x-auto">
                            <table id="previewTable" class="min-w-full table-auto border border-gray-300 text-sm">
                                <thead class="bg-gray-100 text-gray-700"></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('hotel.databooking.index') }}"
                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md shadow-md">
                            {{ __('Kembali') }}
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md shadow-md">
                            {{ __('Simpan Data') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const sheetName = workbook.SheetNames[0];
                const sheet = workbook.Sheets[sheetName];
                const json = XLSX.utils.sheet_to_json(sheet, { header: 1 });

                if (json.length === 0) return;

                const thead = document.querySelector('#previewTable thead');
                const tbody = document.querySelector('#previewTable tbody');
                thead.innerHTML = '';
                tbody.innerHTML = '';

                // Header row
                const headerRow = document.createElement('tr');
                json[0].forEach(header => {
                    const th = document.createElement('th');
                    th.className = 'px-3 py-2 border';
                    th.textContent = header;
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);

                // Data rows (limit to first 5 rows)
                json.slice(1, 6).forEach(row => {
                    const tr = document.createElement('tr');
                    row.forEach(cell => {
                        const td = document.createElement('td');
                        td.className = 'px-3 py-2 border';
                        td.textContent = cell;
                        tr.appendChild(td);
                    });
                    tbody.appendChild(tr);
                });

                document.getElementById('previewContainer').classList.remove('hidden');
            };
            reader.readAsArrayBuffer(file);
        });
    </script>
</x-app-layout>
