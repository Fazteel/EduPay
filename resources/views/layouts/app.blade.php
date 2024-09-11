<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme') === 'dark' ? 'dark' : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('favicon-32x32.png') }}" type="image/png">
        <title>EduPay</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/flowbite@1.4.7/dist/flowbite.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.sidebar')

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
    </body>
    <script>
        function updateTime() {
            var now = new Date();
            
            var hours24 = now.getHours();
            var minutes = String(now.getMinutes()).padStart(2, '0');
            var seconds = String(now.getSeconds()).padStart(2, '0');
            
            var ampm = hours24 >= 12 ? 'PM' : 'AM';
            var hours12 = hours24 % 12;
            hours12 = hours12 ? hours12 : 12; 
            var timeString = String(hours12).padStart(2, '0') + ':' + minutes + ':' + seconds + ' ' + ampm;

            document.getElementById('time').textContent = timeString;

            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('live-date').textContent = now.toLocaleDateString('en-US', options);
        }

        document.addEventListener('DOMContentLoaded', function() {
            setInterval(updateTime, 1000);
            updateTime(); 
        });

        document.addEventListener("DOMContentLoaded", function() {
            const dropdownButton = document.querySelector('[data-collapse-toggle="dropdown-example"]');
            const dropdownMenu = document.getElementById("dropdown-example");

            dropdownButton.addEventListener("click", function() {
                dropdownMenu.classList.toggle("hidden");
            });
        });
    </script>
</html>
