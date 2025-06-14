<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Tambah Data Transaksi Hotel') }}
            </h2>
            {{-- <a href="{{ route('hotel.frontoffice.booking.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a> --}}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6">
                    <form action="{{ route('hotel.frontoffice.booking.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Selection -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
                                <div class="flex gap-2 items-center">
                                    <select name="customer_id" id="customer_id"
                                        class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        <option value="">- Pilih Pelanggan -</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('hotel.frontoffice.shared_customers.create_hotel') }}"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Tambah
                                    </a>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Tidak wajib diisi jika tamu anonim.</p>
                            </div>

                            <!-- Guest Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Tamu</h3>
                                <x-form.input name="no_of_adults" label="Jumlah Dewasa" type="number" required />
                                <x-form.input name="no_of_children" label="Jumlah Anak-anak" type="number" required />
                                <x-form.input name="no_of_weekend_nights" label="Malam Akhir Pekan" type="number" required />
                                <x-form.input name="no_of_week_nights" label="Malam Hari Kerja" type="number" required />
                            </div>

                            <!-- Room and Services -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Kamar & Layanan</h3>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Kamar</label>
                                    <select name="room_type_reserved" id="room_type_reserved"
                                        class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out">
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

                            <!-- Booking Details -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Detail Pemesanan</h3>
                                <x-form.input name="lead_time" label="Waktu Tunggu (Hari)" type="number" required />
                                <x-form.input name="arrival_date_full" label="Tanggal Kedatangan" type="date" required />
                                <x-form.input name="market_segment_type" label="Segmen Pasar" required />
                            </div>

                            <!-- Price and Status -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Harga & Status</h3>
                                <div>
                                    <label for="avg_price_per_room" class="block text-sm font-medium text-gray-700 mb-1">Harga Rata-rata Kamar</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                                        <input type="number" name="avg_price_per_room" id="avg_price_per_room" required
                                            class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    </div>
                                </div>
                                <x-form.input name="no_of_special_requests" label="Jumlah Permintaan Khusus" type="number" required />
                                <x-form.select name="booking_status" label="Status Pemesanan" 
                                    :options="['Canceled' => 'Batalkan', 'Not_Canceled' => 'Tidak dibatalkan']" required />
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('hotel.frontoffice.booking.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
