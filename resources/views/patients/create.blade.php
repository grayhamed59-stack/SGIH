<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-sgih-royalblue transition-colors">SGIH</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="{{ route('patients.index') }}" class="hover:text-sgih-royalblue transition-colors">Base Patients</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900 font-medium">Nouveau Patient</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Ajouter un patient</h1>
            <p class="text-gray-500 mt-1">Créez un nouveau dossier médical en remplissant les informations ci-dessous.</p>
        </div>
        <div>
            <a href="{{ route('patients.index') }}" class="flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors focus:ring-2 focus:ring-sgih-cyan/50">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2 text-gray-500"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="max-w-4xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden text-gray-900">
            <form action="{{ route('patients.store') }}" method="POST">
                @csrf
                
                <div class="p-8 space-y-8">
                    <!-- Section: Informations Personnelles -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 flex items-center mb-4">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-sgih-royalblue flex items-center justify-center mr-3">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </div>
                            Informations Personnelles
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                            <!-- Prénom -->
                            <div>
                                <x-input-label for="first_name" :value="__('Prénom')" class="mb-1.5" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    <input id="first_name" name="first_name" type="text" class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm" value="{{ old('first_name') }}" required autofocus placeholder="Ex: Moussa" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>

                            <!-- Nom -->
                            <div>
                                <x-input-label for="last_name" :value="__('Nom de famille')" class="mb-1.5" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    <input id="last_name" name="last_name" type="text" class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm" value="{{ old('last_name') }}" required placeholder="Ex: Traoré" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                            </div>

                            <!-- Date de Naissance -->
                            <div>
                                <x-input-label for="birth_date" :value="__('Date de naissance')" class="mb-1.5" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    <input id="birth_date" name="birth_date" type="date" class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm" value="{{ old('birth_date') }}" required />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                            </div>

                            <!-- Sexe -->
                            <div>
                                <x-input-label for="gender" :value="__('Sexe')" class="mb-1.5" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-lucide="users" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    <select id="gender" name="gender" class="block w-full pl-11 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm appearance-none">
                                        <option value="Masculin" @selected(old('gender') == 'Masculin')>Masculin</option>
                                        <option value="Féminin" @selected(old('gender') == 'Féminin')>Féminin</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Contact & Administration -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 flex items-center mb-4">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center mr-3">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            Contact & Administration
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                            <!-- Téléphone -->
                            <div>
                                <x-input-label for="phone" :value="__('Téléphone')" class="mb-1.5" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-lucide="phone" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    <input id="phone" name="phone" type="text" class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm font-mono" value="{{ old('phone') }}" placeholder="+223 70 00 00 00" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <!-- Statut -->
                            <div>
                                <x-input-label for="status" :value="__('Statut initial')" class="mb-1.5" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-lucide="activity" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    <select id="status" name="status" class="block w-full pl-11 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 font-semibold focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm appearance-none">
                                        <option value="En attente" @selected(old('status') == 'En attente')>En attente (Nouvelle admission)</option>
                                        <option value="Actif" @selected(old('status') == 'Actif')>Actif (En traitement)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <!-- Adresse -->
                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Adresse (Quartier, Ville)')" class="mb-1.5" />
                                <div class="relative">
                                    <div class="absolute top-3 left-0 pl-4 flex items-start pointer-events-none">
                                        <i data-lucide="map" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    <textarea id="address" name="address" rows="3" class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition-colors shadow-sm" placeholder="Ex: ACI 2000, Bamako">{{ old('address') }}</textarea>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('address')" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
                    <a href="{{ route('patients.index') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="flex items-center px-8 py-3 bg-sgih-royalblue text-white rounded-xl font-bold shadow-soft hover:-translate-y-0.5 hover:shadow-lg transition-all focus:ring-2 focus:ring-blue-500/50">
                        <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                        Enregistrer le dossier
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
