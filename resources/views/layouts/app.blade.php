<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PHRI DASHBOARD') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap (optional, not recommended with Tailwind) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

    <style>[x-cloak] { display: none !important; }</style>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="font-sans antialiased">
<div x-data="{ sidebarOpen: false }" class="relative flex min-h-screen bg-gray-200 overflow-hidden">

    <!-- Sidebar -->
    <aside  
        class="bg-white w-64 fixed inset-y-0 left-0 z-40 shadow-md transform transition-transform duration-300 ease-in-out -translate-x-full sm:translate-x-0"
        :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
        @include('layouts.sidebar')
    </aside>

    <!-- Overlay (mobile only) -->
    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 bg-black opacity-50 sm:hidden" @click="sidebarOpen = false"></div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden pl-0 sm:pl-64 transition-all duration-300">

        <!-- Topbar -->
        <div class="bg-white  shadow px-4 h-16 flex items-center justify-between sm:justify-end ">
            <button @click="sidebarOpen = !sidebarOpen" class="sm:hidden focus:outline-none">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            @include('layouts.topbar')
        </div>

        <!-- Header -->
        @isset($header)
            <header class="bg-white shadow px-4 py-4 sm:px-6 ">
                <div class="max-w-7xl mx-auto">
                    {{ $header }}
                </div>
            </header>
        @endisset


        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 ">
            {{ $slot }}
        </main>
    </div>
</div>

<!-- Optional JS to close all Alpine dropdowns -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelectorAll('[x-data]').forEach(el => {
                    if (el.__x && typeof el.__x.$data.open !== 'undefined') {
                        el.__x.$data.open = false;
                    }
                });
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#customer_id', {
        placeholder: 'Cari pelanggan...',
        allowEmptyOption: true,
    });
</script>

<script src="//unpkg.com/alpinejs" defer></script>

</body>

</html>
