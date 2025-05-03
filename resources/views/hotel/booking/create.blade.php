<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Tambah Data Transaksi Hotel
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('hotel.booking.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <x-form.input name="booking_id" label="ID Pemesanan" required />
                        <x-form.select name="file_name" label="Nama File" :options="$fileNames" required />

                        {{-- Pelanggan + tombol Tambah --}}
                        <div class="md:col-span-2 ">
                            <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
                            <div class="flex gap-2">
                                <select name="customer_id" id="customer_id"
                                        class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                                    @endforeach
                                </select>
                                <a href="{{ route('hotel.shared_customers.create_hotel') }}"
                                   class="px-3 py-2 bg-green-600 flex gap-2 items-center text-white text-sm rounded  hover:bg-green-700">
                                    Tambah
                                </a>
                            </div>
                            <small class="text-gray-500">Tidak wajib diisi jika tamu anonim.</small>
                        </div>



                        <x-form.input name="no_of_adults" label="Jumlah Dewasa" type="number" required />
                        <x-form.input name="no_of_children" label="Jumlah Anak-anak" type="number" required />

                        <x-form.input name="no_of_weekend_nights" label="Malam Akhir Pekan" type="number" required />
                        <x-form.input name="no_of_week_nights" label="Malam Hari Kerja" type="number" required />

                        <x-form.input name="type_of_meal_plan" label="Tipe Paket Makanan" required />
                        <x-form.select name="required_car_parking_space" label="Butuh Parkir" :options="[1 => 'Ya', 0 => 'Tidak']" required />

                        <x-form.input name="room_type_reserved" label="Tipe Kamar" required />
                        <x-form.input name="lead_time" label="Waktu Tunggu" type="number" required />

                        <x-form.input name="arrival_year" label="Tahun Kedatangan" type="number" required />
                        <x-form.input name="arrival_month" label="Bulan Kedatangan" type="number" required />
                        <x-form.input name="arrival_date" label="Tanggal Kedatangan" type="number" required />

                        <x-form.input name="market_segment_type" label="Segmen Pasar" required />
                        <x-form.select name="repeated_guest" label="Tamu Berulang" :options="[1 => 'Ya', 0 => 'Tidak']" required />

                        <x-form.input name="no_of_previous_cancellations" label="Jumlah Pembatalan Sebelumnya" type="number" required />
                        <x-form.input name="no_of_previous_bookings_not_canceled" label="Jumlah Pemesanan Sebelumnya" type="number" required />

                        <x-form.input name="avg_price_per_room" label="Harga Rata-rata Kamar" type="number" required />
                        <x-form.input name="no_of_special_requests" label="Permintaan Khusus" type="number" required />

                        <x-form.input name="booking_status" label="Status Pemesanan" required />
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('hotel.booking.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Batal
                        </a>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
