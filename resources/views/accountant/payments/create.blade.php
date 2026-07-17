<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-sgih-royalblue transition-colors">SGIH</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="{{ route('accountant.dashboard') }}" class="hover:text-sgih-royalblue transition-colors">Finance</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900 font-medium">Nouvelle Facture</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Créer une Facture</h1>
            <p class="text-gray-500 mt-1">Enregistrez un nouveau paiement pour un patient.</p>
        </div>
        <div>
            <a href="{{ route('accountant.dashboard') }}" class="flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors focus:ring-2 focus:ring-sgih-cyan/50">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2 text-gray-500"></i>
                Retour
            </a>
        </div>
    </div>

    <div class="max-w-2xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden">
            <form action="{{ route('accountant.payments.store') }}" method="POST">
                @csrf
                <div class="p-8 space-y-6">
                    <!-- Patient -->
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Patient concerné</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <select id="patient_id" name="patient_id" required class="block w-full pl-11 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm appearance-none">
                                <option value="">-- Sélectionner un patient --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" @selected(old('patient_id') == $patient->id)>
                                        {{ $patient->first_name }} {{ strtoupper($patient->last_name) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('patient_id')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description de la prestation</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="file-text" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <input id="description" name="description" type="text" required value="{{ old('description') }}"
                                   class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm"
                                   placeholder="Ex: Consultation générale, Analyse sanguine, Radiologie...">
                        </div>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Amount & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Montant (F CFA)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="banknote" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <input id="amount" name="amount" type="number" min="1" required value="{{ old('amount') }}"
                                       class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm font-mono"
                                       placeholder="15000">
                            </div>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut du paiement</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="credit-card" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <select id="status" name="status" required class="block w-full pl-11 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 font-semibold focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm appearance-none">
                                    <option value="paid" @selected(old('status') == 'paid')>✅ Payé (Encaissé)</option>
                                    <option value="pending" @selected(old('status') == 'pending')>⏳ En attente</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
                    <a href="{{ route('accountant.dashboard') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="flex items-center px-8 py-3 bg-emerald-600 text-white rounded-xl font-bold shadow-soft hover:-translate-y-0.5 hover:shadow-lg transition-all focus:ring-2 focus:ring-emerald-500/50">
                        <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                        Enregistrer la Facture
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
