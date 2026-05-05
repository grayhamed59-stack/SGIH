<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Vue de Direction</h1>
                <p class="text-sm text-gray-500">Supervision globale de l'établissement SGIH HospiCare.</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.invitations.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    Générer Code d'Accès
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        <!-- KPIs de Direction -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Revenus (Simulation) -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-green-100 flex items-center space-x-4">
                <div class="bg-green-100 p-4 rounded-2xl text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Revenu Journalier</p>
                    <p class="text-2xl font-black text-gray-800">{{ number_format($revenue, 0, ',', ' ') }} F</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
                <div class="bg-blue-100 p-4 rounded-2xl text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Patients</p>
                    <p class="text-2xl font-black text-gray-800">{{ $patientsCount }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
                <div class="bg-indigo-100 p-4 rounded-2xl text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Médecins Actifs</p>
                    <p class="text-2xl font-black text-gray-800">{{ $doctorsCount }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
                <div class="bg-purple-100 p-4 rounded-2xl text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">RDV Prévus</p>
                    <p class="text-2xl font-black text-gray-800">{{ $appointmentsCount }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Points à Améliorer / Insight Système -->
            <div class="bg-white rounded-3xl shadow-sm border border-orange-100 overflow-hidden">
                <div class="p-6 border-b border-orange-50 bg-orange-50/50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-orange-800 tracking-tight flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Points à Améliorer
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <span class="w-2 h-2 bg-red-500 rounded-full inline-block"></span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-gray-800">Suivi des Annulations</p>
                            <p class="text-xs text-gray-500 mt-1">Un total de {{ $cancellationsCount }} rendez-vous ont été annulés. Veillez à consulter les motifs fournis par les médecins.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-gray-800">Volume Financier Global</p>
                            <p class="text-xs text-gray-500 mt-1">Le système a enregistré un volume total de {{ number_format($totalRevenue, 0, ',', ' ') }} F encaissés depuis l'installation.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Présence des Médecins -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800 tracking-tight">Présence des Médecins (Aujourd'hui)</h3>
                </div>
                <div class="p-6 space-y-4">
                    @foreach(\App\Models\Doctor::take(3)->get() as $doctor)
                    <div class="flex items-center justify-between border-b pb-3 last:border-0 last:pb-0">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3">
                                {{ substr($doctor->first_name, 0, 1) }}{{ substr($doctor->last_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Dr. {{ $doctor->last_name }}</p>
                                <p class="text-xs text-gray-500">{{ $doctor->specialty }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md">En poste</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
