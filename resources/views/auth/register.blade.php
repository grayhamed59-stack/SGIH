<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - SGIH HospiCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7FAFD; }
    </style>
</head>
<body x-data="{ loading: false }" class="min-h-screen flex text-gray-900 selection:bg-[#18D4CF] selection:text-white bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/hospital_bg.png') }}');">

    <!-- Left: Illustration / Branding -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#0A3A8A]/90 to-[#1565D8]/90 backdrop-blur-md text-white p-12 flex-col justify-between relative overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-20">
            <div class="absolute -top-[20%] -left-[10%] w-[70%] h-[70%] rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-[60%] -right-[20%] w-[60%] h-[60%] rounded-full bg-[#18D4CF] blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <img src="{{ asset('images/SGIHLogo.svg') }}" alt="SGIH Logo" class="w-full max-w-lg h-auto mb-8 bg-white/10 p-4 rounded-2xl backdrop-blur-sm">
            <h1 class="text-5xl font-bold leading-tight mb-4">Système de Gestion Hospitalière</h1>
            <p class="text-xl text-blue-100 max-w-md">Une plateforme unifiée, moderne et sécurisée pour la gestion de votre établissement de santé.</p>
        </div>

        <div class="relative z-10">
            <div class="flex items-center space-x-4 mb-6">
                <div class="flex -space-x-3">
                    <img class="w-10 h-10 rounded-full border-2 border-[#1565D8]" src="https://ui-avatars.com/api/?name=Dr+A&color=fff&background=18D4CF" alt="User">
                    <img class="w-10 h-10 rounded-full border-2 border-[#1565D8]" src="https://ui-avatars.com/api/?name=Inf+B&color=fff&background=18D4CF" alt="User">
                    <img class="w-10 h-10 rounded-full border-2 border-[#1565D8]" src="https://ui-avatars.com/api/?name=Admin+C&color=fff&background=18D4CF" alt="User">
                </div>
                <p class="text-sm text-blue-100 font-medium">Rejoignez plus de 500 professionnels de santé</p>
            </div>
            <p class="text-sm text-blue-200">© 2026 SGIH. Tous droits réservés.</p>
        </div>
    </div>

    <!-- Right: Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative backdrop-blur-md bg-white/30">
        <!-- Mobile Logo -->
        <div class="absolute top-8 left-8 lg:hidden">
            <img src="{{ asset('images/SGIHLogo.svg') }}" alt="SGIH Logo" class="w-[300px] max-w-[80vw] h-auto">
        </div>

        <div class="w-full max-w-md bg-white/70 backdrop-blur-2xl p-8 rounded-[2.5rem] border border-white/50 shadow-2xl">
            <div class="text-center lg:text-left mb-8">
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Inscription 👋</h2>
                <p class="text-gray-500 mt-2">Enregistrement Nouveau Collaborateur</p>
            </div>

            <!-- Loading overlay inside form -->
            <div x-show="loading" style="display: none;" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center rounded-3xl">
                <i data-lucide="loader-2" class="w-8 h-8 text-[#1565D8] animate-spin"></i>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4" @submit="loading = true">
                @csrf

                <!-- Access Code -->
                <div class="p-3 bg-blue-50 border border-blue-100 rounded-2xl">
                    <label for="access_code" class="block text-xs font-black uppercase tracking-[0.2em] text-blue-600 mb-1 text-center">Clé d'Accès Sécurisée</label>
                    <input id="access_code" type="text" name="access_code" value="{{ old('access_code') }}" required autofocus class="block w-full bg-white border-blue-200 focus:border-[#1565D8] focus:ring-[#1565D8] rounded-xl shadow-sm text-[#1565D8] font-mono tracking-[0.3em] text-center text-lg uppercase placeholder-blue-300" placeholder="XXXX-XXXX">
                    <x-input-error :messages="$errors->get('access_code')" class="mt-1 text-red-500 text-xs font-bold text-center" />
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom Complet</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="block w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-[#18D4CF]/50 focus:border-[#18D4CF] transition-colors shadow-sm">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="block w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-[#18D4CF]/50 focus:border-[#18D4CF] transition-colors shadow-sm">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Passwords -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-[#18D4CF]/50 focus:border-[#18D4CF] transition-colors shadow-sm">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmation</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-[#18D4CF]/50 focus:border-[#18D4CF] transition-colors shadow-sm">
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-600" />

                <!-- Submit Button -->
                <div class="pt-4 flex flex-col items-center justify-between gap-4">
                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/20 text-white bg-[#1565D8] hover:bg-[#0A3A8A] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1565D8] font-bold transition-all hover:-translate-y-0.5 active:translate-y-0">
                        S'enregistrer
                        <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
                    </button>
                    <a @click="loading = true" class="text-sm font-medium text-[#1565D8] hover:text-[#0A3A8A] transition-colors" href="{{ route('login') }}">
                        Déjà inscrit ? Se connecter
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
