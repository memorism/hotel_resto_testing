<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Tambah Data Transaksi Hotel') }}
            </h2>
            {{-- <a href="{{ route('hotel.booking.index') }}" 
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a> --}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <form action="{{ route('hotel.booking.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Selection Section -->
                            <div class="md:col-span-2 bg-gray-50 rounded-xl p-6 border border-gray-200 mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pelanggan</h3>
                                <div class="flex gap-3 items-start">
                                    <div class="flex-1">
                                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Pelanggan</label>
                                        <select name="customer_id" id="customer_id"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="">- Pilih Pelanggan -</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                                            @endforeach
                                        </select>
                                        <p class="mt-1 text-sm text-gray-500">Tidak wajib diisi jika tamu anonim.</p>
                                    </div>
                                    <div class="pt-8">
                                        <a href="{{ route('hotel.shared_customers.create') }}"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Tambah Pelanggan
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Guest Information Section -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Tamu</h3>
                                <x-form.input name="no_of_adults" label="Jumlah Dewasa" type="number" required />
                                <x-form.input name="no_of_children" label="Jumlah Anak-anak" type="number" required />
                                <x-form.input name="no_of_weekend_nights" label="Malam Akhir Pekan" type="number" required />
                                <x-form.input name="no_of_week_nights" label="Malam Hari Kerja" type="number" required />
                            </div>

                            <!-- Room & Services Section -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Kamar & Layanan</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Kamar</label>
                                        <select name="room_type_reserved" id="room_type_reserved"
                                            class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="">Pilih Tipe Kamar</option>
                                            @foreach($hotelRooms as $hotelRoom)
                                                <option value="{{ $hotelRoom->id }}">{{ $hotelRoom->room_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-form.select name="type_of_meal_plan" label="Sarapan" 
                                        :options="['breakfast' => 'Sarapan', 'Not_breakfast' => 'Tidak Sarapan']" required />
                                    <x-form.select name="required_car_parking_space" label="Butuh Parkir" 
                                        :options="[1 => 'Ya', 0 => 'Tidak']" required />
                                </div>
                            </div>

                            <!-- Booking Details Section -->
                            <div class="md:col-span-2 bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pemesanan</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-form.input name="lead_time" label="Waktu Tunggu (hari)" type="number" required />
                                    <x-form.input name="arrival_date_full" label="Tanggal Kedatangan" type="date" required />
                                    <x-form.input name="market_segment_type" label="Segmen Pasar" required />
                                    <x-form.input name="avg_price_per_room" label="Harga Rata-rata Kamar" type="number" required />
                                    <x-form.input name="no_of_special_requests" label="Jumlah Permintaan Khusus" type="number" required />
                                    <x-form.select name="booking_status" label="Status Pemesanan" 
                                        :options="['Canceled' => 'Batalkan', 'Not_Canceled' => 'Tidak dibatalkan']" required />
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-4">
                            <a href="{{ route('hotel.booking.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
