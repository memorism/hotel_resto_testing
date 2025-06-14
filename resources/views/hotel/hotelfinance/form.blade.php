@php
    $trx = $finance ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Transaction Date & Time Section -->
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Waktu Transaksi</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                    Transaksi</label>
                <input type="date" id="transaction_date" name="transaction_date"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    value="{{ old('transaction_date', optional($trx)->transaction_date) }}">
            </div>

            <div>
                <label for="transaction_time" class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                <input type="time" id="transaction_time" name="transaction_time"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    value="{{ old('transaction_time', optional($trx)->transaction_time) }}">
            </div>
        </div>
    </div>

    <!-- Transaction Type & Amount Section -->
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Transaksi</h3>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="transaction_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis
                    Transaksi</label>
                <select name="transaction_type" id="transaction_type"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 p-2 focus:ring-1 focus:ring-blue-500">
                    <option value="income" {{ old('transaction_type', optional($trx)->transaction_type) === 'income' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="expense" {{ old('transaction_type', optional($trx)->transaction_type) === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>

            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                    <input type="number" id="amount" name="amount" step="0.01"
                        class="w-full rounded-lg border-gray-300 pl-10 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        value="{{ old('amount', optional($trx)->amount) }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Details Section -->
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pembayaran</h3>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Metode
                    Pembayaran</label>
                <input type="text" id="payment_method" name="payment_method"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    value="{{ old('payment_method', optional($trx)->payment_method) }}"
                    placeholder="Contoh: Cash, Transfer Bank, dll">
            </div>

            <div>
                <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                    Referensi</label>
                <input type="text" id="reference_number" name="reference_number"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    value="{{ old('reference_number', optional($trx)->reference_number) }}"
                    placeholder="Masukkan nomor referensi transaksi">
            </div>
        </div>
    </div>

    <!-- Category Section -->
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kategori & Sumber</h3>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <input type="text" id="category" name="category"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    value="{{ old('category', optional($trx)->category) }}" placeholder="Masukkan kategori transaksi">
            </div>

            <div>
                <label for="subcategory" class="block text-sm font-medium text-gray-700 mb-2">Subkategori</label>
                <input type="text" id="subcategory" name="subcategory"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    value="{{ old('subcategory', optional($trx)->subcategory) }}"
                    placeholder="Masukkan subkategori (opsional)">
            </div>

            <div>
                <label for="source_or_target" class="block text-sm font-medium text-gray-700 mb-2">Sumber /
                    Tujuan</label>
                <input type="text" id="source_or_target" name="source_or_target"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    value="{{ old('source_or_target', optional($trx)->source_or_target) }}"
                    placeholder="Masukkan sumber atau tujuan transaksi">
            </div>
        </div>
    </div>

    <!-- Description Section -->
    <div class="md:col-span-2 bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Deskripsi</h3>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Transaksi</label>
            <textarea id="description" name="description" rows="4"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none"
                placeholder="Masukkan deskripsi atau catatan tambahan...">{{ old('description', optional($trx)->description) }}</textarea>
        </div>
    </div>
</div>