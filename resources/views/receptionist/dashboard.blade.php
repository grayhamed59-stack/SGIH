<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                <span class="text-sgih-royalblue font-medium">SGIH</span>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900 font-medium">Accueil & Réception</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Poste de Réception</h1>
            <p class="text-gray-500 mt-1">Bienvenue — Gérez les admissions, rendez-vous et patients du jour.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('patients.create') }}" class="flex items-center px-4 py-2 bg-sgih-royalblue hover:bg-blue-700 text-white rounded-xl font-medium shadow-soft transition-colors">
                <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                Nouveau Patient
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 shadow-sm animate-in fade-in slide-in-from-top-2">
        <i data-lucide="check-circle-2" class="w-5 h-5 mr-3 text-emerald-600"></i>
        <p class="font-semibold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">

        <!-- KPIs de la journée -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Patients Total -->
            <div class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-sgih-cyan bg-cyan-50 border border-cyan-100 group-hover:scale-110 transition-transform">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Patients</p>
                    <p class="text-2xl font-black text-gray-900">{{ $patientsCount }}</p>
                </div>
            </div>

            <!-- RDV en attente de paiement -->
            <div class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-orange-600 bg-orange-50 border border-orange-100 group-hover:scale-110 transition-transform">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Paiements En Attente</p>
                    <p class="text-2xl font-black text-gray-900">{{ $pendingCount }}</p>
                </div>
            </div>

            <!-- RDV confirmés aujourd'hui -->
            <div class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 group-hover:scale-110 transition-transform">
                    <i data-lucide="calendar-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">RDV Confirmés Aujourd'hui</p>
                    <p class="text-2xl font-black text-gray-900">{{ $confirmedCount }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Planning du Jour -->
            <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-sgih-royalblue flex items-center justify-center mr-3">
                            <i data-lucide="calendar-days" class="w-4 h-4"></i>
                        </div>
                        Planning du {{ now()->format('d/m/Y') }}
                    </h3>
                    <span class="px-2.5 py-0.5 bg-blue-50 text-sgih-royalblue rounded-full text-xs font-bold border border-blue-100">
                        {{ count($todayAppointments) }} RDV
                    </span>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50">
                            <tr class="text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                <th class="px-5 py-3">Patient</th>
                                <th class="px-5 py-3">Heure</th>
                                <th class="px-5 py-3 text-right">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($todayAppointments as $rdv)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="font-bold text-gray-900">{{ $rdv->patient->first_name }} {{ $rdv->patient->last_name }}</div>
                                    <div class="text-xs text-gray-400">Dr. {{ $rdv->doctor ? $rdv->doctor->first_name . ' ' . $rdv->doctor->last_name : '—' }}</div>
                                </td>
                                <td class="px-5 py-3 text-gray-700 font-mono text-xs">
                                    {{ \Carbon\Carbon::parse($rdv->appointment_date)->format('H:i') }}
                                </td>
                                <td class="px-5 py-3 text-right">
                                    @if($rdv->status === 'confirmed')
                                        <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold border border-emerald-100">Confirmé</span>
                                    @elseif($rdv->status === 'pending')
                                        <span class="px-2 py-1 bg-orange-50 text-orange-600 rounded-lg text-xs font-bold border border-orange-100">En attente</span>
                                    @elseif($rdv->status === 'completed')
                                        <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-bold">Terminé</span>
                                    @elseif($rdv->status === 'cancelled')
                                        <span class="px-2 py-1 bg-red-50 text-red-500 rounded-lg text-xs font-bold border border-red-100">Annulé</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-5 py-10 text-center">
                                    <div class="flex flex-col items-center text-gray-400">
                                        <i data-lucide="calendar" class="w-10 h-10 mb-2 opacity-40"></i>
                                        <p class="text-sm">Aucun rendez-vous prévu aujourd'hui</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Derniers Patients Enregistrés -->
            <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-cyan-50 text-sgih-cyan flex items-center justify-center mr-3">
                            <i data-lucide="user-check" class="w-4 h-4"></i>
                        </div>
                        Patients Récents
                    </h3>
                    <a href="{{ route('patients.index') }}" class="text-xs font-bold text-sgih-royalblue hover:underline flex items-center gap-1">
                        Voir tous <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50">
                            <tr class="text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                <th class="px-5 py-3">Patient</th>
                                <th class="px-5 py-3">Téléphone</th>
                                <th class="px-5 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($recentPatients as $patient)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs mr-3 {{ $patient->gender == 'Masculin' ? 'bg-blue-100 text-sgih-royalblue' : 'bg-pink-100 text-pink-600' }}">
                                            {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                            <p class="text-xs text-gray-400">PT-{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-gray-600 font-mono text-xs">{{ $patient->phone }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('patients.index') }}" class="text-xs font-bold text-sgih-royalblue hover:underline">
                                        Gérer →
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-5 py-10 text-center text-gray-400 text-sm">Aucun patient enregistré</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-50">
                    <a href="{{ route('patients.create') }}" class="w-full flex items-center justify-center px-4 py-2.5 bg-sgih-royalblue/5 hover:bg-sgih-royalblue hover:text-white text-sgih-royalblue border border-sgih-royalblue/20 rounded-xl font-bold text-sm transition-all">
                        <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                        Enregistrer un Nouveau Patient
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
