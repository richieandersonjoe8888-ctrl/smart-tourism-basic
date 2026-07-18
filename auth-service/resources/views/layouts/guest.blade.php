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
    <body class="font-sans text-gray-900 antialiased">
        <x-universal-header />
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative bg-cover bg-center" style="background-image: url('{{ asset('images/login_background.png') }}');">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
            
            <div class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-8 bg-white/80 backdrop-blur-lg shadow-2xl overflow-hidden sm:rounded-3xl border border-white/50">
                <!-- App Icon anchored to the middle of the box -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-20 pointer-events-none">
                    <x-application-logo class="w-12 h-12 drop-shadow-sm" />
                </div>
                
                <!-- Main Form Content -->
                <div class="relative z-20">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
