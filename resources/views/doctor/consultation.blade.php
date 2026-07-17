<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                <a href="{{ route('doctor.dashboard') }}" class="hover:text-sgih-royalblue transition-colors">Mes Consultations</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900 font-medium">Consultation en cours</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Saisie de Consultation</h1>
            <p class="text-gray-500 mt-1">
                Patient : <span class="font-bold text-sgih-royalblue">{{ $appointment->patient->first_name }} {{ strtoupper($appointment->patient->last_name) }}</span>
                · RDV du {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}
            </p>
        </div>
        <a href="{{ route('doctor.dashboard') }}" class="flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Retour
        </a>
    </div>

    <div class="max-w-3xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden">
            <form action="{{ route('appointments.consultation.store', $appointment) }}" method="POST">
                @csrf
                <div class="p-8 space-y-6">

                    <!-- Symptômes -->
                    <div>
                        <label for="symptoms" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i data-lucide="thermometer" class="w-4 h-4 mr-2 text-orange-500"></i>
                            Symptômes présentés
                        </label>
                        <textarea id="symptoms" name="symptoms" rows="3" required
                                  class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm"
                                  placeholder="Décrire les symptômes signalés par le patient...">{{ old('symptoms') }}</textarea>
                        <x-input-error :messages="$errors->get('symptoms')" class="mt-2" />
                    </div>

                    <!-- Diagnostic -->
                    <div>
                        <label for="diagnosis" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i data-lucide="clipboard-check" class="w-4 h-4 mr-2 text-sgih-royalblue"></i>
                            Diagnostic médical
                        </label>
                        <textarea id="diagnosis" name="diagnosis" rows="3" required
                                  class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm"
                                  placeholder="Entrer le diagnostic du médecin...">{{ old('diagnosis') }}</textarea>
                        <x-input-error :messages="$errors->get('diagnosis')" class="mt-2" />
                    </div>

                    <!-- Prescription & Notes -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="prescription" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-lucide="pill" class="w-4 h-4 mr-2 text-emerald-500"></i>
                                Ordonnance / Prescription
                            </label>
                            <textarea id="prescription" name="prescription" rows="4"
                                      class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm"
                                      placeholder="Médicaments, dosages, durée...">{{ old('prescription') }}</textarea>
                            <x-input-error :messages="$errors->get('prescription')" class="mt-2" />
                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <i data-lucide="sticky-note" class="w-4 h-4 mr-2 text-purple-500"></i>
                                Notes complémentaires
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                      class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm"
                                      placeholder="Observations, suivi, examens à prévoir...">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-between items-center rounded-b-2xl">
                    <p class="text-xs text-gray-500">La consultation sera marquée comme <strong>Terminée</strong> après soumission.</p>
                    <div class="flex gap-3">
                        <a href="{{ route('doctor.dashboard') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" class="flex items-center px-8 py-3 bg-sgih-royalblue text-white rounded-xl font-bold shadow-soft hover:-translate-y-0.5 hover:shadow-lg transition-all">
                            <i data-lucide="check-circle-2" class="w-5 h-5 mr-2"></i>
                            Valider la Consultation
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
