<div class="h-screen bg-white shadow-md w-64 flex flex-col">
    {{-- Logo --}}
    <div class="px-6 py-4 flex justify-center">
        <a href="{{ Auth::user()->usertype == 'admin' ? route('admin.dashboard') : route('dashboard') }}"
            class="text-xl font-bold text-indigo-600 tracking-wide">
            {{ config('app.name', 'Dashboard') }}
        </a>
    </div>

    {{-- Sidebar Links --}}
    <nav class="flex-1 overflow-y-auto px-4 py-4 text-sm text-gray-700 space-y-6">

        @if (Auth::user()->usertype == 'admin')
            {{-- HOME --}}
            <div class="space-y-2">
                <p class="text-xs text-gray-500 tracking-widest uppercase mb-2">Home</p>
                <x-sidebar-link route="admin.dashboard" icon="fa-solid fa-house">Dashboard</x-sidebar-link>
            </div>

            {{-- DATA --}}
            <div class="space-y-2">
                <p class="text-xs text-gray-500 tracking-widest uppercase mb-2">Data</p>
                <x-sidebar-link route="admin.okupansiresto" icon="fa-solid fa-chart-line">Statistik Resto</x-sidebar-link>
                <x-sidebar-link route="admin.okupansihotel" icon="fa-solid fa-building">Statistik Hotel</x-sidebar-link>
                <x-sidebar-link route="admin.resto" icon="fa-solid fa-money-bill-trend-up">Keuangan Resto</x-sidebar-link>
                <x-sidebar-link route="admin.hotel" icon="fa-solid fa-wallet">Keuangan Hotel</x-sidebar-link>
            </div>

            {{-- MANAGEMENT --}}
            <div class="space-y-2">
                <p class="text-xs text-gray-500 tracking-widest uppercase mb-2">Management</p>
                <x-sidebar-link route="admin.resto.index" icon="fa-solid fa-utensils">Restaurant</x-sidebar-link>
                <x-sidebar-link route="admin.hotel.index" icon="fa-solid fa-hotel">Hotel</x-sidebar-link>
                <x-sidebar-link route="admin.user.user" icon="fa-solid fa-users">User</x-sidebar-link>
                <x-sidebar-link route="admin.shared_customers.index" icon="fa-solid fa-users-viewfinder">Daftar
                    Pelanggan</x-sidebar-link>

            </div>
        @endif

        @if (Auth::user()->usertype == 'hotelnew')
            <div class="space-y-2">
                <p class="text-xs text-gray-500 tracking-widest uppercase mb-2">Dashboard</p>
                <x-sidebar-link route="hotel.dashboard" icon="fa-solid fa-building">Dashboard Hotel</x-sidebar-link>
            </div>

            <div class="space-y-2">
                <p class="text-xs text-gray-500 tracking-widest uppercase mb-2">Operasional</p>
                <x-sidebar-link route="hotel.okupansi" icon="fa-solid fa-chart-area">Statistik</x-sidebar-link>
                <x-sidebar-link route="hotel.booking.index" icon="fa-solid fa-list-check">Data Booking</x-sidebar-link>
                <x-sidebar-link route="hotel.databooking.index" icon="fa-solid fa-folder-open">Unggah
                    Booking</x-sidebar-link>
                <x-sidebar-link route="hotel.rooms.index" icon="fa-solid fa-bed">Manajemen Kamar</x-sidebar-link>
                <x-sidebar-link route="hotel.shared_customers.index_hotel" icon="fa-solid fa-users">Daftar
                    Pelanggan</x-sidebar-link>


            </div>
        @endif

        @if (Auth::user()->usertype == 'restonew')
            <div class="space-y-2">
                <p class="text-xs text-gray-500 tracking-widest uppercase mb-2">Resto</p>
                <x-sidebar-link route="resto.dashboard" icon="fa-solid fa-chart-pie">Dashboard</x-sidebar-link>
                <x-sidebar-link route="resto.okupansi" icon="fa-solid fa-chart-bar">Statistik</x-sidebar-link>
                <x-sidebar-link route="resto.dataorders.index" icon="fa-solid fa-folder-open">Unggah Order</x-sidebar-link>
                <x-sidebar-link route="resto.orders.index" icon="fa-solid fa-receipt">Data Order</x-sidebar-link>
                <x-sidebar-link route="resto.shared_customers.index_resto" icon="fa-solid fa-bed">Daftar
                    Pelanggan</x-sidebar-link>
                <x-sidebar-link route="resto.finances.index" icon="fa-solid fa-money-bill-wave">
                    Keuangan Resto
                </x-sidebar-link>
                <x-sidebar-link route="resto.tables.index" icon="fa-solid fa-utensils">
                    Meja 
                </x-sidebar-link>

            </div>
        @endif

        @if (Auth::user()->usertype == 'frontofficehotel')
            <div class="space-y-2">
                <p class="text-xs text-gray-500 tracking-widest uppercase mb-2">Front Office</p>
                <x-sidebar-link route="hotel.frontoffice.booking.index"
                    icon="fa-solid fa-file-invoice-dollar">Transaksi</x-sidebar-link>
                <x-sidebar-link route="hotel.frontoffice.migrasi.index" icon="fa-solid fa-database">Migrasi</x-sidebar-link>
            </div>
        @endif

        @if (Auth::user()->usertype == 'financehotel')
            <div class="space-y-2">
                <p class="text-xs text-gray-500 tracking-widest uppercase mb-2">Finance</p>
                <x-sidebar-link route="finance.index" icon="fa-solid fa-file-invoice">Data Transaksi</x-sidebar-link>
                <x-sidebar-link route="finance.migrasi.index" icon="fa-solid fa-upload">Data Migrasi</x-sidebar-link>
            </div>
        @endif

        @if (Auth::user()->usertype == 'scmhotel')
            <div class="space-y-2">
                <p class="text-xs text-gray-500 tracking-widest uppercase mb-2">Supply Chain</p>
                <x-sidebar-link route="scm.supplies.index" icon="fa-solid fa-boxes-stacked">Barang</x-sidebar-link>
                <x-sidebar-link route="scm.transactions.index" icon="fa-solid fa-right-left">Transaksi SCM</x-sidebar-link>
            </div>
        @endif

    </nav>
</div>