<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-sgih-royalblue transition-colors">SGIH</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="{{ route('accountant.dashboard') }}" class="hover:text-sgih-royalblue transition-colors">Finance</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900 font-medium">Nouvelle Dépense</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Enregistrer une Dépense</h1>
            <p class="text-gray-500 mt-1">Saisissez les charges et décaissements de l'établissement.</p>
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
            <form action="{{ route('accountant.expenses.store') }}" method="POST">
                @csrf
                <div class="p-8 space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="tags" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <select id="category" name="category" required class="block w-full pl-11 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-colors shadow-sm appearance-none">
                                    <option value="">-- Catégorie --</option>
                                    <option value="Équipement Médical" @selected(old('category') == 'Équipement Médical')>Équipement Médical</option>
                                    <option value="Médicaments & Consommables" @selected(old('category') == 'Médicaments & Consommables')>Médicaments & Consommables</option>
                                    <option value="Salaires & Primes" @selected(old('category') == 'Salaires & Primes')>Salaires & Primes</option>
                                    <option value="Factures (Eau, Électricité)" @selected(old('category') == 'Factures (Eau, Électricité)')>Factures (Eau, Électricité)</option>
                                    <option value="Maintenance & Réparation" @selected(old('category') == 'Maintenance & Réparation')>Maintenance & Réparation</option>
                                    <option value="Autre" @selected(old('category') == 'Autre')>Autre</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>
                        
                        <!-- Expense Date -->
                        <div>
                            <label for="expense_date" class="block text-sm font-medium text-gray-700 mb-2">Date de la dépense</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <input id="expense_date" name="expense_date" type="date" required value="{{ old('expense_date', date('Y-m-d')) }}"
                                       class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-colors shadow-sm">
                            </div>
                            <x-input-error :messages="$errors->get('expense_date')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description / Libellé</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="file-text" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <input id="description" name="description" type="text" required value="{{ old('description') }}"
                                   class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-colors shadow-sm"
                                   placeholder="Ex: Achat de 50 boîtes de Paracétamol, Facture électricité Janvier...">
                        </div>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Montant (F CFA)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="banknote" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <input id="amount" name="amount" type="number" min="1" required value="{{ old('amount') }}"
                                       class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-colors shadow-sm font-mono text-rose-600 font-bold"
                                       placeholder="15000">
                            </div>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>
                        
                        <!-- Reference -->
                        <div>
                            <label for="reference" class="block text-sm font-medium text-gray-700 mb-2">Référence (Optionnel)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="hash" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <input id="reference" name="reference" type="text" value="{{ old('reference') }}"
                                       class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-colors shadow-sm"
                                       placeholder="N° Facture / N° Reçu">
                            </div>
                            <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="p-6 border-t border-gray-100 bg-rose-50/30 flex justify-end gap-3 rounded-b-2xl">
                    <a href="{{ route('accountant.dashboard') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="flex items-center px-8 py-3 bg-rose-600 text-white rounded-xl font-bold shadow-soft hover:-translate-y-0.5 hover:shadow-lg transition-all focus:ring-2 focus:ring-rose-500/50">
                        <i data-lucide="trending-down" class="w-5 h-5 mr-2"></i>
                        Enregistrer la Dépense
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
