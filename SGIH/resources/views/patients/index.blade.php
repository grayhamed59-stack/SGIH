<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Gestion des patients</h1>
                <p class="text-sm text-gray-500">Consultez et suivez l'ensemble des patients enregistrés dans le système.</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('patients.export') }}" class="bg-white border text-gray-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-50 transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Exporter (CSV)
                </a>
                <a href="{{ route('patients.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Ajouter un patient
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <!-- Search and Filter Bar -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-wrap items-center justify-between gap-4">
            <form action="{{ route('patients.index') }}" method="GET" class="flex-1 min-w-[300px] relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un patient par nom, numéro..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 transition sm:text-sm">
                @if(request('search'))
                <a href="{{ route('patients.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
                @endif
            </form>
            <div class="flex items-center space-x-2">
                <button class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 flex items-center transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filtrer
                </button>
            </div>
        </div>

        <!-- Patients Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divice-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">ID Patient</th>
                            <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-widest text-xs">Nom Complet / Sexe</th>
                            <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-widest text-xs">Âge</th>
                            <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-widest text-xs">Téléphone</th>
                            <th class="px-6 py-4 text-left font-bold text-gray-400 uppercase tracking-widest text-xs">Statut</th>
                            <th class="px-6 py-4 text-right font-bold text-gray-400 uppercase tracking-widest text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($patients as $patient)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">#PT-{{ str_pad($patient->id, 3, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm mr-3 shadow-sm border border-white p-0.5 {{ $patient->gender == 'Masculin' ? 'bg-indigo-100 text-indigo-600' : 'bg-pink-100 text-pink-600' }}">
                                        {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-extrabold text-gray-900 group-hover:text-blue-600 transition">{{ $patient->first_name }} {{ strtoupper($patient->last_name) }}</div>
                                        <div class="text-xs text-gray-400 font-medium">{{ $patient->gender }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm text-gray-600 font-bold">{{ \Carbon\Carbon::parse($patient->birth_date)->age }} ans</div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm text-gray-600 font-medium font-mono">{{ $patient->phone }}</div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $patient->status == 'Actif' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                    {{ $patient->status }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition" title="Détails">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <a href="{{ route('patients.edit', $patient) }}" class="p-2 text-gray-400 hover:bg-gray-50 rounded-lg transition" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('patients.destroy', $patient) }}" method="POST" onsubmit="return confirm('Archiver ce dossier patient ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Archiver">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Mockup -->
            <div class="px-6 py-4 bg-gray-50 border-t flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Affichage de <span class="font-bold">1</span> à <span class="font-bold">5</span> sur <span class="font-bold">5</span> patients
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 border border-gray-200 rounded-lg text-sm disabled:opacity-50">Précédent</button>
                    <button class="px-3 py-1 bg-blue-600 text-white border border-blue-600 rounded-lg text-sm">1</button>
                    <button class="px-3 py-1 border border-gray-200 rounded-lg text-sm">Suivant</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
