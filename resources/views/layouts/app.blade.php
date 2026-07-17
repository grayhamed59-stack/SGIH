<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- TITLE BRANDING -->
        <title>SGIH - Système de Gestion Hospitalière</title>

        <!-- FAVICON -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('images/SGIHLogo.svg') }}">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
        <!-- ApexCharts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    </head>

    <body class="font-sans antialiased text-gray-900 bg-sgih-light selection:bg-sgih-cyan selection:text-white" x-data="{ sidebarOpen: true }">
        <div class="flex h-screen overflow-hidden bg-sgih-light">

            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden min-w-0">

                <!-- NAVIGATION (Topbar) -->
                @include('layouts.navigation')

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-6 md:p-8 lg:p-10">

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 glassmorphism border-l-4 border-l-green-500 text-green-700 rounded-xl flex items-center shadow-soft">
                            <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="mb-6 p-4 glassmorphism border-l-4 border-l-sgih-royalblue text-sgih-deepblue rounded-xl flex items-center shadow-soft">
                            <i data-lucide="info" class="w-5 h-5 mr-3"></i>
                            <span class="font-medium">{{ session('info') }}</span>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="mb-6 p-4 glassmorphism border-l-4 border-l-orange-500 text-orange-700 rounded-xl flex items-center shadow-soft">
                            <i data-lucide="alert-triangle" class="w-5 h-5 mr-3"></i>
                            <span class="font-medium">{{ session('warning') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Initialize Lucide Icons -->
        <script>
            lucide.createIcons();
            
            // Re-initialize icons when Livewire or Alpine mutates DOM (optional but good practice)
            document.addEventListener('alpine:initialized', () => {
                lucide.createIcons();
            });
        </script>
    </body>
</html>