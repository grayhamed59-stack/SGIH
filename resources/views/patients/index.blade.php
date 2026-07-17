<x-app-layout>
    <div x-data="{ 
        showActionModal: false, 
        showCreateModal: false,
        patientId: null,
        patientName: '',
        patientCode: '',
        activeTab: 'lab', /* lab, admit, appoint */
        openModal(id, name, gender) {
            this.patientId = id;
            this.patientName = name;
            this.patientCode = 'PT-' + String(id).padStart(4, '0');
            this.showActionModal = true;
        }
    }">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-sgih-royalblue transition-colors">SGIH</a>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    <span class="text-gray-900 font-medium">Gestion des patients</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Base Patients</h1>
                <p class="text-gray-500 mt-1">Consultez, recherchez et gérez les dossiers des patients enregistrés.</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors focus:ring-2 focus:ring-sgih-cyan/50">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2 text-gray-500"></i>
                    Retour
                </a>
                <a href="{{ route('patients.export', request()->only('search')) ?? '#' }}" class="hidden sm:flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors focus:ring-2 focus:ring-sgih-cyan/50" download>
                    <i data-lucide="download" class="w-4 h-4 mr-2 text-gray-500"></i>
                    Exporter
                </a>
                <button type="button" @click="showCreateModal = true" class="flex items-center px-4 py-2 bg-sgih-royalblue hover:bg-blue-700 text-white rounded-xl font-medium shadow-soft transition-colors focus:ring-2 focus:ring-blue-500/50">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Nouveau patient
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 flex items-center p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 shadow-sm animate-in fade-in slide-in-from-top-2">
            <i data-lucide="check-circle-2" class="w-5 h-5 mr-3 text-emerald-600"></i>
            <p class="font-semibold text-sm">{{ session('success') }}</p>
        </div>
        @endif

        <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
            
            <!-- Search and Filter Bar -->
            <div class="bg-white p-4 rounded-2xl shadow-soft border border-gray-100 flex flex-col sm:flex-row items-center gap-4">
                <form action="{{ route('patients.index') }}" method="GET" class="flex-1 w-full relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-5 h-5 text-gray-400 group-focus-within:text-sgih-cyan transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom, téléphone, ID..." 
                           class="block w-full pl-11 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition duration-200 sm:text-sm">
                    @if(request('search'))
                    <a href="{{ route('patients.index') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                    @endif
                </form>
                
                <!-- Filter Dropdown Simulation -->
                <div class="relative w-full sm:w-auto" x-data="{ filterOpen: false }">
                    <button @click="filterOpen = !filterOpen" @click.away="filterOpen = false" type="button" class="w-full sm:w-auto px-6 py-3 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 flex items-center justify-center transition-colors">
                        <i data-lucide="filter" class="w-4 h-4 mr-2"></i>
                        Filtrer
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-2 text-gray-400"></i>
                    </button>
                    <div x-show="filterOpen" style="display:none;" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-20">
                        <a href="{{ route('patients.index', ['status' => 'Actif']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-emerald-600">🟢 Patients Actifs</a>
                        <a href="{{ route('patients.index', ['status' => 'Hospitalisé']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-purple-600">🛏️ Hospitalisés</a>
                        <a href="{{ route('patients.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 font-bold border-t border-gray-100 mt-1">🔄 Réinitialiser</a>
                    </div>
                </div>
            </div>

            <!-- Patients Table -->
            <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50">
                            <tr class="text-xs uppercase tracking-wider text-gray-500 font-semibold border-b border-gray-100">
                                <th class="px-6 py-4">Patient</th>
                                <th class="px-6 py-4">Âge</th>
                                <th class="px-6 py-4">Téléphone</th>
                                <th class="px-6 py-4">Statut</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($patients as $patient)
                            <tr class="hover:bg-blue-50/50 transition-colors group">
                                <td class="px-6 py-4 cursor-pointer" @click="openModal({{ $patient->id }}, '{{ addslashes($patient->first_name . ' ' . $patient->last_name) }}', '{{ $patient->gender }}')">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm mr-4 {{ $patient->gender == 'Masculin' ? 'bg-blue-100 text-sgih-royalblue' : 'bg-pink-100 text-pink-600' }}">
                                            {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 group-hover:text-sgih-royalblue transition-colors">{{ $patient->first_name }} {{ strtoupper($patient->last_name) }}</p>
                                            <p class="text-xs text-gray-500 flex items-center mt-0.5">
                                                ID: #PT-{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }} 
                                                <span class="mx-1">•</span> 
                                                {{ $patient->gender }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    <div class="flex items-center">
                                        <i data-lucide="calendar" class="w-4 h-4 text-gray-400 mr-2"></i>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($patient->birth_date)->age }} ans</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    <div class="flex items-center">
                                        <i data-lucide="phone" class="w-4 h-4 text-gray-400 mr-2"></i>
                                        <span class="font-medium font-mono">{{ $patient->phone }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($patient->status == 'Actif')
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100 inline-flex items-center">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span> Actif
                                        </span>
                                    @elseif($patient->status == 'Hospitalisé')
                                        <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-xs font-bold border border-purple-100 inline-flex items-center">
                                            <span class="w-1.5 h-1.5 bg-purple-500 rounded-full mr-1.5"></span> Hospitalisé
                                        </span>
                                    @elseif($patient->status == 'En attente')
                                        <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-xs font-bold border border-orange-100 inline-flex items-center">
                                            <span class="w-1.5 h-1.5 bg-orange-500 rounded-full mr-1.5"></span> En attente
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold border border-gray-200 inline-flex items-center">
                                            <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></span> {{ $patient->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <!-- Actions Modal Trigger -->
                                        <button type="button" @click="openModal({{ $patient->id }}, '{{ addslashes($patient->first_name . ' ' . $patient->last_name) }}', '{{ $patient->gender }}')" class="p-2 text-white bg-sgih-royalblue hover:bg-blue-700 rounded-lg transition-colors shadow-soft hover:-translate-y-0.5" title="Actions Rapides">
                                            <i data-lucide="zap" class="w-4 h-4 fill-current"></i>
                                        </button>
                                        
                                        <a href="{{ route('patients.edit', $patient) }}" class="p-2 text-gray-400 hover:text-sgih-cyan bg-gray-50 hover:bg-cyan-50 rounded-lg transition-colors border border-transparent hover:border-cyan-100" title="Modifier">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </a>
                                        
                                        <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir archiver ce dossier patient ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Archiver">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i data-lucide="users" class="w-12 h-12 mb-3 opacity-50"></i>
                                        <p class="text-lg font-medium text-gray-500">Aucun patient trouvé</p>
                                        <p class="text-sm mt-1">Modifiez votre recherche ou ajoutez un nouveau patient.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if(method_exists($patients, 'links') && $patients->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $patients->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- MODAL D'ACTIONS RAPIDES -->
        <div x-show="showActionModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="showActionModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-sgih-deepblue/60 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="showActionModal" @click.away="showActionModal = false"
                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-white/20">
                        
                        <!-- Modal Header -->
                        <div class="bg-gradient-sgih px-6 py-6 border-b border-white/10 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-md shadow-inner text-white font-black text-lg">
                                    <span x-text="patientName.charAt(0)"></span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white tracking-tight leading-tight" x-text="patientName"></h3>
                                    <p class="text-blue-100 text-sm flex items-center mt-0.5">
                                        <i data-lucide="hash" class="w-3 h-3 mr-1"></i> <span x-text="patientCode"></span>
                                    </p>
                                </div>
                            </div>
                            <button @click="showActionModal = false" class="text-white/70 hover:text-white transition-colors bg-white/10 hover:bg-white/20 rounded-full p-2 focus:outline-none">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>

                        <!-- Modal Body : Action Cards (Tabs) -->
                        <div class="p-6 bg-gray-50">
                            <!-- Cards Row -->
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <!-- Card: Appoint -->
                                <div @click="activeTab = 'appoint'" 
                                     class="cursor-pointer rounded-xl p-4 border-2 transition-all duration-200 hover:-translate-y-1 shadow-sm flex flex-col items-center justify-center gap-2 text-center"
                                     :class="activeTab === 'appoint' ? 'border-sgih-cyan bg-white ring-2 ring-sgih-cyan/20' : 'border-gray-200 bg-white hover:border-cyan-300'">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-1"
                                         :class="activeTab === 'appoint' ? 'bg-cyan-100 text-sgih-cyan' : 'bg-gray-100 text-gray-500'">
                                        <i data-lucide="calendar-plus" class="w-6 h-6"></i>
                                    </div>
                                    <h4 class="font-bold" :class="activeTab === 'appoint' ? 'text-sgih-cyan' : 'text-gray-700'">Nouveau RDV</h4>
                                    <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Consultation</p>
                                </div>
                                <!-- Card: Lab -->
                                <div @click="activeTab = 'lab'" 
                                     class="cursor-pointer rounded-xl p-4 border-2 transition-all duration-200 hover:-translate-y-1 shadow-sm flex flex-col items-center justify-center gap-2 text-center"
                                     :class="activeTab === 'lab' ? 'border-sgih-royalblue bg-white ring-2 ring-sgih-royalblue/20' : 'border-gray-200 bg-white hover:border-blue-300'">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-1"
                                         :class="activeTab === 'lab' ? 'bg-sgih-royalblue/10 text-sgih-royalblue' : 'bg-gray-100 text-gray-500'">
                                        <i data-lucide="flask-conical" class="w-6 h-6"></i>
                                    </div>
                                    <h4 class="font-bold" :class="activeTab === 'lab' ? 'text-sgih-royalblue' : 'text-gray-700'">Demande d'Analyse</h4>
                                    <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Laboratoire</p>
                                </div>

                                <!-- Card: Admit -->
                                <div @click="activeTab = 'admit'" 
                                     class="cursor-pointer rounded-xl p-4 border-2 transition-all duration-200 hover:-translate-y-1 shadow-sm flex flex-col items-center justify-center gap-2 text-center"
                                     :class="activeTab === 'admit' ? 'border-purple-500 bg-white ring-2 ring-purple-500/20' : 'border-gray-200 bg-white hover:border-purple-300'">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-1"
                                         :class="activeTab === 'admit' ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-500'">
                                        <i data-lucide="bed-double" class="w-6 h-6"></i>
                                    </div>
                                    <h4 class="font-bold" :class="activeTab === 'admit' ? 'text-purple-600' : 'text-gray-700'">Admettre Patient</h4>
                                    <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Hospitalisation</p>
                                </div>
                            </div>

                            <!-- Forms Container -->
                            <div class="bg-white rounded-xl shadow-inner border border-gray-100 p-6">
                                
                                <!-- FORM 0: RENDEZ-VOUS -->
                                <form x-show="activeTab === 'appoint'" style="display: none;" action="{{ route('patients.appointment.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="patient_id" :value="patientId">
                                    <h4 class="font-bold text-sgih-cyan mb-4 flex items-center border-b pb-2">
                                        <i data-lucide="calendar-clock" class="w-5 h-5 mr-2 text-sgih-cyan"></i> Planifier une Consultation
                                    </h4>
                                    
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Médecin</label>
                                                <select name="doctor_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-cyan focus:border-sgih-cyan text-sm">
                                                    <option value="">Sélectionner un médecin</option>
                                                    @foreach($doctors ?? [] as $doctor)
                                                        <option value="{{ $doctor->id }}">Dr. {{ $doctor->first_name . ' ' . $doctor->last_name }} ({{ $doctor->specialty }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Date et Heure</label>
                                                <input type="datetime-local" name="appointment_date" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-cyan focus:border-sgih-cyan text-sm">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tarif de la consultation (F CFA)</label>
                                            <input type="number" name="amount" value="15000" min="1" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-cyan focus:border-sgih-cyan text-sm font-bold text-gray-900" placeholder="Ex: 15000">
                                            <p class="text-xs text-orange-600 mt-1"><i data-lucide="info" class="w-3 h-3 inline"></i> Une facture sera générée et mise en attente de paiement à la caisse.</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Motif du RDV</label>
                                            <textarea name="reason" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-cyan focus:border-sgih-cyan text-sm" placeholder="Raison de la visite..."></textarea>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex justify-end">
                                        <button type="submit" class="px-6 py-2.5 bg-sgih-cyan text-white rounded-lg font-bold shadow-md hover:-translate-y-0.5 hover:shadow-lg transition-all flex items-center">
                                            <i data-lucide="check" class="w-4 h-4 mr-2"></i> Créer RDV & Facture
                                        </button>
                                    </div>
                                </form>

                                <!-- FORM 1: DEMANDE LABO -->
                                <form x-show="activeTab === 'lab'" action="{{ route('patients.lab.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="patient_id" :value="patientId">
                                    <h4 class="font-bold text-gray-800 mb-4 flex items-center border-b pb-2">
                                        <i data-lucide="microscope" class="w-5 h-5 mr-2 text-sgih-royalblue"></i> Prescription d'Analyse
                                    </h4>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Type d'examen</label>
                                            <select name="test_type" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue text-sm">
                                                <option value="Bilan Sanguin (NFS)">Bilan Sanguin (NFS)</option>
                                                <option value="Glycémie">Glycémie à jeun</option>
                                                <option value="Échographie">Échographie abdominale</option>
                                                <option value="Radiologie (Rayon X)">Radiologie (Rayon X)</option>
                                                <option value="Test Paludisme (Goutte épaisse)">Test Paludisme</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Motif / Notes cliniques</label>
                                            <textarea name="notes" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue text-sm" placeholder="Renseignements cliniques pertinents..."></textarea>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex justify-end">
                                        <button type="submit" class="px-6 py-2.5 bg-sgih-royalblue text-white rounded-lg font-bold shadow-md hover:-translate-y-0.5 hover:shadow-lg transition-all flex items-center">
                                            <i data-lucide="send" class="w-4 h-4 mr-2"></i> Envoyer au Labo
                                        </button>
                                    </div>
                                </form>

                                <!-- FORM 2: ADMISSION -->
                                <form x-show="activeTab === 'admit'" style="display: none;" action="{{ route('patients.admit.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="patient_id" :value="patientId">
                                    <h4 class="font-bold text-purple-700 mb-4 flex items-center border-b pb-2">
                                        <i data-lucide="stethoscope" class="w-5 h-5 mr-2 text-purple-600"></i> Dossier d'Hospitalisation
                                    </h4>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Chambre (Optionnel)</label>
                                            <input type="text" name="room_number" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 text-sm font-mono" placeholder="Ex: CH-104">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Motif d'admission</label>
                                            <textarea name="reason" rows="2" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 text-sm" placeholder="Raison médicale de l'hospitalisation..."></textarea>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex justify-end">
                                        <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white rounded-lg font-bold shadow-md hover:-translate-y-0.5 hover:shadow-lg transition-all flex items-center">
                                            <i data-lucide="bed" class="w-4 h-4 mr-2"></i> Valider l'Admission
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- FIN MODAL ACTIONS -->

        <!-- MODAL NOUVEAU PATIENT -->
        <div x-show="showCreateModal" style="display: none;" class="relative z-50" aria-labelledby="modal-create" role="dialog" aria-modal="true">
            <div x-show="showCreateModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-sgih-deepblue/60 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="showCreateModal" @click.away="showCreateModal = false"
                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-white/20">
                        
                        <!-- Modal Header -->
                        <div class="bg-gradient-sgih px-6 py-4 border-b border-white/10 flex items-center justify-between">
                            <h3 class="text-xl font-bold text-white tracking-tight flex items-center">
                                <i data-lucide="user-plus" class="w-5 h-5 mr-2"></i> Nouveau Patient
                            </h3>
                            <button @click="showCreateModal = false" type="button" class="text-white/70 hover:text-white transition-colors bg-white/10 hover:bg-white/20 rounded-full p-2 focus:outline-none">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6">
                            <form action="{{ route('patients.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                        <input type="text" name="last_name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                        <input type="text" name="first_name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de Naissance</label>
                                        <input type="date" name="birth_date" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                                        <select name="gender" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue text-sm">
                                            <option value="Masculin">Masculin</option>
                                            <option value="Féminin">Féminin</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                        <input type="text" name="phone" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut initial</label>
                                        <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue text-sm">
                                            <option value="Actif">Actif</option>
                                            <option value="En attente">En attente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                    <textarea name="address" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue text-sm"></textarea>
                                </div>
                                
                                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                                    <button type="button" @click="showCreateModal = false" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium shadow-sm hover:bg-gray-50 transition-colors">
                                        Annuler
                                    </button>
                                    <button type="submit" class="px-5 py-2.5 bg-sgih-royalblue text-white rounded-lg font-bold shadow-md hover:bg-blue-700 hover:-translate-y-0.5 transition-all flex items-center">
                                        <i data-lucide="check" class="w-4 h-4 mr-2"></i> Enregistrer le Patient
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN MODAL NOUVEAU PATIENT -->
</x-app-layout>
