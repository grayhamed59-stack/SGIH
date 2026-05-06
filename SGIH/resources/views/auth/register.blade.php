<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - SGIH HospiCare</title>
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

    <div class="relative z-10 max-w-md w-full md:ml-20 lg:ml-32 animate-in fade-in slide-in-from-bottom-4 duration-500 py-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black tracking-tight text-white uppercase tracking-widest">SGIH <span class="text-blue-400">HospiCare</span></h2>
            <p class="text-sm text-slate-300 font-medium mt-1">Enregistrement Nouveau Collaborateur</p>
        </div>

        <!-- Glass Card -->
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 p-8 rounded-[2.5rem] shadow-[0_32px_64px_-15px_rgba(0,0,0,0.5)]">
            <form method="POST" action="{{ route('register') }}" class="space-y-6" @submit="loading = true">
                @csrf

                <!-- Access Code -->
                <div class="p-4 bg-blue-600/10 border border-blue-500/20 rounded-2xl">
                    <label for="access_code" class="block text-[10px] font-black uppercase tracking-[0.2em] text-blue-400 mb-2 text-center">Clé d'Accès Sécurisée</label>
                    <input id="access_code" type="text" name="access_code" value="{{ old('access_code') }}" required autofocus class="block w-full bg-white/5 border-white/10 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-blue-400 font-mono tracking-[0.3em] text-center text-lg uppercase placeholder-blue-900" placeholder="XXXX-XXXX">
                    <x-input-error :messages="$errors->get('access_code')" class="mt-2 text-red-400 text-xs font-bold text-center" />
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-black text-blue-400 uppercase tracking-widest mb-2 ml-1">Nom Complet</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="block w-full bg-white/5 border-white/10 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-white py-3">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-xs font-bold" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-black text-blue-400 uppercase tracking-widest mb-2 ml-1">Adresse Email Professionnelle</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="block w-full bg-white/5 border-white/10 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-white py-3">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs font-bold" />
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2 ml-1">Mot de passe</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full bg-white/5 border-white/10 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-white py-3">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2 ml-1">Confirmation</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block w-full bg-white/5 border-white/10 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-white py-3">
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs font-bold" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-xs font-bold" />

                <div class="pt-4 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a @click="loading = true" class="text-xs font-bold text-slate-400 hover:text-white transition-colors uppercase tracking-widest" href="{{ route('login') }}">
                        Déjà inscrit ?
                    </a>
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-8 py-3.5 rounded-2xl font-black shadow-lg hover:bg-blue-500 transition-all hover:scale-[1.02] active:scale-95 uppercase tracking-widest">
                        S'enregistrer
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
