@php
    $trx = $finance ?? null;
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label for="transaction_date" class="block text-sm font-medium text-gray-700">Tanggal Transaksi</label>
            <input type="date" id="transaction_date" name="transaction_date"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2"
                value="{{ old('transaction_date', optional($trx)->transaction_date) }}">
        </div>

        <div class="space-y-2">
            <label for="transaction_time" class="block text-sm font-medium text-gray-700">Waktu</label>
            <input type="time" id="transaction_time" name="transaction_time"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2"
                value="{{ old('transaction_time', optional($trx)->transaction_time) }}">
        </div>

        <div class="space-y-2">
            <label for="transaction_type" class="block text-sm font-medium text-gray-700">Jenis Transaksi</label>
            <select name="transaction_type" id="transaction_type"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2">
                <option value="income" {{ old('transaction_type', optional($trx)->transaction_type) === 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ old('transaction_type', optional($trx)->transaction_type) === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>

        <div class="space-y-2">
            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
            <div class="relative rounded-lg shadow-sm">
                {{-- <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 sm:text-sm">Rp</span>
                </div> --}}
                <input type="number" id="amount" name="amount" step="0.01"
                    class="w-full rounded-lg border-gray-300 pl-12 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2"
                    value="{{ old('amount', optional($trx)->amount) }}"
                    placeholder="Rp">
            </div>
        </div>

        <div class="space-y-2">
            <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
            <input type="text" id="payment_method" name="payment_method"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2"
                value="{{ old('payment_method', optional($trx)->payment_method) }}"
                placeholder="Contoh: Cash, Transfer Bank, dll">
        </div>

        <div class="space-y-2">
            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
            <input type="text" id="category" name="category"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2"
                value="{{ old('category', optional($trx)->category) }}"
                placeholder="Contoh: Penjualan, Operasional, dll">
        </div>

        <div class="space-y-2">
            <label for="subcategory" class="block text-sm font-medium text-gray-700">Subkategori</label>
            <input type="text" id="subcategory" name="subcategory"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2"
                value="{{ old('subcategory', optional($trx)->subcategory) }}" placeholder="Contoh: Kamar, Makanan, dll">
        </div>

        <div class="space-y-2">
            <label for="source_or_target" class="block text-sm font-medium text-gray-700">Sumber / Tujuan</label>
            <input type="text" id="source_or_target" name="source_or_target"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2"
                value="{{ old('source_or_target', optional($trx)->source_or_target) }}"
                placeholder="Contoh: Nama Customer, Supplier, dll">
        </div>

        <div class="md:col-span-2 space-y-2">
            <label for="reference_number" class="block text-sm font-medium text-gray-700">Nomor Referensi</label>
            <input type="text" id="reference_number" name="reference_number"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2"
                value="{{ old('reference_number', optional($trx)->reference_number) }}"
                placeholder="Nomor invoice, kwitansi, atau referensi lainnya">
        </div>

        <div class="md:col-span-2 space-y-2">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="description" name="description" rows="3"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 p-2"
                placeholder="Tambahkan keterangan detail transaksi di sini...">{{ old('description', optional($trx)->description) }}</textarea>
        </div>
    </div>
</div>