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
    <body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
            
            <!-- Header Text Mockup -->
            <div class="text-center max-w-2xl mb-8">
                <h1 class="text-base sm:text-lg md:text-xl font-black text-gray-900 dark:text-white uppercase tracking-wider leading-relaxed">
                    Sistem Pendukung Keputusan Pemilihan Batik Terbaik<br>
                    <span class="text-indigo-600 dark:text-indigo-400">Di Toko Apollo Dengan Menggunakan Metode AHP</span>
                </h1>
            </div>

            <!-- Card Container -->
            <div class="w-full sm:max-w-md bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden rounded-2xl p-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
