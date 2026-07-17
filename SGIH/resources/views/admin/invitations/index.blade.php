<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-sgih-royalblue transition-colors">SGIH</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900 font-medium">Codes d'Accès</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Gestion des Accès</h1>
            <p class="text-gray-500 mt-1">Génèrez des codes OTP pour inviter les nouveaux collaborateurs.</p>
        </div>
    </div>

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
        
        @if(session('success'))
        <div class="flex items-start p-5 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 shadow-sm">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center mr-4 shrink-0">
                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
            </div>
            <div>
                <p class="font-bold mb-1">Code généré avec succès</p>
                <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                <p class="text-xs text-emerald-600 mt-2 font-mono font-bold">
                    📧 Email envoyé via les logs Laravel : <code>storage/logs/laravel.log</code>
                </p>
            </div>
        </div>
        @endif

        <!-- Generate Code Form -->
        <div class="bg-white p-8 rounded-2xl shadow-soft border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 flex items-center mb-6">
                <div class="w-8 h-8 rounded-lg bg-sgih-royalblue/10 text-sgih-royalblue flex items-center justify-center mr-3">
                    <i data-lucide="key-round" class="w-4 h-4"></i>
                </div>
                Inviter un nouveau collaborateur
            </h3>

            <form action="{{ route('admin.invitations.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rôle à assigner</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="badge" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <select id="role" name="role" required class="block w-full pl-11 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 font-semibold focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm appearance-none">
                                <option value="">-- Sélectionner --</option>
                                <option value="doctor" @selected(old('role') == 'doctor')>🩺 Médecin</option>
                                <option value="receptionist" @selected(old('role') == 'receptionist')>📋 Réceptionniste</option>
                                <option value="accountant" @selected(old('role') == 'accountant')>💰 Comptable</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email du collaborateur</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" required value="{{ old('email') }}"
                                   class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm"
                                   placeholder="employe@hopital.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Submit -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full flex items-center justify-center px-6 py-3 bg-sgih-royalblue text-white rounded-xl font-bold shadow-soft hover:-translate-y-0.5 hover:shadow-lg transition-all focus:ring-2 focus:ring-blue-500/50">
                            <i data-lucide="send" class="w-5 h-5 mr-2"></i>
                            Générer & Envoyer OTP
                        </button>
                    </div>
                </div>
            </form>

            <!-- Info Banner -->
            <div class="mt-6 flex items-start p-4 bg-blue-50 rounded-xl border border-blue-100">
                <i data-lucide="info" class="w-5 h-5 text-sgih-royalblue mr-3 mt-0.5 shrink-0"></i>
                <p class="text-sm text-blue-700">
                    Un code OTP à <strong>6 chiffres</strong> sera généré et envoyé par email. En mode développement, le code apparaît dans <strong>storage/logs/laravel.log</strong>. L'employé devra saisir ce code sur la page d'inscription pour créer son compte.
                </p>
            </div>
        </div>

        <!-- Codes Table -->
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center mr-3">
                        <i data-lucide="history" class="w-4 h-4"></i>
                    </div>
                    Historique des invitations
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4">Code OTP</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Rôle</th>
                            <th class="px-6 py-4">Généré le</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($invitations as $invitation)
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono font-black text-sgih-royalblue bg-blue-50 px-3 py-1.5 rounded-lg text-base tracking-widest select-all">
                                    {{ $invitation->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700 flex items-center">
                                <i data-lucide="mail" class="w-4 h-4 text-gray-400 mr-2"></i>
                                {{ $invitation->email ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($invitation->role === 'doctor')
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-bold border border-indigo-100">🩺 Médecin</span>
                                @elseif($invitation->role === 'accountant')
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold border border-emerald-100">💰 Comptable</span>
                                @else
                                    <span class="px-3 py-1 bg-orange-50 text-orange-700 rounded-full text-xs font-bold border border-orange-100">📋 Réceptionniste</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $invitation->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($invitation->used_at)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold border border-gray-200 inline-flex items-center">
                                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span> Utilisé
                                    </span>
                                @elseif($invitation->expires_at < now())
                                    <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold border border-red-100 inline-flex items-center">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Expiré
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100 inline-flex items-center">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span> Actif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if(!$invitation->used_at)
                                <form action="{{ route('admin.invitations.destroy', $invitation) }}" method="POST" onsubmit="return confirm('Révoquer cet accès ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i data-lucide="key-round" class="w-12 h-12 mb-3 opacity-50"></i>
                                    <p class="text-lg font-medium text-gray-500">Aucune invitation générée</p>
                                    <p class="text-sm mt-1">Utilisez le formulaire ci-dessus pour inviter un collaborateur.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
