<x-app-layout>
    {{-- header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Data Transaksi Keseluruhan') }}
            </h2>
            <a href="{{ route('hotel.booking.create') }}" class="btn btn-primary">
                Tambah Data
            </a>
        </div>
    </x-slot>

    {{-- isi --}}
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <div class="min-w-full align-middle">
                        {{-- Filter dan Pencarian --}}
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center">
                                <label for="perPage" class="mr-2">Tampilkan</label>
                                <select id="perPage" class="form-select form-select-sm"
                                    onchange="window.location.href=this.value">
                                    <option value="{{ route('hotel.booking.booking', ['perPage' => 10]) }}" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="{{ route('hotel.booking.booking', ['perPage' => 20]) }}" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="{{ route('hotel.booking.booking', ['perPage' => 'semua']) }}" {{ request('perPage') == 'semua' ? 'selected' : '' }}>Semua</option>
                                </select>
                                <label for="perPage" class="ml-2">data</label>
                            </div>

                            {{-- Pencarian --}}
                            <div class="flex items-center">
                                <form action="{{ route('hotel.booking.booking') }}" method="GET">
                                    <input type="text" name="search" id="search" class="form-input form-input-sm"
                                        placeholder="Mencari Berdasarkan Id Booking" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary btn-sm ml-2">Cari</button>
                                </form>
                            </div>
                        </div>

                        {{-- Tabel --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full border divide-y divide-gray-200 table-auto">
                                <!-- Header -->
                                <thead class="bg-gray-50 sticky top-0 z-10">
                                    <tr>
                                            @foreach(['No', 'Nama File', 'ID Pemesanan', 'Jumlah Dewasa', 'Jumlah Anak-anak', 
                                                      'Malam Akhir Pekan', 'Malam Hari Kerja', 'Tipe Paket Makanan', 'Butuh Parkir', 
                                                      'Tipe Kamar', 'Waktu Tunggu', 'Tahun Kedatangan', 'Bulan Kedatangan', 
                                                      'Tanggal Kedatangan', 'Segmen Pasar', 'Tamu Berulang', 'Pembatalan Sebelumnya', 
                                                      'Pemesanan Sebelumnya', 'Harga Rata-rata', 'Permintaan Khusus', 'Status Pemesanan', 
                                                      'Aksi'] as $index => $header)
                                        
                                                <th class="text-center px-4 py-2 cursor-pointer 
                                                    {{ $header == 'Aksi'  ? 'sticky-action' : '' }}"

                                                    onclick="sortTable({{ $index }})">
                                        
                                                    <div class="filter-container">
                                                        <span>{{ $header }}</span>
                                                    </div>
                                                </th>
                                            @endforeach
                                    </tr>
                                </thead>

                                <!-- Body -->
                                <tbody id="tableBody">
                                    @foreach ($bookings as $index => $booking)
                                        <tr>
                                            <td class="text-center px-4 py-2">{{ $index + 1 }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->uploadOrder->file_name }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->booking_id }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_adults }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_children }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_weekend_nights }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_week_nights }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->type_of_meal_plan }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->required_car_parking_space }}
                                            </td>
                                            <td class="text-center px-4 py-2">{{ $booking->room_type_reserved }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->lead_time }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->arrival_year }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->arrival_month }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->arrival_date }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->market_segment_type }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->repeated_guest }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_previous_cancellations }}
                                            </td>
                                            <td class="text-center px-4 py-2">
                                                {{ $booking->no_of_previous_bookings_not_canceled }}
                                            </td>
                                            <td class="text-center px-4 py-2">{{ $booking->avg_price_per_room }}</td>
                                            <td class="text-center px-4 py-2">{{ $booking->no_of_special_requests }}</td>
                                            <td class="text-center px-4 py-2">
                                                @if($booking->booking_status == 'Canceled')
                                                    <span class="px-2 py-1 bg-red-500 text-white rounded-md">Dibatalkan</span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 bg-green-500 text-white rounded-md">Dikonfirmasi</span>
                                                @endif
                                            </td>
                                            <td class="text-center px-4 py-2 sticky right-0 bg-white">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('hotel.booking.edit', $booking->id) }}"
                                                        class="px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-md hover:bg-yellow-600">
                                                        Ubah
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('hotel.booking.destroy', $booking->id) }}"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination Links --}}
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Script untuk Filter dan Sorting -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let table = document.getElementById("tableBody");
        let rows = Array.from(table.rows);
        let headers = document.querySelectorAll("th");

        headers.forEach((header, index) => {
            if (!header.classList.contains("sticky-action")) { // Hindari filter di kolom "Aksi"
                let filterContainer = document.createElement("div");
                filterContainer.classList.add("filter-container");

                let filterText = document.createElement("span");
                filterText.textContent = header.textContent.trim();

                let filterBtn = document.createElement("button");
                filterBtn.innerHTML = "▼";
                filterBtn.classList.add("filter-btn");
                filterBtn.onclick = function (event) {
                    event.stopPropagation();
                    toggleDropdown(index, filterBtn);
                };

                // Gabungkan teks dan tombol "▼" dalam satu container agar tetap sejajar
                filterContainer.appendChild(filterText);
                filterContainer.appendChild(filterBtn);
                header.innerHTML = "";
                header.appendChild(filterContainer);

                // Buat dropdown filter
                let dropdown = document.createElement("div");
                dropdown.classList.add("filter-dropdown");
                dropdown.style.display = "none";
                filterContainer.appendChild(dropdown); // Tetap dalam konteks filter-container agar sejajar

                // Ambil nilai unik dari kolom ini
                let values = new Set();
                rows.forEach(row => {
                    let cell = row.cells[index];
                    if (cell) values.add(cell.textContent.trim());
                });

                values.forEach(value => {
                    let option = document.createElement("div");
                    option.classList.add("filter-option");
                    option.textContent = value;
                    option.onclick = function () {
                        applyFilter(index, value);
                    };
                    dropdown.appendChild(option);
                });

                // Tambahkan opsi "Hapus Filter"
                let resetOption = document.createElement("div");
                resetOption.classList.add("filter-option", "filter-reset");
                resetOption.textContent = "Hapus Filter";
                resetOption.onclick = function () {
                    resetFilter(index);
                };
                dropdown.appendChild(resetOption);
            }
        });

        function toggleDropdown(index, button) {
            let allDropdowns = document.querySelectorAll(".filter-dropdown");
            let allButtons = document.querySelectorAll(".filter-btn");

            allDropdowns.forEach((dropdown, i) => {
                if (i === index) {
                    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
                    button.classList.toggle("active-btn");
                } else {
                    dropdown.style.display = "none";
                    allButtons[i].classList.remove("active-btn");
                }
            });
        }

        function applyFilter(column, value) {
            rows.forEach(row => {
                let cell = row.cells[column];
                row.style.display = (cell && cell.textContent.trim() === value) ? "" : "none";
            });
        }

        function resetFilter(column) {
            rows.forEach(row => row.style.display = "");
        }

        function sortTable(column) {
            let ascending = table.getAttribute("data-sort") !== "asc";
            table.setAttribute("data-sort", ascending ? "asc" : "desc");

            rows.sort((rowA, rowB) => {
                let cellA = rowA.cells[column].textContent.trim().toLowerCase();
                let cellB = rowB.cells[column].textContent.trim().toLowerCase();

                if (!isNaN(cellA) && !isNaN(cellB)) {
                    return ascending ? cellA - cellB : cellB - cellA;
                }

                return ascending ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
            });

            rows.forEach(row => table.appendChild(row));
        }

        document.addEventListener("click", function () {
            document.querySelectorAll(".filter-dropdown").forEach(dropdown => dropdown.style.display = "none");
            document.querySelectorAll(".filter-btn").forEach(btn => btn.classList.remove("active-btn"));
        });
    });

</script>

<!-- CSS untuk Styling Dropdown yang Lebih Cantik -->
<style>
    /* Header dan tombol filter dalam satu baris */
    .filter-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 5px;
        position: relative;
        /* Penting agar dropdown tetap dalam konteks header */
        width: 100%;
        white-space: nowrap;
    }

    /* Tombol filter ▼ */
    .filter-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        color: #444;
        transition: transform 0.2s ease-in-out;
        padding: 0;
        margin-left: 5px;
    }

    /* Efek saat tombol aktif */
    .filter-btn.active-btn {
        transform: rotate(180deg);
        color: #007bff;
    }

    /* Dropdown filter */
    .filter-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        /* Sesuaikan lebar dropdown dengan header */
        background: white;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        padding: 5px;
        font-size: 14px;
    }

    /* Pilihan dalam dropdown */
    .filter-option {
        padding: 8px;
        cursor: pointer;
        font-size: 14px;
        border-radius: 4px;
        transition: background 0.2s;
        text-align: center;
    }

    .filter-option:hover {
        background: #f0f0f0;
    }

    /* Opsi Hapus Filter */
    .filter-reset {
        background: #ffdddd;
        font-weight: bold;
        text-align: center;
        margin-top: 5px;
    }

    .filter-reset:hover {
        background: #ffaaaa;
    }

    /* Sticky Header untuk Kolom "Aksi" */
    th.sticky-action {
        position: sticky;
        right: 0;
        background: white;
        z-index: 10;
        box-shadow: -3px 0 5px rgba(0, 0, 0, 0.1);
    }

    /* Sticky Body untuk Kolom "Aksi" */
    td.sticky-action {
        position: sticky;
        right: 0;
        background: white;
        z-index: 9;
        box-shadow: -3px 0 5px rgba(0, 0, 0, 0.1);
    }
</style>