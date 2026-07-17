<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-sgih-royalblue transition-colors">SGIH</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900 font-medium">Espace Médical</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Mes Consultations</h1>
            <p class="text-gray-500 mt-1">Patients dont le paiement a été confirmé — prêts pour la consultation.</p>
        </div>
    </div>

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <!-- Main Dashboard View -->
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden">
            <div class="p-6 border-b flex items-center justify-between bg-white">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-sgih-royalblue flex items-center justify-center mr-3">
                        <i data-lucide="calendar-check" class="w-4 h-4"></i>
                    </div>
                    Salle d'attente — Paiement confirmé
                    <span class="ml-3 px-2.5 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">
                        {{ count($appointmentsList) }} patient(s)
                    </span>
                </h3>
            </div>
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4">Patient</th>
                            <th class="px-6 py-4">Date et Heure</th>
                            <th class="px-6 py-4">Motif</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($appointmentsList as $appointment)
                        <tr class="hover:bg-blue-50/50 transition-colors group">
                            <td class="px-6 py-4 font-bold text-gray-900 group-hover:text-sgih-royalblue transition-colors">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-3 text-xs text-gray-500">
                                        {{ substr($appointment->patient->first_name, 0, 1) }}{{ substr($appointment->patient->last_name, 0, 1) }}
                                    </div>
                                    {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                <div class="flex items-center">
                                    <i data-lucide="clock" class="w-4 h-4 text-gray-400 mr-2"></i>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $appointment->reason }}
                            </td>
                            <td class="px-6 py-4">
                                @if($appointment->status == 'confirmed')
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100 flex items-center inline-flex w-fit">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> Confirmé
                                    </span>
                                @elseif($appointment->status == 'cancelled')
                                    <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold border border-red-100 flex items-center inline-flex w-fit">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Annulé
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-xs font-bold border border-orange-100 flex items-center inline-flex w-fit">
                                        <span class="w-1.5 h-1.5 bg-orange-500 rounded-full mr-1.5"></span> {{ $appointment->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right" x-data="{ openModal: false }">
                                <div class="flex justify-end space-x-2">
                                    @if($appointment->status !== 'cancelled' && $appointment->status !== 'completed')
                                        <a href="{{ route('appointments.consultation.start', $appointment) }}" class="px-3 py-1.5 bg-sgih-royalblue/10 text-sgih-royalblue hover:bg-sgih-royalblue hover:text-white rounded-lg font-semibold text-xs transition-colors flex items-center">
                                            <i data-lucide="play" class="w-3 h-3 mr-1"></i> Démarrer
                                        </a>
                                        <button @click="openModal = true" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg font-semibold text-xs transition-colors flex items-center">
                                            <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i> Annuler
                                        </button>

                                        <!-- Cancellation Modal -->
                                        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                <div class="fixed inset-0 transition-opacity" aria-hidden="true" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="openModal = false"></div>
                                                </div>
                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                                    <form action="{{ route('appointments.cancel', $appointment) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="bg-white px-6 pt-6 pb-4">
                                                            <div class="flex items-center justify-between mb-4">
                                                                <h3 class="text-xl font-bold text-gray-900">Annuler le rendez-vous</h3>
                                                                <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-500">
                                                                    <i data-lucide="x" class="w-5 h-5"></i>
                                                                </button>
                                                            </div>
                                                            <p class="text-sm text-gray-500 mb-4">Veuillez indiquer le motif de l'annulation (Obligatoire).</p>
                                                            <textarea name="cancel_reason" required rows="3" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition-colors shadow-sm" placeholder="Ex: Urgence médicale, indisponibilité..."></textarea>
                                                        </div>
                                                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-100">
                                                            <button type="button" @click="openModal = false" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors">Retour</button>
                                                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl font-bold shadow-soft hover:bg-red-700 transition-colors">Confirmer l'annulation</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg flex items-center" title="{{ $appointment->cancel_reason }}">
                                            <i data-lucide="info" class="w-3 h-3 mr-1"></i> Raison indiquée
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i data-lucide="clock" class="w-12 h-12 mb-3 opacity-50"></i>
                                    <p class="text-lg font-medium text-gray-500">Aucun patient en attente de consultation</p>
                                    <p class="text-sm mt-1 text-gray-400">Les patients apparaissent ici une fois leur paiement confirmé à la caisse.</p>
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
