<!-- Sidebar Container -->
<div class="h-screen bg-gradient-to-b from-white to-gray-50 shadow-lg w-64 flex flex-col border-r border-gray-200">
    <!-- Logo Container -->
    <div class="px-6 py-4 flex justify-center bg-white">
        <a href="{{ Auth::user()->usertype == 'admin' ? route('admin.dashboard') : route('dashboard') }}"
            class="transition-transform duration-200 hover:scale-105">
            <img src="{{ asset('images/PHRI_LOGO.png') }}" alt="Logo PHRI" class="h-28 w-auto">
        </a>
    </div>

    <!-- Navigation Container -->
    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-8">
        @if (Auth::user()->usertype == 'admin')
            <!-- HOME Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Home</p>
                <div class="space-y-1">
                    <x-sidebar-link route="admin.dashboard" icon="fa-solid fa-house"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Dashboard
                    </x-sidebar-link>
                </div>
            </div>

            <!-- DATA Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Data</p>
                <div class="space-y-1">
                    <x-sidebar-link route="admin.okupansihotel" icon="fa-solid fa-building"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Okupansi Hotel
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.hotel" icon="fa-solid fa-wallet"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Keuangan Hotel
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.okupansiresto" icon="fa-solid fa-chart-line"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Statistik Resto
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.resto" icon="fa-solid fa-money-bill-trend-up"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Keuangan Resto
                    </x-sidebar-link>
                    <x-sidebar-link route="combined-reports.index" icon="fa-solid fa-bars"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Report Pendapatan
                    </x-sidebar-link>
                </div>
            </div>

            <!-- MANAGEMENT Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Management</p>
                <div class="space-y-1">
                    <x-sidebar-link route="admin.resto.index" icon="fa-solid fa-utensils"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Restaurant
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.hotel.index" icon="fa-solid fa-hotel"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Hotel
                    </x-sidebar-link>
                    <x-sidebar-link route="hotel-resto-links.index" icon="fa-solid fa-link"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Daftar Relasi
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.user.user" icon="fa-solid fa-users"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        User
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.shared_customers.index" icon="fa-solid fa-users-viewfinder"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Daftar Pelanggan
                    </x-sidebar-link>
                </div>
            </div>
        @endif

        @if (Auth::user()->usertype == 'hotelnew')
            <!-- Hotel Dashboard Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Dashboard</p>

                <div class="space-y-1">
                    <x-sidebar-link route="hotel.okupansi" icon="fa-solid fa-chart-area"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Okupansi Hotel
                    </x-sidebar-link>
                    <x-sidebar-link route="hotel.dashboard" icon="fa-solid fa-building"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Keuangan Hotel
                    </x-sidebar-link>

                </div>
            </div>

            <!-- Hotel Customer Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Customer</p>
                <div class="space-y-1">
                    <x-sidebar-link route="hotel.booking.index" icon="fa-solid fa-list-check"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Data Booking
                    </x-sidebar-link>
                    {{-- <x-sidebar-link route="hotel.databooking.index" icon="fa-solid fa-folder-open">Unggah
                        Booking</x-sidebar-link> --}}
                    <x-sidebar-link route="hotel.shared_customers.index" icon="fa-solid fa-users"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Daftar Pelanggan
                    </x-sidebar-link>
                </div>
            </div>

            <!-- Hotel Finance Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Finance</p>
                <div class="space-y-1">
                    <x-sidebar-link route="hotel.finance.index" icon="fa-solid fa-file-invoice"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Data Transaksi
                    </x-sidebar-link>
                </div>
            </div>

            <!-- Hotel Inventori Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Inventori</p>
                <div class="space-y-1">
                    {{-- <x-sidebar-link route="hotel.scm.index" icon="fa-solid fa-boxes-stacked"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Inventori
                    </x-sidebar-link> --}}
                    <x-sidebar-link route="hotel.rooms.index" icon="fa-solid fa-bed"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Manajemen Kamar
                    </x-sidebar-link>
                </div>
            </div>
        @endif

        @if (Auth::user()->usertype == 'restonew')
            <!-- Restaurant Dashboard Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Dashboard</p>
                <div class="space-y-1">
                    <x-sidebar-link route="resto.okupansi" icon="fa-solid fa-chart-bar"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Statistik Resto
                    </x-sidebar-link>
                    <x-sidebar-link route="resto.dashboard" icon="fa-solid fa-chart-pie"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Keuangan Resto
                    </x-sidebar-link>
                </div>
            </div>

            <!-- Restaurant Customer Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Customer</p>
                <div class="space-y-1">
                    <x-sidebar-link route="resto.orders.index" icon="fa-solid fa-receipt"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Data Order
                    </x-sidebar-link>
                    <x-sidebar-link route="resto.shared_customers.index_resto" icon="fa-solid fa-bed"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Daftar Pelanggan
                    </x-sidebar-link>
                </div>
            </div>

            <!-- Restaurant Finance Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Finance</p>
                <div class="space-y-1">
                    <x-sidebar-link route="resto.finances.index" icon="fa-solid fa-money-bill-wave"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Keuangan Resto
                    </x-sidebar-link>
                </div>
            </div>

            <!-- Restaurant Inventori Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Inventori</p>
                <div class="space-y-1">
                    {{-- <x-sidebar-link route="resto.supplies.index" icon="fa-solid fa-boxes-stacked"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Inventori
                    </x-sidebar-link> --}}
                    <x-sidebar-link route="resto.tables.index" icon="fa-solid fa-utensils"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Meja
                    </x-sidebar-link>
                </div>
            </div>
        @endif

        @if (Auth::user()->usertype == 'frontofficehotel')
            <!-- Front Office Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Front Office</p>
                <div class="space-y-1">
                    <x-sidebar-link route="hotel.frontoffice.booking.index" icon="fa-solid fa-file-invoice-dollar"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Data Booking
                    </x-sidebar-link>
                    <x-sidebar-link route="hotel.frontoffice.shared_customers.index_hotel"
                        icon="fa-solid fa-users-viewfinder"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Daftar Pelanggan
                    </x-sidebar-link>

                    <x-sidebar-link route="hotel.frontoffice.migrasi.index" icon="fa-solid fa-database"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Migrasi
                    </x-sidebar-link>

                </div>
            </div>
        @endif

        @if (Auth::user()->usertype == 'financehotel')
            <!-- Hotel Finance Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Finance</p>
                <div class="space-y-1">
                    <x-sidebar-link route="finance.index" icon="fa-solid fa-file-invoice"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Data Transaksi
                    </x-sidebar-link>

                    <x-sidebar-link route="finance.migrasi.index" icon="fa-solid fa-database"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Migrasi
                    </x-sidebar-link>
                </div>
            </div>
        @endif

        @if (Auth::user()->usertype == 'scmhotel')
            <!-- Hotel SCM Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Supply Chain</p>
                <div class="space-y-1">
                    <x-sidebar-link route="scm.supplies.index" icon="fa-solid fa-boxes-stacked"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Inventori
                    </x-sidebar-link>
                    <x-sidebar-link route="scm.transactions.index" icon="fa-solid fa-right-left"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Transaksi SCM
                    </x-sidebar-link>
                    <x-sidebar-link route="scm.rooms.index" icon="fa-solid fa-bed"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Manajemen Kamar
                    </x-sidebar-link>

                </div>

            </div>

        @endif
        @if (Auth::user()->usertype == 'cashierresto')
            <!-- Restaurant Cashier Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Cashier</p>
                <div class="space-y-1">
                    <x-sidebar-link route="cashierresto.orders.index" icon="fa-solid fa-file-invoice-dollar"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Data Order
                    </x-sidebar-link>
                    <x-sidebar-link route="cashierresto.customers.index" icon="fa-solid fa-users-viewfinder"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Daftar Pelanggan
                    </x-sidebar-link>

                    <x-sidebar-link route="cashierresto.resto.orders.history" icon="fa-solid fa-database"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Migrasi
                    </x-sidebar-link>

                </div>
            </div>
        @endif

        @if (Auth::user()->usertype == 'financeresto')
            <!-- Restaurant Finance Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Finance</p>
                <div class="space-y-1">
                    <x-sidebar-link route="financeresto.finances.index" icon="fa-solid fa-file-invoice"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Data Transaksi
                    </x-sidebar-link>
                    <x-sidebar-link route="financeresto.import.history" icon="fa-solid fa-database"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Migrasi
                    </x-sidebar-link>
                </div>
            </div>
        @endif

        @if (Auth::user()->usertype == 'scmresto')
            <!-- Restaurant SCM Section -->
            <div class="space-y-2">
                <p class="text-xs font-semibold text-gray-400 tracking-wider uppercase pl-3">Supply Chain</p>
                <div class="space-y-1">
                    <x-sidebar-link route="scmresto.supplies.index" icon="fa-solid fa-boxes-stacked"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Inventori
                    </x-sidebar-link>
                    <x-sidebar-link route="scmresto.transactions.index" icon="fa-solid fa-right-left"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Transaksi SCM
                    </x-sidebar-link>
                    <x-sidebar-link route="scmresto.tables.index" icon="fa-solid fa-utensils"
                        class="transition-all duration-200 hover:bg-blue-50 hover:text-blue-600">
                        Meja
                    </x-sidebar-link>
                </div>
            </div>
        @endif
    </nav>
</div>