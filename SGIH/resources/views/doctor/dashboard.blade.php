<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Espace Médecin</h1>
                <p class="text-sm text-gray-500">Bienvenue Docteur, voici vos rendez-vous et patients.</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Main Dashboard View (Table simulation) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b flex items-center justify-between bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800 tracking-tight">Vos prochains rendez-vous</h3>
            </div>
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-50 border-b">
                            <th class="px-6 py-4">Patient</th>
                            <th class="px-6 py-4">Date et Heure</th>
                            <th class="px-6 py-4">Motif</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($appointmentsList as $appointment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-700">
                                {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $appointment->reason }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $appointment->status == 'confirmed' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2" x-data="{ openModal: false }">
                                @if($appointment->status !== 'cancelled')
                                <button class="text-blue-600 hover:text-blue-800 font-bold text-xs uppercase mr-2" onclick="alert('Module Consultation à venir !')">Démarrer</button>
                                <button @click="openModal = true" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase">Annuler</button>

                                <!-- Cancellation Modal -->
                                <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="openModal = false">
                                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                        </div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                                            <form action="{{ route('appointments.cancel', $appointment) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Annuler le rendez-vous</h3>
                                                    <p class="text-sm text-gray-500 mb-4">Veuillez indiquer le motif de l'annulation (Obligatoire).</p>
                                                    <textarea name="cancel_reason" required rows="3" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-red-500 focus:border-red-500" placeholder="Ex: Urgence médicale, indisponibilité..."></textarea>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">Confirmer l'annulation</button>
                                                    <button type="button" @click="openModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Retour</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <span class="text-xs font-bold text-gray-400">Raison: {{ $appointment->cancel_reason }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">Aucun rendez-vous prévu.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
