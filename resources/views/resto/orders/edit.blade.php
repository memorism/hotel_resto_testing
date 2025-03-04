<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('resto.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Informasi File yang Dipilih (Read-Only) -->
                        <div class="mb-3">
                            <label for="file_name" class="form-label">File yang Dipilih</label>
                            <input type="text" name="file_name" id="file_name" class="form-control"
                                value="{{ $order->excelUpload ? $order->excelUpload->file_name : 'Tidak ada file' }}"
                                readonly>
                        </div>

                        <!-- Order Date -->
                        <div class="mb-3">
                            <label for="order_date" class="form-label">Tanggal Order</label>
                            <input type="date" name="order_date" id="order_date" class="form-control"
                                value="{{ old('order_date', $order->order_date) }}" required>
                        </div>

                        <!-- Time Order -->
                        <div class="mb-3">
                            <label for="time_order" class="form-label">Waktu Order</label>
                            <input type="text" name="time_order" id="time_order" class="form-control"
                                value="{{ old('time_order', $order->time_order) }}" required placeholder="hh:mm:ss"
                                pattern="[0-9]{2}:[0-9]{2}:[0-9]{2}" title="Format harus hh:mm:ss">

                        </div>


                        <!-- Item Name -->
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Nama Item</label>
                            <input type="text" name="item_name" id="item_name" class="form-control"
                                value="{{ old('item_name', $order->item_name) }}" required>
                        </div>

                        <!-- Item Type -->
                        <div class="mb-3">
                            <label for="item_type" class="form-label">Jenis Item</label>
                            <input type="text" name="item_type" id="item_type" class="form-control"
                                value="{{ old('item_type', $order->item_type) }}" required>
                        </div>

                        <!-- Item Price -->
                        <div class="mb-3">
                            <label for="item_price" class="form-label">Harga</label>
                            <input type="number" name="item_price" id="item_price" class="form-control"
                                value="{{ old('item_price', $order->item_price) }}" required>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" class="form-control"
                                value="{{ old('quantity', $order->quantity) }}" required>
                        </div>

                        <!-- Transaction Amount -->
                        <div class="mb-3">
                            <label for="transaction_amount" class="form-label">Total</label>
                            <input type="number" name="transaction_amount" id="transaction_amount" class="form-control"
                                value="{{ old('transaction_amount', $order->transaction_amount) }}" required>
                        </div>

                        <!-- Transaction Type -->
                        <div class="mb-3">
                            <label for="transaction_type" class="form-label">Tipe Transaksi</label>
                            <input type="text" name="transaction_type" id="transaction_type" class="form-control"
                                value="{{ old('transaction_type', $order->transaction_type) }}" required>
                        </div>

                        <!-- Received By -->
                        <div class="mb-3">
                            <label for="received_by" class="form-label">Diterima Oleh</label>
                            <input type="text" name="received_by" id="received_by" class="form-control"
                                value="{{ old('received_by', $order->received_by) }}" required>
                        </div>

                        <!-- Type of Order -->
                        <div class="mb-3">
                            <label for="type_of_order" class="form-label">Tipe Pesanan</label>
                            <input type="text" name="type_of_order" id="type_of_order" class="form-control"
                                value="{{ old('type_of_order', $order->type_of_order) }}" required>
                        </div>

                        <!-- Tombol Submit dan Kembali -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>