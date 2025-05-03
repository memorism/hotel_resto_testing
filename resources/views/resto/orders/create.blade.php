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
                <form action="{{ route('resto.orders.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- <div>
                            <label for="excel_upload_id" class="block text-sm font-medium text-gray-700">Pilih
                                File</label>
                            <select name="excel_upload_id" id="excel_upload_id"
                                class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                                <option value="">Pilih File</option>
                                @foreach ($uploads as $upload)
                                    <option value="{{ $upload->id }}">{{ $upload->file_name }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pelanggan</label>
                            <div class="mt-1 flex gap-2 items-center">
                                <select name="customer_id" id="customer_id"
                                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300">
                                    <option value="">- Pilih Pelanggan -</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                <a href="{{ route('resto.shared_customers.create_resto') }}"
                                    class="px-3 py-2 text-sm bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Tambah
                                </a>
                            </div>
                            <small class="text-gray-500">Tidak wajib diisi jika tamu anonim.</small>
                        </div>

                        <div>
                            <label for="order_date" class="block text-sm font-medium text-gray-700">Tanggal
                                Order</label>
                            <input type="date" name="order_date" id="order_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                        </div>

                        <div>
                            <label for="time_order" class="block text-sm font-medium text-gray-700">Waktu Order</label>
                            <input type="time" name="time_order" id="time_order"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                        </div>

                        <div>
                            <label for="item_name" class="block text-sm font-medium text-gray-700">Item</label>
                            <input type="text" name="item_name" id="item_name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                        </div>

                        <div>
                            <label for="item_type" class="block text-sm font-medium text-gray-700">Jenis Item</label>
                            <input type="text" name="item_type" id="item_type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                        </div>

                        <div>
                            <label for="item_price" class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" name="item_price" id="item_price"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                        </div>

                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="quantity" id="quantity"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                        </div>

                        <div>
                            <label for="transaction_amount"
                                class="block text-sm font-medium text-gray-700">Total</label>
                            <input type="number" name="transaction_amount" id="transaction_amount"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                        </div>

                        <div>
                            <label for="transaction_type" class="block text-sm font-medium text-gray-700">Tipe
                                Transaksi</label>
                            <input type="text" name="transaction_type" id="transaction_type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                        </div>

                        <div>
                            <label for="received_by" class="block text-sm font-medium text-gray-700">Diterima
                                Oleh</label>
                            <input type="text" name="received_by" id="received_by"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                        </div>

                        <div>
                            <label for="type_of_order" class="block text-sm font-medium text-gray-700">Tipe
                                Pesanan</label>
                            <input type="text" name="type_of_order" id="type_of_order"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-300"
                                required>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-2">
                        <a href="{{ route('resto.orders.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-md">
                            Kembali
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>