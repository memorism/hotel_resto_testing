@php
    $trx = $finance ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block font-medium">Tanggal Transaksi</label>
        <input type="date" name="transaction_date" class="w-full border rounded px-2 py-1"
            value="{{ old('transaction_date', optional($trx)->transaction_date) }}">
    </div>
    <div>
        <label class="block font-medium">Waktu</label>
        <input type="time" name="transaction_time" class="w-full border rounded px-2 py-1"
            value="{{ old('transaction_time', optional($trx)->transaction_time) }}">
    </div>
    <div>
        <label class="block font-medium">Jenis Transaksi</label>
        <select name="transaction_type" class="w-full border rounded px-2 py-1">
            <option value="income" {{ old('transaction_type', optional($trx)->transaction_type) === 'income' ? 'selected' : '' }}>Pemasukan</option>
            <option value="expense" {{ old('transaction_type', optional($trx)->transaction_type) === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
        </select>
    </div>
    <div>
        <label class="block font-medium">Jumlah</label>
        <input type="number" step="0.01" name="amount" class="w-full border rounded px-2 py-1"
            value="{{ old('amount', optional($trx)->amount) }}">
    </div>
    <div>
        <label class="block font-medium">Metode Pembayaran</label>
        <input type="text" name="payment_method" class="w-full border rounded px-2 py-1"
            value="{{ old('payment_method', optional($trx)->payment_method) }}">
    </div>
    <div>
        <label class="block font-medium">Kategori</label>
        <input type="text" name="category" class="w-full border rounded px-2 py-1"
            value="{{ old('category', optional($trx)->category) }}">
    </div>
    <div>
        <label class="block font-medium">Subkategori</label>
        <input type="text" name="subcategory" class="w-full border rounded px-2 py-1"
            value="{{ old('subcategory', optional($trx)->subcategory) }}">
    </div>
    <div>
        <label class="block font-medium">Sumber / Tujuan</label>
        <input type="text" name="source_or_target" class="w-full border rounded px-2 py-1"
            value="{{ old('source_or_target', optional($trx)->source_or_target) }}">
    </div>
    <div class="md:col-span-2">
        <label class="block font-medium">Nomor Referensi</label>
        <input type="text" name="reference_number" class="w-full border rounded px-2 py-1"
            value="{{ old('reference_number', optional($trx)->reference_number) }}">
    </div>
    <div class="md:col-span-2">
        <label class="block font-medium">Deskripsi</label>
        <textarea name="description" rows="3"
            class="w-full border rounded px-2 py-1">{{ old('description', optional($trx)->description) }}</textarea>
    </div>
</div>