<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGIH HospiCare - Système de Gestion Hospitalière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body x-data="{ loading: false }" class="bg-slate-900 min-h-screen relative overflow-hidden flex items-center justify-center p-4">

    <!-- Loading Overlay -->
    <div x-show="loading" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         style="display: none;"
         class="fixed inset-0 z-[100] bg-slate-900/90 backdrop-blur-xl flex flex-col items-center justify-center">
        
        <div class="relative">
            <!-- Pulsing outer circle -->
            <div class="absolute inset-0 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl animate-pulse -translate-x-4 -translate-y-4"></div>
            
            <!-- Main Spinner -->
            <div class="relative w-24 h-24">
                <svg class="w-full h-full animate-spin text-blue-500" viewBox="0 0 100 100">
                    <circle class="opacity-10" cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="none" />
                    <path class="opacity-75" fill="currentColor" d="M4 50a46 46 0 0 1 46-46v8a38 38 0 0 0-38 38H4z" />
                </svg>
                
                <!-- Inner pulsing logo/icon -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <h3 class="text-white font-black text-xl uppercase tracking-[0.3em] mb-2">SGIH HospiCare</h3>
            <p class="text-blue-400 font-bold text-xs uppercase tracking-widest animate-pulse">Chargement de l'environnement sécurisé...</p>
        </div>
    </div>

    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hospital_bg.png') }}" class="w-full h-full object-cover" alt="Hospital background">
        <!-- Modern gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-950/90 via-indigo-950/80 to-slate-900/95 backdrop-blur-[1px]"></div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-5%] w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative z-10 max-w-4xl w-full flex flex-col items-center">
        <!-- Logo Section -->
        <div class="mb-10 animate-in fade-in slide-in-from-top-10 duration-1000">
            <div class="inline-flex items-center justify-center bg-white/10 backdrop-blur-xl p-5 rounded-[2.5rem] shadow-2xl border border-white/20 text-white group hover:scale-105 transition-transform duration-500">
                <svg class="w-14 h-14 text-blue-400 group-hover:text-blue-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>

        <!-- Main Card -->
        <div class="w-full bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[3rem] p-8 md:p-16 shadow-[0_32px_64px_-15px_rgba(0,0,0,0.5)] text-center space-y-10 animate-in fade-in zoom-in duration-700">
            
            <div class="space-y-6">
                <div class="inline-block">
                    <span class="text-xs font-black text-blue-400 uppercase tracking-[0.4em] bg-blue-400/10 px-4 py-2 rounded-full mb-6 block">Système d'Intelligence Médicale</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-black tracking-tight text-white">
                    SGIH <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300">HospiCare</span>
                </h1>
                <p class="max-w-2xl mx-auto text-lg text-slate-300 leading-relaxed font-medium">
                    Solution de gestion hospitalière de nouvelle génération adaptée au contexte africain pour une excellence opérationnelle garantie.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a @click="loading = true" href="{{ url('/dashboard') }}" class="group relative w-full sm:w-auto overflow-hidden bg-white text-slate-900 px-12 py-5 rounded-2xl font-black transition-all hover:scale-105 active:scale-95 shadow-[0_20px_50px_rgba(255,255,255,0.1)]">
                            <span class="relative z-10 flex items-center justify-center">
                                Accéder au Dashboard
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </a>
                    @else
                        <a @click="loading = true" href="{{ route('login') }}" class="group relative w-full sm:w-auto overflow-hidden bg-gradient-to-r from-blue-600 to-blue-500 text-white px-10 py-5 rounded-2xl font-black transition-all hover:scale-105 hover:shadow-[0_20px_50px_rgba(37,99,235,0.3)] active:scale-95">
                            <span class="relative z-10 flex items-center justify-center">
                                Connexion Staff
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3 3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            </span>
                        </a>
                        @if (Route::has('register'))
                            <a @click="loading = true" href="{{ route('register') }}" class="w-full sm:w-auto bg-white/5 backdrop-blur-md text-white border border-white/20 px-10 py-5 rounded-2xl font-black hover:bg-white/10 transition-all hover:scale-105 active:scale-95">
                                Nouvel Enregistrement
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Features Quick Info -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 pt-10 border-t border-white/10">
                <div class="text-center p-4">
                    <p class="text-white font-black text-xl">100%</p>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Afrique Centrale</p>
                </div>
                <div class="text-center p-4">
                    <p class="text-white font-black text-xl">24/7</p>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Connectivité</p>
                </div>
                <div class="hidden md:block text-center p-4">
                    <p class="text-white font-black text-xl">VIP</p>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Gestion Patient</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 animate-in fade-in slide-in-from-bottom-10 duration-1000 delay-500">
            <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.5em] text-center">
                &copy; 2026 SGIH SYSTEM - Excellence Médicale Africaine
            </p>
        </div>
    </div>

    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>