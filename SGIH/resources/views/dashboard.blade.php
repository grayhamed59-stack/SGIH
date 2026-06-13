
<div style="text-align: center; margin-bottom: 40px;">
    <img src="{{ asset('images/logo.png') }}" alt="Logo SGIH" width="90">
</div>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">

            <!-- LOGO + TITRE HEADER -->
            <div class="flex items-center space-x-4">

                <!-- LOGO AJOUTÉ ICI -->
                <img src="{{ asset('images/logo.png') }}"
                     alt="Logo SGIH"
                     class="h-10 w-10 object-contain">

                <div>
                    <h1 class="text-2xl font-bold text-gray-800 tracking-tight">
                        Tableau de bord
                    </h1>
                    <p class="text-sm text-gray-500">
                        Bienvenue dans votre interface de gestion hospitalière.
                    </p>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="flex space-x-3">
                <a href="{{ route('patients.export') }}" class="bg-white border text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition shadow-sm flex items-center" download>
                    <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Exporter
                </a>

                <a href="{{ route('patients.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-md flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nouveau patient
                </a>
            </div>
        </div>
    </x-slot>

    <!-- LE RESTE INCHANGÉ -->





<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Tableau de bord</h1>
                <p class="text-sm text-gray-500">Bienvenue dans votre interface de gestion hospitalière.</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('patients.export') }}" class="bg-white border text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition shadow-sm flex items-center" download>
                    <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Exporter
                </a>
                <a href="{{ route('patients.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-md flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></p

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Stats Cards Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Patients -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1 uppercase tracking-wider">Total Patients</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ $patientsCount }}</h3>
                    <p class="text-xs text-green-500 mt-2 font-bold flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7l-1.2 1.2L12 9.5 14.5 7H12zm-5.2 5.2L8 11l1.3 1.3-2.5 0 0 1.2z" clip-rule="evenodd"></path></svg>
                        +12% ce mois
                    </p>
                </div>
                <div class="bg-blue-50 p-4 rounded-2xl text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>

            <!-- New Patients -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1 uppercase tracking-wider">Nouveaux patients</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ $patientsCount }}</h3>
                    <p class="text-xs text-green-500 mt-2 font-bold flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7l-1.2 1.2L12 9.5 14.5 7H12zm-5.2 5.2L8 11l1.3 1.3-2.5 0 0 1.2z" clip-rule="evenodd"></path></svg>
                        +8% ce mois
                    </p>
                </div>
                <div class="bg-green-50 p-4 rounded-2xl text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
            </div>

            <!-- Appointments -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1 uppercase tracking-wider">Rendez-vous</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ $appointmentsCount }}</h3>
                    <p class="text-xs text-orange-500 mt-2 font-bold flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Aujourd'hui
                    </p>
                </div>
                <div class="bg-orange-50 p-4 rounded-2xl text-orange-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>

            <!-- Satisfaction -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1 uppercase tracking-wider">Taux satisfaction</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">98%</h3>
                    <p class="text-xs text-purple-500 mt-2 font-bold flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7l-1.2 1.2L12 9.5 14.5 7H12zm-5.2 5.2L8 11l1.3 1.3-2.5 0 0 1.2z" clip-rule="evenodd"></path></svg>
                        +3% ce mois
                    </p>
                </div>
                <div class="bg-purple-50 p-4 rounded-2xl text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Main Dashboard View (Table simulation) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b flex items-center justify-between bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800 tracking-tight">Activité récente des patients</h3>
                <button class="text-sm text-blue-600 font-bold hover:underline">Tout voir</button>
            </div>
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-50 border-b">
                            <th class="px-6 py-4">ID Patient</th>
                            <th class="px-6 py-4">Nom Complet</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentPatients as $patient)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-700">#PT-{{ str_pad($patient->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold mr-3 text-xs {{ $patient->gender == 'Masculin' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}">
                                        {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $patient->first_name }} {{ $patient->last_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $patient->status == 'Actif' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                    {{ $patient->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('patients.edit', $patient) }}?from_dashboard=1" class="text-blue-600 hover:text-blue-800 font-bold text-xs uppercase">Éditer</a>
                                <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="inline" onsubmit="return confirm('Archiver ce dossier patient ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase">Archiver</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">Aucune activité récente.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
