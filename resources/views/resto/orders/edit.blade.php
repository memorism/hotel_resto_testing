<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Pesanan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('resto.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="file_name" class="block text-sm font-medium text-gray-700 mb-1">File yang
                                Dipilih</label>
                            <input type="text" name="file_name" id="file_name"
                                value="{{ $order->excelUpload ? $order->excelUpload->file_name : 'Tidak ada file' }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" readonly>
                        </div>

                        <div>
                            <label for="order_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                Order</label>
                            <input type="date" name="order_date" id="order_date"
                                value="{{ old('order_date', $order->order_date) }}"
                                class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="time_order" class="block text-sm font-medium text-gray-700 mb-1">Waktu
                                Order</label>
                            <input type="text" name="time_order" id="time_order"
                                value="{{ old('time_order', $order->time_order) }}" placeholder="hh:mm:ss"
                                pattern="[0-9]{2}:[0-9]{2}:[0-9]{2}" title="Format harus hh:mm:ss"
                                class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="item_name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                Item</label>
                            <input type="text" name="item_name" id="item_name"
                                value="{{ old('item_name', $order->item_name) }}"
                                class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="item_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                                Item</label>
                            <input type="text" name="item_type" id="item_type"
                                value="{{ old('item_type', $order->item_type) }}"
                                class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="item_price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                            <input type="number" name="item_price" id="item_price"
                                value="{{ old('item_price', $order->item_price) }}"
                                class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                            <input type="number" name="quantity" id="quantity"
                                value="{{ old('quantity', $order->quantity) }}"
                                class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="transaction_amount"
                                class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                            <input type="number" name="transaction_amount" id="transaction_amount"
                                value="{{ old('transaction_amount', $order->transaction_amount) }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50" required readonly>
                        </div>

                        <div>
                            <label for="transaction_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe
                                Transaksi</label>
                            <input type="text" name="transaction_type" id="transaction_type"
                                value="{{ old('transaction_type', $order->transaction_type) }}"
                                class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="received_by" class="block text-sm font-medium text-gray-700 mb-1">Diterima
                                Oleh</label>
                            <input type="text" name="received_by" id="received_by" class="form-control"
                                value="{{ old('received_by', $order->received_by) }}" required>
                        </div>

                        <div>
                            <label for="type_of_order" class="block text-sm font-medium text-gray-700 mb-1">Tipe
                                Pesanan</label>
                            <input type="text" name="type_of_order" id="type_of_order"
                                value="{{ old('type_of_order', $order->type_of_order) }}"
                                class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>
                    </div>

                    <div class="text-right space-x-2">
                        <a href="{{ url()->previous() }}"" class=" bg-gray-500 hover:bg-gray-600 text-white
                            font-semibold px-4 py-2 rounded">
                            Kembali
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const price = document.getElementById('item_price');
            const qty = document.getElementById('quantity');
            const total = document.getElementById('transaction_amount');

            function updateTotal() {
                const p = parseFloat(price.value) || 0;
                const q = parseFloat(qty.value) || 0;
                total.value = p * q;
            }

            price.addEventListener('input', updateTotal);
            qty.addEventListener('input', updateTotal);
        });
    </script>
</x-app-layout>