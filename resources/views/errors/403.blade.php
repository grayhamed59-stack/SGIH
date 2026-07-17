<x-guest-layout>
    <div class="text-center p-6">
        <div class="mb-6 flex justify-center">
            <!-- Icone cadenas / alerte -->
            <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
            Accès Non Autorisé
        </h1>

        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded p-4 mb-6 text-left">
            <p class="text-gray-700 dark:text-gray-300 mb-2">
                Vous essayez d'accéder à une page sécurisée. Cette page est réservée aux rôles suivants : 
                <span class="font-semibold text-red-600 dark:text-red-400">
                    {{ implode(', ', array_map('ucfirst', $allowedRoles)) }}
                </span>.
            </p>
            <p class="text-gray-700 dark:text-gray-300">
                Vous êtes actuellement connecté en tant que : 
                <span class="font-bold">
                    {{ ucfirst($currentRole) }}
                </span>.
            </p>
        </div>

        <p class="text-sm text-gray-500 mb-6">
            Si vous pensez qu'il s'agit d'une erreur, veuillez contacter l'administrateur du système.
        </p>

        <a href="{{ route($dashboardRoute) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Retourner à mon tableau de bord
        </a>
    </div>
</x-guest-layout>
