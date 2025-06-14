<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Pesanan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-8">
                    <form action="{{ route('cashierresto.orders.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">Pelanggan</label>
                                <div class="mt-1 flex gap-2 items-center">
                                    <select name="customer_id" id="customer_id"
                                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">- Pilih Pelanggan -</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('cashierresto.customers.create') }}"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Tambah
                                    </a>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Tidak wajib diisi jika tamu anonim.</p>
                            </div>

                            <div class="space-y-1">
                                <label for="order_date" class="block text-sm font-medium text-gray-700">Tanggal Order</label>
                                <input type="date" name="order_date" id="order_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="space-y-1">
                                <label for="time_order" class="block text-sm font-medium text-gray-700">Waktu Order</label>
                                <input type="time" name="time_order" id="time_order"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="space-y-1">
                                <label for="item_name" class="block text-sm font-medium text-gray-700">Item</label>
                                <input type="text" name="item_name" id="item_name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="space-y-1">
                                <label for="item_type" class="block text-sm font-medium text-gray-700">Jenis Item</label>
                                <input type="text" name="item_type" id="item_type"
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
                                        class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        required>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" name="quantity" id="quantity"
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
                                    <option value="Cash">Cash</option>
                                    <option value="Debit">Debit</option>
                                    <option value="Credit">Credit</option>
                                    <option value="QRIS">QRIS</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label for="type_of_order" class="block text-sm font-medium text-gray-700">Tipe Pesanan</label>
                                <select name="type_of_order" id="type_of_order"
                                    class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                    <option value="">- Pilih Tipe Pesanan -</option>
                                    <option value="Dine In">Dine In</option>
                                    <option value="Take Away">Take Away</option>
                                    <option value="Delivery">Delivery</option>
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
        function updateTotal() {
            const price = parseFloat(document.getElementById('item_price').value) || 0;
            const quantity = parseInt(document.getElementById('quantity').value) || 0;
            const total = price * quantity;
            document.getElementById('transaction_amount').value = total;
        }
    
        document.getElementById('item_price').addEventListener('input', updateTotal);
        document.getElementById('quantity').addEventListener('input', updateTotal);
    </script>
</x-app-layout>
