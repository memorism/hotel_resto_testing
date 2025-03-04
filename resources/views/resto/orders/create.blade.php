<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('resto.orders.store') }}" method="POST">
                        @csrf

                        <!-- Dropdown untuk memilih file -->
                        <div class="mb-3">
                            <label for="excel_upload_id" class="form-label">Pilih File</label>
                            <select name="excel_upload_id" id="excel_upload_id" class="form-control" required>
                                <option value="">Pilih File</option>
                                @foreach ($uploads as $upload)
                                    <option value="{{ $upload->id }}">{{ $upload->file_name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="order_date" class="form-label">Tanggal Order</label>
                            <input type="date" name="order_date" id="order_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="time_order" class="form-label">Waktu Order</label>
                            <input type="time" name="time_order" id="time_order" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item</label>
                            <input type="text" name="item_name" id="item_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="item_type" class="form-label">Jenis Item</label>
                            <input type="text" name="item_type" id="item_type" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="item_price" class="form-label">Harga</label>
                            <input type="number" name="item_price" id="item_price" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="transaction_amount" class="form-label">Total</label>
                            <input type="number" name="transaction_amount" id="transaction_amount" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="transaction_type" class="form-label">Tipe Transaksi</label>
                            <input type="text" name="transaction_type" id="transaction_type" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="received_by" class="form-label">Diterima Oleh</label>
                            <input type="text" name="received_by" id="received_by" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="type_of_order" class="form-label">Tipe Pesanan</label>
                            <input type="text" name="type_of_order" id="type_of_order" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
