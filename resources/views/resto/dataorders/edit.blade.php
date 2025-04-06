<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Upload File') }}
            </h2>
            <a href="{{ asset('storage/resto_orders_template.xlsx') }}"
                class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded" download>
                Download Template Excel
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Edit Data Upload</h3>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('resto.dataorders.update', $upload->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Upload File Baru
                            (Opsional)</label>
                        <input type="file" id="file" name="file" class="w-full border border-gray-300 rounded px-3 py-2"
                            accept=".xlsx">
                    </div>

                    <div class="mb-4">
                        <label for="file_name" class="block text-sm font-medium text-gray-700 mb-1">Nama File</label>
                        <input type="text" id="file_name" name="file_name"
                            value="{{ old('file_name', $upload->file_name) }}"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea id="description" name="description"
                            class="w-full border border-gray-300 rounded px-3 py-2"
                            rows="3">{{ old('description', $upload->description) }}</textarea>
                    </div>

                    <div class="text-right space-x-2">
                        <a href="{{ route('resto.dataorders.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

                <!-- Preview container -->
                <div id="previewContainer" class="mt-6 hidden">
                    <h4 class="font-semibold text-gray-700 mb-2">📄 Pratinjau Data Excel</h4>
                    <div class="overflow-x-auto">
                        <table id="previewTable" class="min-w-full table-auto border border-gray-300 text-sm">
                            <thead class="bg-gray-100 text-gray-700"></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        document.getElementById('file').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
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

                const headerRow = document.createElement('tr');
                json[0].forEach(header => {
                    const th = document.createElement('th');
                    th.className = 'px-3 py-2 border';
                    th.textContent = header;
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);

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