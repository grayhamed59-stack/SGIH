<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- TITLE BRANDING -->
        <title>SGIH - Système de Gestion Hospitalière</title>

        <!-- FAVICON -->
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- SIMPLE BRAND STYLE (optionnel mais pro) -->
        <style>
            .sgih-logo {
                transition: 0.3s ease;
            }
            .sgih-logo:hover {
                transform: scale(1.05);
                filter: drop-shadow(0 0 6px rgba(59,130,246,0.6));
            }
        </style>
    </head>

    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        <div class="flex h-screen overflow-hidden">

            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">

                <!-- NAVIGATION AVEC LOGO (MODIF IMPORTANT) -->
                <nav class="bg-white border-b px-6 py-3 flex items-center justify-between">
                    
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="SGIH Logo"
                             class="h-10 sgih-logo">

                        <div>
                            <h1 class="font-bold text-lg text-blue-600">SGIH</h1>
                            <p class="text-xs text-gray-500">Gestion Hospitalière</p>
                        </div>
                    </div>

                    @include('layouts.navigation')
                </nav>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-8">

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-600 rounded-2xl font-bold">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 text-blue-600 rounded-2xl font-bold">
                            {{ session('info') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="mb-6 p-4 bg-orange-50 border border-orange-200 text-orange-600 rounded-2xl font-bold">
                            {{ session('warning') }}
                        </div>
                    @endif

                    @isset($header)
                        <div class="mb-8">
                            {{ $header }}
                        </div>
                    @endisset

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>