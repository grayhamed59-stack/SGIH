<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SGIH HospiCare</title>
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
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/60 to-transparent"></div>
    </div>

    <div class="relative z-10 max-w-md w-full md:ml-20 lg:ml-32 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center bg-white/10 backdrop-blur-xl p-4 rounded-[2rem] shadow-2xl border border-white/20 text-white mb-4">
                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black tracking-tight text-white">SGIH <span class="text-blue-400">HospiCare</span></h2>
            <p class="text-sm text-slate-300 font-medium mt-1">Authentification au Portail Staff</p>
        </div>

        <!-- Glass Card -->
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 p-8 rounded-[2.5rem] shadow-[0_32px_64px_-15px_rgba(0,0,0,0.5)]">
            <!-- Session Status -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6" @submit="loading = true">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-black text-blue-400 uppercase tracking-widest mb-2 ml-1">Identifiant Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="block w-full bg-white/5 border-white/10 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-white placeholder-slate-500 py-3.5" placeholder="votre@mail.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs font-bold" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-2 ml-1">
                        <label for="password" class="block text-xs font-black text-blue-400 uppercase tracking-widest">Mot de passe</label>
                        @if (Route::has('password.request'))
                            <a class="text-[10px] text-slate-400 hover:text-white font-bold transition-colors uppercase tracking-widest" href="{{ route('password.request') }}">
                                Oublié ?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full bg-white/5 border-white/10 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-white py-3.5">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs font-bold" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center ml-1">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-white/10 bg-white/5 text-blue-500 shadow-sm focus:ring-blue-500">
                    <label for="remember_me" class="ml-2 text-xs font-bold text-slate-400">Session persistante</label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-4 rounded-2xl font-black shadow-lg hover:bg-blue-500 transition-all hover:scale-[1.02] active:scale-95 uppercase tracking-widest">
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center text-[10px] text-slate-500 font-black uppercase tracking-[0.4em] mt-10">
            &copy; 2026 SGIH HospiCare SYSTEM
        </p>
    </div>

    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
