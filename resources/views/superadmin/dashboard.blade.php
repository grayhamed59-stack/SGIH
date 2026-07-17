<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-sgih-royalblue transition-colors">SGIH</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900 font-medium">Direction</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Vue de Direction</h1>
            <p class="text-gray-500 mt-1">Supervision globale de l'établissement SGIH HospiCare.</p>
        </div>
        <div>
            <a href="{{ route('admin.invitations.index') }}" class="flex items-center px-4 py-2 bg-sgih-royalblue hover:bg-blue-700 text-white rounded-xl font-medium shadow-soft transition-colors focus:ring-2 focus:ring-blue-500/50">
                <i data-lucide="key" class="w-4 h-4 mr-2"></i>
                Générer Code d'Accès
            </a>
        </div>
    </div>

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
        
        <!-- KPIs de Direction -->
        <!-- KPIs de Direction -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" x-data="{ showPatients: false, showDoctors: false, showAppointments: false }">
            <!-- Revenus (Lien vers Comptabilité) -->
            <a href="{{ route('accountant.dashboard') }}" class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow group cursor-pointer">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 group-hover:scale-110 transition-transform">
                    <i data-lucide="banknote" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Revenu Journalier</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($revenue, 0, ',', ' ') }} F</p>
                </div>
            </a>

            <!-- Total Patients -->
            <div @click="showPatients = true" class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow group cursor-pointer">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-sgih-cyan bg-cyan-50 border border-cyan-100 group-hover:scale-110 transition-transform">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Patients</p>
                    <p class="text-2xl font-black text-gray-900">{{ $patientsCount }}</p>
                </div>
            </div>

            <!-- Médecins Actifs -->
            <div @click="showDoctors = true" class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow group cursor-pointer">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-sgih-royalblue bg-blue-50 border border-blue-100 group-hover:scale-110 transition-transform">
                    <i data-lucide="stethoscope" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Médecins Actifs</p>
                    <p class="text-2xl font-black text-gray-900">{{ $doctorsCount }}</p>
                </div>
            </div>

            <!-- RDV Prévus -->
            <div @click="showAppointments = true" class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow group cursor-pointer">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-purple-600 bg-purple-50 border border-purple-100 group-hover:scale-110 transition-transform">
                    <i data-lucide="calendar" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">RDV Prévus</p>
                    <p class="text-2xl font-black text-gray-900">{{ $appointmentsCount }}</p>
                </div>
            </div>

            <!-- Modals pour les KPI -->
            <x-modal name="patients-modal" show="showPatients">
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Aperçu des derniers patients</h2>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach(\App\Models\Patient::latest()->take(5)->get() as $patient)
                            <div class="p-3 bg-gray-50 rounded-lg flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-sm text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $patient->phone ?? 'Aucun téléphone' }}</p>
                                </div>
                                <a href="{{ route('patients.index') }}" class="text-xs text-sgih-royalblue font-bold hover:underline">Voir</a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button @click="showPatients = false">Fermer</x-secondary-button>
                    </div>
                </div>
            </x-modal>

            <x-modal name="doctors-modal" show="showDoctors">
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Liste des médecins</h2>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach(\App\Models\Doctor::all() as $doc)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="font-bold text-sm text-gray-900">Dr. {{ $doc->first_name . ' ' . $doc->last_name }}</p>
                                <p class="text-xs text-gray-500">{{ $doc->specialty }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button @click="showDoctors = false">Fermer</x-secondary-button>
                    </div>
                </div>
            </x-modal>

            <x-modal name="appointments-modal" show="showAppointments">
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Prochains RDV</h2>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach(\App\Models\Appointment::with(['patient', 'doctor'])->where('appointment_date', '>=', today())->orderBy('appointment_date')->take(5)->get() as $apt)
                            <div class="p-3 bg-gray-50 rounded-lg flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-sm text-gray-900">{{ $apt->patient->first_name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y H:i') }}</p>
                                </div>
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-lg">{{ $apt->status }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button @click="showAppointments = false">Fermer</x-secondary-button>
                    </div>
                </div>
            </x-modal>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Points à Améliorer / Insight Système -->
            <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center mr-3">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        </div>
                        Points à Améliorer
                    </h3>
                </div>
                <div class="p-6 space-y-6 flex-1">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <span class="w-2 h-2 bg-red-500 rounded-full inline-block"></span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-gray-900">Suivi des Annulations</p>
                            <p class="text-sm text-gray-500 mt-1">Un total de {{ $cancellationsCount }} rendez-vous ont été annulés. Veillez à consulter les motifs fournis par les médecins.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full inline-block"></span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-gray-900">Volume Financier Global</p>
                            <p class="text-sm text-gray-500 mt-1">Le système a enregistré un volume total de {{ number_format($totalRevenue, 0, ',', ' ') }} F encaissés depuis l'installation.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Présence des Médecins -->
            <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-sgih-royalblue flex items-center justify-center mr-3">
                            <i data-lucide="user-check" class="w-4 h-4"></i>
                        </div>
                        Présence des Médecins
                    </h3>
                </div>
                <div class="p-6 space-y-4 flex-1">
                    @foreach(\App\Models\Doctor::take(3)->get() as $doctor)
                    <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-sgih-cyan/30 hover:bg-cyan-50/10 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-sgih-royalblue border border-blue-100 flex items-center justify-center font-bold mr-4">
                                {{ substr($doctor->first_name, 0, 1) }}{{ substr($doctor->last_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 group-hover:text-sgih-royalblue transition-colors">Dr. {{ $doctor->last_name }}</p>
                                <p class="text-xs text-gray-500">{{ $doctor->specialty }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100 flex items-center">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> En poste
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
