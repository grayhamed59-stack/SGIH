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

<body x-data="{ loading: false }" class="bg-gray-50 text-gray-900 min-h-screen flex items-center justify-center p-6">

    <!-- Loading Overlay -->
    <div x-show="loading" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         style="display: none;"
         class="fixed inset-0 z-[100] bg-white/80 backdrop-blur-md flex flex-col items-center justify-center">
        <div class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
        <p class="mt-4 text-blue-600 font-bold text-sm uppercase tracking-widest animate-pulse">Création du profil sécurisé...</p>
    </div>

    <div class="max-w-md w-full animate-in fade-in slide-in-from-bottom-4 duration-500">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Nouveau Collaborateur</h2>
            <p class="text-sm text-gray-500 mt-1">Créez votre compte grâce au code d'invitation.</p>
        </div>

        <!-- Card -->
        <div class="bg-white p-8 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
            <form method="POST" action="{{ route('register') }}" class="space-y-6" @submit="loading = true">
                @csrf

                <!-- Access Code -->
                <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl">
                    <label for="access_code" class="block text-xs font-bold uppercase tracking-widest text-blue-800 mb-2">Clé d'Accès Sécurisée</label>
                    <input id="access_code" type="text" name="access_code" value="{{ old('access_code') }}" required autofocus class="block w-full border-blue-300 focus:border-blue-600 focus:ring-blue-600 rounded-xl shadow-sm text-blue-900 font-mono tracking-widest text-center text-lg uppercase bg-white placeholder-blue-200" placeholder="XXXX-XXXX">
                    <x-input-error :messages="$errors->get('access_code')" class="mt-2 text-red-500 text-sm font-bold text-center" />
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nom Complet</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Adresse Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Mot de passe</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirmer mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <a @click="loading = true" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors" href="{{ route('login') }}">
                        Déjà inscrit ?
                    </a>
                    <button type="submit" class="bg-gray-900 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-gray-800 transition transform hover:-translate-y-0.5 active:scale-95">
                        Valider l'inscription
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center text-xs text-gray-400 font-bold uppercase tracking-widest mt-8">
            &copy; 2026 SGIH HospiCare
        </p>
    </div>

    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
