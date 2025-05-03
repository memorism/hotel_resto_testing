<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Edit Data') }}
            </h2>
            <a class="invisible btn btn-primary">test</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('hotel.databooking.update', $uploadOrder->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Upload File Baru -->
                    <div class="mb-4">
                        <label for="file" class="block font-medium text-sm text-gray-700 mb-1">Upload File Baru
                            (Opsional)</label>
                        <input type="file" name="file" id="file"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('file') border-red-500 focus:ring-red-200 @else  @enderror">
                        <p class="text-sm text-gray-500 mt-1">Jika Anda mengunggah file baru, data booking lama akan
                            dihapus dan diimport ulang.</p>
                        @error('file')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama File -->
                    <div class="mb-4">
                        <label for="file_name" class="block font-medium text-sm text-gray-700 mb-1">Nama File</label>
                        <input type="text" name="file_name" id="file_name"
                            @class([
                                'w-full px-3 py-2 rounded focus:outline-none focus:ring',
                                'border-gray-300 focus:ring-blue-200' => !$errors->has('file_name'),
                                'border-red-500 focus:ring-red-200' => $errors->has('file_name'),
                            ])
                            value="{{ old('file_name', $uploadOrder->file_name) }}" required>
                        @error('file_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="block font-medium text-sm text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="3"
                            @class([
                                'w-full px-3 py-2 rounded focus:outline-none focus:ring',
                                'border-gray-300 focus:ring-blue-200' => !$errors->has('description'),
                                'border-red-500 focus:ring-red-200' => $errors->has('description'),
                            ])
                            required>{{ old('description', $uploadOrder->description) }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pratinjau Excel (dynamic via JS) -->
                    <div id="previewContainer" class="mt-6 hidden">
                        <h4 class="font-semibold text-gray-700 mb-2">📄 Pratinjau Data Excel</h4>
                        <div class="overflow-x-auto">
                            <table id="previewTable" class="min-w-full table-auto border border-gray-300 text-sm">
                                <thead class="bg-gray-100 text-gray-700"></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="text-right space-x-2 mt-6">
                        <a href="{{ route('hotel.databooking.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

                <!-- Pratinjau dari Session (jika ada) -->
                @if(session('preview'))
                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-700 mb-2">📄 Pratinjau Data Excel</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto border border-gray-300 text-sm">
                                <thead class="bg-gray-100 text-gray-700">
                                    <tr>
                                        @foreach (session('preview')[0] as $key => $value)
                                            <th class="px-3 py-2 border">{{ $key }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (session('preview') as $row)
                                        <tr>
                                            @foreach ($row as $cell)
                                                <td class="px-3 py-2 border">{{ $cell }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        document.getElementById('file')?.addEventListener('change', function (e) {
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
                    th.className = 'px-3 py-2 border text-left';
                    th.textContent = header;
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);

                json.slice(1, 6).forEach(row => {
                    const tr = document.createElement('tr');
                    row.forEach(cell => {
                        const td = document.createElement('td');
                        td.className = 'px-3 py-2 border';
                        td.textContent = cell ?? '';
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