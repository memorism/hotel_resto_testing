<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 antialiased font-sans">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white shadow-lg rounded-lg flex flex-col md:flex-row overflow-hidden w-full max-w-4xl">
            
            <!-- Logo -->
            <div class="md:w-1/2 bg-gray-100 flex items-center justify-center p-6">
                <img src="{{ asset('images/PHRI_LOGO.png') }}" alt="Logo PHRI" class="max-h-64 w-auto">
            </div>

            <!-- Form -->
            <div class="md:w-1/2 p-8">
                {{ $slot }}
            </div>

        </div>
    </div>
</body>

</html>
