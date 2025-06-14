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
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-8">
                    <form action="{{ route('cashierresto.orders.update', $order->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label for="customer_id" class="block text-sm font-medium text-gray-700">Pelanggan</label>
                                <select name="customer_id" id="customer_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} - {{ $customer->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Tidak wajib diisi jika tamu anonim.</p>
                            </div>

                            <div class="space-y-1">
                                <label for="order_date" class="block text-sm font-medium text-gray-700">Tanggal Order</label>
                                <input type="date" name="order_date" id="order_date"
                                    value="{{ old('order_date', $order->order_date) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="space-y-1">
                                <label for="time_order" class="block text-sm font-medium text-gray-700">Waktu Order</label>
                                <input type="time" name="time_order" id="time_order"
                                    value="{{ old('time_order', $order->time_order) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="space-y-1">
                                <label for="item_name" class="block text-sm font-medium text-gray-700">Item</label>
                                <input type="text" name="item_name" id="item_name"
                                    value="{{ old('item_name', $order->item_name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="space-y-1">
                                <label for="item_type" class="block text-sm font-medium text-gray-700">Jenis Item</label>
                                <input type="text" name="item_type" id="item_type"
                                    value="{{ old('item_type', $order->item_type) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="space-y-1">
                                <label for="item_price" class="block text-sm font-medium text-gray-700">Harga</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="item_price" id="item_price"
                                        value="{{ old('item_price', $order->item_price) }}"
                                        class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        required>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" name="quantity" id="quantity"
                                    value="{{ old('quantity', $order->quantity) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="space-y-1">
                                <label for="transaction_amount" class="block text-sm font-medium text-gray-700">Total</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="transaction_amount" id="transaction_amount"
                                        value="{{ old('transaction_amount', $order->transaction_amount) }}"
                                        class="pl-12 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        readonly>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="transaction_type" class="block text-sm font-medium text-gray-700">Tipe Transaksi</label>
                                <select name="transaction_type" id="transaction_type"
                                    class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                    <option value="">- Pilih Tipe Transaksi -</option>
                                    <option value="Cash" {{ $order->transaction_type == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Debit" {{ $order->transaction_type == 'Debit' ? 'selected' : '' }}>Debit</option>
                                    <option value="Credit" {{ $order->transaction_type == 'Credit' ? 'selected' : '' }}>Credit</option>
                                    <option value="QRIS" {{ $order->transaction_type == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label for="type_of_order" class="block text-sm font-medium text-gray-700">Tipe Pesanan</label>
                                <select name="type_of_order" id="type_of_order"
                                    class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                    <option value="">- Pilih Tipe Pesanan -</option>
                                    <option value="Dine In" {{ $order->type_of_order == 'Dine In' ? 'selected' : '' }}>Dine In</option>
                                    <option value="Take Away" {{ $order->type_of_order == 'Take Away' ? 'selected' : '' }}>Take Away</option>
                                    <option value="Delivery" {{ $order->type_of_order == 'Delivery' ? 'selected' : '' }}>Delivery</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-5 flex justify-end space-x-3">
                            <a href="{{ route('cashierresto.orders.index') }}"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Kembali
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
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
