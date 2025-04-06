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
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('resto.orders.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="excel_upload_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih File</label>
                            <select name="excel_upload_id" id="excel_upload_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                                <option value="">Pilih File</option>
                                @foreach ($uploads as $upload)
                                    <option value="{{ $upload->id }}">{{ $upload->file_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="order_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Order</label>
                            <input type="date" name="order_date" id="order_date" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="time_order" class="block text-sm font-medium text-gray-700 mb-1">Waktu Order</label>
                            <input type="time" name="time_order" id="time_order" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="item_name" class="block text-sm font-medium text-gray-700 mb-1">Item</label>
                            <input type="text" name="item_name" id="item_name" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="item_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Item</label>
                            <input type="text" name="item_type" id="item_type" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="item_price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                            <input type="number" name="item_price" id="item_price" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="transaction_amount" class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                            <input type="number" name="transaction_amount" id="transaction_amount" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="transaction_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Transaksi</label>
                            <input type="text" name="transaction_type" id="transaction_type" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="received_by" class="block text-sm font-medium text-gray-700 mb-1">Diterima Oleh</label>
                            <input type="text" name="received_by" id="received_by" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label for="type_of_order" class="block text-sm font-medium text-gray-700 mb-1">Tipe Pesanan</label>
                            <input type="text" name="type_of_order" id="type_of_order" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>
                    </div>

                    <div class="text-right space-x-2">
                        <a href="{{ route('resto.orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
                            Kembali
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
