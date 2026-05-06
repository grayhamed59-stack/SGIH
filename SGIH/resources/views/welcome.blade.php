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

<body x-data="{ loading: false }" class="bg-slate-900 min-h-screen relative overflow-hidden flex items-center justify-start p-4 md:p-0">

    <!-- Loading Overlay -->
    ...
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hospital_bg.png') }}" class="w-full h-full object-cover object-right md:object-center" alt="Hospital background">
        <!-- Gradient from left (dark) to right (transparent) to show the doctor -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/60 to-transparent"></div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-5%] w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
    </div>    <div class="relative z-10 w-full h-full flex flex-col md:flex-row items-center justify-between px-6 md:px-20 lg:px-32 py-10">
        
        <!-- Left Side: Branding & Hero Text -->
        <div class="w-full md:w-1/2 space-y-10 animate-in fade-in slide-in-from-left-10 duration-1000">
            <div class="space-y-6">
                <div class="inline-block">
                    <span class="text-xs font-black text-blue-400 uppercase tracking-[0.4em] bg-blue-400/10 px-4 py-2 rounded-full mb-4 block">Intelligence Médicale Africaine</span>
                </div>
                <h1 class="text-6xl lg:text-8xl font-black tracking-tighter text-white leading-none">
                    SGIH<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300">HospiCare</span>
                </h1>
                <p class="max-w-md text-xl text-slate-300 leading-relaxed font-medium">
                    L'excellence opérationnelle pour votre établissement de santé, pensée et conçue pour le contexte africain.
                </p>
            </div>

            <!-- Features Grid (Minimal) -->
            <div class="grid grid-cols-2 gap-8 pt-6 border-t border-white/10">
                <div>
                    <p class="text-white font-black text-2xl">100%</p>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Connecté</p>
                </div>
                <div>
                    <p class="text-white font-black text-2xl">SAFE</p>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Données Patient</p>
                </div>
            </div>
        </div>

        <!-- Center Space: Kept clear for the Doctor's Portrait -->
        <div class="hidden lg:block lg:w-1/4"></div>

        <!-- Right Side: Actions & Access -->
        <div class="w-full md:w-1/3 flex flex-col items-center md:items-end space-y-8 animate-in fade-in slide-in-from-right-10 duration-1000 delay-200">
            
            <!-- Minimal Glass Access Box -->
            <div class="w-full bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-[2.5rem] shadow-2xl text-center md:text-right space-y-6">
                <h3 class="text-white font-black uppercase tracking-widest text-sm">Accès Sécurisé</h3>
                
                <div class="flex flex-col gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a @click="loading = true" href="{{ url('/dashboard') }}" class="w-full bg-white text-slate-900 px-8 py-4 rounded-2xl font-black transition-all hover:scale-105 active:scale-95 shadow-xl flex items-center justify-center">
                                Mon Dashboard
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                        @else
                            <a @click="loading = true" href="{{ route('login') }}" class="w-full bg-blue-600 text-white px-8 py-5 rounded-2xl font-black transition-all hover:scale-105 hover:shadow-[0_20px_50px_rgba(37,99,235,0.3)] active:scale-95 flex items-center justify-center">
                                Connexion Staff
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            </a>
                            @if (Route::has('register'))
                                <a @click="loading = true" href="{{ route('register') }}" class="w-full bg-white/5 border border-white/20 text-white px-8 py-4 rounded-2xl font-black hover:bg-white/10 transition-all hover:scale-105">
                                    Inscription
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <!-- System Info -->
            <div class="text-center md:text-right">
                <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.4em]">
                    SGIH HospiCare v2.0
                </p>
                <p class="text-[9px] text-blue-500 font-bold uppercase tracking-widest mt-1">
                    Système Certifié & Sécurisé
                </p>
            </div>
        </div>

    </div>

    </div>

    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>