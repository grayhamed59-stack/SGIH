<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                <a href="#" class="hover:text-sgih-royalblue transition-colors">SGIH</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900 font-medium">Tableau de bord</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                Bonjour, {{ explode(' ', Auth::user()->name ?? 'Dr. Admin')[0] }} 👋
            </h1>
            <p class="text-gray-500 mt-1">Voici un aperçu des activités de votre établissement aujourd'hui.</p>
        </div>

        <div class="flex items-center space-x-3">
            <button class="flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors focus:ring-2 focus:ring-sgih-cyan/50">
                <i data-lucide="calendar" class="w-4 h-4 mr-2 text-gray-500"></i>
                Aujourd'hui, {{ now()->translatedFormat('d M Y') }}
                <i data-lucide="chevron-down" class="w-4 h-4 ml-2 text-gray-400"></i>
            </button>
            <a href="{{ route('patients.index') ?? '#' }}" class="flex items-center px-4 py-2 bg-sgih-royalblue hover:bg-blue-700 text-white rounded-xl font-medium shadow-soft transition-colors focus:ring-2 focus:ring-blue-500/50">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Nouveau patient
            </a>
        </div>
    </div>

    <!-- Quick Actions (Glassmorphism Cards) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <a href="#" class="glassmorphism p-4 rounded-2xl flex flex-col items-center justify-center text-center group hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-sgih-royalblue flex items-center justify-center mb-3 group-hover:bg-sgih-royalblue group-hover:text-white transition-colors">
                <i data-lucide="user-plus" class="w-6 h-6"></i>
            </div>
            <span class="font-semibold text-gray-800 text-sm">Admettre Patient</span>
        </a>
        <a href="#" class="glassmorphism p-4 rounded-2xl flex flex-col items-center justify-center text-center group hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 rounded-full bg-cyan-50 text-sgih-cyan flex items-center justify-center mb-3 group-hover:bg-sgih-cyan group-hover:text-white transition-colors">
                <i data-lucide="calendar-plus" class="w-6 h-6"></i>
            </div>
            <span class="font-semibold text-gray-800 text-sm">Planifier RDV</span>
        </a>
        <a href="#" class="glassmorphism p-4 rounded-2xl flex flex-col items-center justify-center text-center group hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center mb-3 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                <i data-lucide="microscope" class="w-6 h-6"></i>
            </div>
            <span class="font-semibold text-gray-800 text-sm">Demande Labo</span>
        </a>
        <a href="#" class="glassmorphism p-4 rounded-2xl flex flex-col items-center justify-center text-center group hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center mb-3 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                <i data-lucide="receipt" class="w-6 h-6"></i>
            </div>
            <span class="font-semibold text-gray-800 text-sm">Générer Facture</span>
        </a>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-sm font-semibold text-gray-500">TOTAL PATIENTS</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $patientsCount ?? '1,245' }}</h3>
                </div>
                <div class="p-3 bg-blue-50 text-sgih-royalblue rounded-xl">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="flex items-center text-sm relative z-10">
                <span class="flex items-center text-emerald-600 font-semibold bg-emerald-50 px-2 py-0.5 rounded-md">
                    <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i> +12%
                </span>
                <span class="text-gray-400 ml-2">ce mois</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-cyan-50 to-transparent rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-sm font-semibold text-gray-500">CONSULTATIONS</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $appointmentsCount ?? '156' }}</h3>
                </div>
                <div class="p-3 bg-cyan-50 text-sgih-cyan rounded-xl">
                    <i data-lucide="stethoscope" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="flex items-center text-sm relative z-10">
                <span class="flex items-center text-emerald-600 font-semibold bg-emerald-50 px-2 py-0.5 rounded-md">
                    <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i> +8%
                </span>
                <span class="text-gray-400 ml-2">cette semaine</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-orange-50 to-transparent rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-sm font-semibold text-gray-500">LITS DISPONIBLES</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">42<span class="text-lg text-gray-400 font-normal">/150</span></h3>
                </div>
                <div class="p-3 bg-orange-50 text-orange-500 rounded-xl">
                    <i data-lucide="bed-double" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-4">
                <div class="bg-orange-500 h-1.5 rounded-full" style="width: 72%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2 text-right">Taux d'occupation 72%</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-gradient-sgih p-6 rounded-2xl shadow-soft relative overflow-hidden group text-white">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-sm font-medium text-blue-100">REVENUS (AUJOURD'HUI)</p>
                    <h3 class="text-3xl font-bold mt-1">1.2M <span class="text-lg font-normal opacity-80">FCFA</span></h3>
                </div>
                <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                    <i data-lucide="wallet" class="w-6 h-6 text-white"></i>
                </div>
            </div>
            <div class="flex items-center text-sm relative z-10">
                <span class="flex items-center text-white font-semibold bg-white/20 px-2 py-0.5 rounded-md">
                    <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i> +4.5%
                </span>
                <span class="text-blue-100 ml-2">vs hier</span>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Area Chart: Admissions Trend -->
        <div class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Tendance des Admissions</h3>
                <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-sgih-cyan focus:border-sgih-cyan block p-2">
                    <option>7 derniers jours</option>
                    <option>Ce mois</option>
                    <option>Cette année</option>
                </select>
            </div>
            <div id="admissionsChart" class="h-72 w-full"></div>
        </div>

        <!-- Donut Chart: Departments -->
        <div class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Répartition par Service</h3>
                <button class="text-gray-400 hover:text-sgih-royalblue">
                    <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                </button>
            </div>
            <div id="departmentsChart" class="h-64 w-full flex justify-center mt-4"></div>
            <div class="mt-4 flex justify-center">
                <a href="#" class="text-sm font-semibold text-sgih-royalblue flex items-center hover:underline">
                    <i data-lucide="bar-chart" class="w-4 h-4 mr-1"></i> Voir détails statistiques
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-gray-900">Activité récente des patients</h3>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                    <input type="text" placeholder="Rechercher..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-sgih-cyan focus:border-sgih-cyan w-full md:w-64">
                </div>
                <button class="p-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-xs uppercase tracking-wider text-gray-500 font-semibold border-b border-gray-100">
                        <th class="px-6 py-4 rounded-tl-2xl">Patient</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Médecin assigné</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 rounded-tr-2xl text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($recentPatients ?? [1,2,3,4,5] as $patient)
                    @php
                        // Mock data for the visual representation if real data is missing properties
                        $mockNames = ['Awa Traoré', 'Mamadou Diarra', 'Fatoumata Sissoko', 'Ibrahim Coulibaly', 'Adama Maïga'];
                        $mockTypes = ['Consultation', 'Examen', 'Hospitalisation', 'Consultation', 'Rendez-vous'];
                        $mockDoctors = ['Dr. Diallo', 'Dr. Konaté', 'Dr. Camara', 'Dr. Traoré', 'Dr. Keïta'];
                        $mockStatus = ['Terminée', 'En cours', 'Hospitalisé', 'Terminée', 'Programmé'];
                        
                        $name = is_object($patient) ? $patient->first_name . ' ' . $patient->last_name : $mockNames[$loop->index % 5];
                        $initials = strtoupper(substr(explode(' ', $name)[0], 0, 1) . (isset(explode(' ', $name)[1]) ? substr(explode(' ', $name)[1], 0, 1) : ''));
                        $type = is_object($patient) && isset($patient->type) ? $patient->type : $mockTypes[$loop->index % 5];
                        $doc = is_object($patient) && isset($patient->doctor) ? $patient->doctor : $mockDoctors[$loop->index % 5];
                        $status = is_object($patient) ? $patient->status : $mockStatus[$loop->index % 5];
                        $date = is_object($patient) ? $patient->created_at->format('d/m/Y') : now()->subDays($loop->index)->format('d/m/Y');
                    @endphp
                    <tr class="hover:bg-blue-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-9 h-9 rounded-full bg-blue-100 text-sgih-royalblue flex items-center justify-center font-bold text-xs mr-3">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $name }}</p>
                                    <p class="text-xs text-gray-500">ID: #PT-{{ is_object($patient) ? str_pad($patient->id, 4, '0', STR_PAD_LEFT) : '00'.($loop->index+1) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-medium">{{ $type }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            <div class="flex items-center">
                                <div class="w-6 h-6 rounded-full bg-gray-200 mr-2 overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($doc) }}&color=4B5563&background=E5E7EB" alt="Dr">
                                </div>
                                {{ $doc }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $date }}</td>
                        <td class="px-6 py-4">
                            @if($status == 'Terminée')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100">Terminée</span>
                            @elseif($status == 'En cours')
                                <span class="px-3 py-1 bg-blue-50 text-sgih-royalblue rounded-full text-xs font-bold border border-blue-100">En cours</span>
                            @elseif($status == 'Hospitalisé')
                                <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-xs font-bold border border-orange-100">Hospitalisé</span>
                            @else
                                <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-xs font-bold border border-purple-100">Programmé</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="p-1.5 text-gray-400 hover:text-sgih-royalblue bg-white rounded shadow-sm border border-gray-200" title="Voir dossier">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="p-1.5 text-gray-400 hover:text-sgih-cyan bg-white rounded shadow-sm border border-gray-200" title="Éditer">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </button>
                                <button class="p-1.5 text-gray-400 hover:text-red-500 bg-white rounded shadow-sm border border-gray-200" title="Supprimer">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i data-lucide="inbox" class="w-12 h-12 mb-3 opacity-50"></i>
                                <p class="text-lg font-medium text-gray-500">Aucune donnée récente</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100 bg-gray-50/30">
            {{ $recentPatients->links() }}
        </div>
    </div>

    <!-- Script for Charts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Options for Area Chart (Admissions Trend)
            var areaOptions = {
                series: [{
                    name: 'Patients Actifs',
                    data: [{{ \App\Models\Patient::where('status', 'Actif')->count() * 10 }}, {{ \App\Models\Patient::where('status', 'Actif')->count() * 12 }}, {{ \App\Models\Patient::where('status', 'Actif')->count() * 15 }}, {{ \App\Models\Patient::where('status', 'Actif')->count() * 18 }}, {{ \App\Models\Patient::where('status', 'Actif')->count() * 20 }}, {{ \App\Models\Patient::where('status', 'Actif')->count() * 25 }}, {{ \App\Models\Patient::where('status', 'Actif')->count() * 30 }}]
                }, {
                    name: 'En Attente',
                    data: [{{ \App\Models\Patient::where('status', 'En attente')->count() * 5 }}, {{ \App\Models\Patient::where('status', 'En attente')->count() * 7 }}, {{ \App\Models\Patient::where('status', 'En attente')->count() * 8 }}, {{ \App\Models\Patient::where('status', 'En attente')->count() * 6 }}, {{ \App\Models\Patient::where('status', 'En attente')->count() * 9 }}, {{ \App\Models\Patient::where('status', 'En attente')->count() * 11 }}, {{ \App\Models\Patient::where('status', 'En attente')->count() * 14 }}]
                }],
                chart: {
                    height: 280,
                    type: 'area',
                    fontFamily: 'Inter, sans-serif',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                colors: ['#1565D8', '#18D4CF'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    categories: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#9ca3af' } }
                },
                yaxis: {
                    labels: { style: { colors: '#9ca3af' } }
                },
                grid: {
                    borderColor: '#f3f4f6',
                    strokeDashArray: 4,
                },
                legend: { position: 'top', horizontalAlign: 'right' }
            };

            var areaChart = new ApexCharts(document.querySelector("#admissionsChart"), areaOptions);
            areaChart.render();

            // Options for Donut Chart (Departments)
            var donutOptions = {
                series: [{{ \App\Models\Doctor::where('specialty', 'Cardiologue')->count() * 10 + 20 }}, {{ \App\Models\Doctor::where('specialty', 'Pédiatre')->count() * 10 + 35 }}, {{ \App\Models\Doctor::where('specialty', 'Gynécologue')->count() * 10 + 15 }}, 30],
                chart: {
                    type: 'donut',
                    height: 250,
                    fontFamily: 'Inter, sans-serif',
                },
                labels: ['Cardiologie', 'Pédiatrie', 'Gynécologie', 'Médecine Générale'],
                colors: ['#1565D8', '#18D4CF', '#f97316', '#8b5cf6', '#9ca3af'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                name: { show: true, color: '#6b7280' },
                                value: {
                                    show: true,
                                    fontSize: '24px',
                                    fontWeight: 700,
                                    color: '#111827'
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function (w) {
                                        return "1,245"
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { width: 0 },
                legend: { show: false } // We can build custom legend if needed, hiding for clean look
            };

            var donutChart = new ApexCharts(document.querySelector("#departmentsChart"), donutOptions);
            donutChart.render();
        });
    </script>
</x-app-layout>
