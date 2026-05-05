<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Codes d'accès & Invitations</h1>
                <p class="text-sm text-gray-500">Générez des codes de sécurité pour autoriser l'inscription des collaborateurs.</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        <!-- Generate Code Form -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 tracking-tight mb-4">Générer un nouveau code</h3>
            <form action="{{ route('admin.invitations.store') }}" method="POST" class="flex flex-col md:flex-row items-end gap-4">
                @csrf
                <div class="w-full md:w-1/3">
                    <x-input-label for="role" :value="__('Rôle à assigner')" />
                    <select id="role" name="role" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900 font-bold" required>
                        <option value="doctor">Médecin</option>
                        <option value="admin">Réceptionniste / Admin</option>
                    </select>
                </div>
                
                <div class="w-full md:w-1/3">
                    <x-input-label for="email" :value="__('Email (Optionnel - Pour info)')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" placeholder="nom@exemple.com" />
                </div>

                <div class="w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold shadow-md hover:bg-blue-700 transition">
                        Générer le Code
                    </button>
                </div>
            </form>
        </div>

        <!-- Codes Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b flex items-center justify-between bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800 tracking-tight">Historique des codes</h3>
            </div>
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-50 border-b">
                            <th class="px-6 py-4">Code d'accès</th>
                            <th class="px-6 py-4">Rôle</th>
                            <th class="px-6 py-4">Généré le</th>
                            <th class="px-6 py-4">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($invitations as $invitation)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg select-all">
                                    {{ $invitation->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-700">
                                {{ $invitation->role == 'admin' ? 'Réceptionniste' : 'Médecin' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $invitation->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($invitation->used_at)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-gray-100 text-gray-500">
                                        Utilisé
                                    </span>
                                @elseif($invitation->expires_at < now())
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-red-100 text-red-600">
                                        Expiré
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-green-100 text-green-600">
                                        En attente
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">Aucun code généré pour le moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
