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
        
        <!-- Dark Mode Detection -->
        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @if(session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonColor: '#4f46e5'
                    });
                });
            </script>
        @endif
        @if(session('error'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: 'Gagal!',
                        text: "{{ session('error') }}",
                        icon: 'error',
                        confirmButtonColor: '#4f46e5'
                    });
                });
            </script>
        @endif

        <!-- Dark Mode Toggle Script -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
                var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
                var themeToggleDarkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');
                var themeToggleLightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');

                // Change the icons inside the button based on previous settings
                if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    if (themeToggleLightIcon) themeToggleLightIcon.classList.remove('hidden');
                    if (themeToggleLightIconMobile) themeToggleLightIconMobile.classList.remove('hidden');
                } else {
                    if (themeToggleDarkIcon) themeToggleDarkIcon.classList.remove('hidden');
                    if (themeToggleDarkIconMobile) themeToggleDarkIconMobile.classList.remove('hidden');
                }

                var themeToggleBtn = document.getElementById('theme-toggle');
                var themeToggleBtnMobile = document.getElementById('theme-toggle-mobile');

                function toggleTheme() {
                    // toggle icons
                    if (themeToggleDarkIcon) themeToggleDarkIcon.classList.toggle('hidden');
                    if (themeToggleLightIcon) themeToggleLightIcon.classList.toggle('hidden');
                    if (themeToggleDarkIconMobile) themeToggleDarkIconMobile.classList.toggle('hidden');
                    if (themeToggleLightIconMobile) themeToggleLightIconMobile.classList.toggle('hidden');

                    // if set via local storage previously
                    if (localStorage.getItem('color-theme')) {
                        if (localStorage.getItem('color-theme') === 'light') {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('color-theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('color-theme', 'light');
                        }

                    // if not set via local storage previously
                    } else {
                        if (document.documentElement.classList.contains('dark')) {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('color-theme', 'light');
                        } else {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('color-theme', 'dark');
                        }
                    }
                }

                if (themeToggleBtn) {
                    themeToggleBtn.addEventListener('click', toggleTheme);
                }
                if (themeToggleBtnMobile) {
                    themeToggleBtnMobile.addEventListener('click', toggleTheme);
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>
