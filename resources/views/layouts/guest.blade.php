<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'weatherBoy') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-sky-100 via-blue-200 to-indigo-200">
    <div class="min-h-screen flex flex-col items-center justify-center px-6 py-12">

        <div class="bg-white/70 backdrop-blur-md p-8 rounded-2xl shadow-xl text-center max-w-md w-full">
            {{ $slot }}
        </div>
    </div>
    @stack('scripts')
</body>

</html>