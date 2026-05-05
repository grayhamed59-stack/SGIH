<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Modifier le patient</h1>
                <p class="text-sm text-gray-500">Mise à jour des informations pour {{ $patient->first_name }} {{ $patient->last_name }}.</p>
            </div>
            <a href="{{ route('patients.index') }}" class="text-gray-500 hover:text-gray-700 font-bold text-sm">
                ← Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden text-gray-900">
            <form action="{{ route('patients.update', $patient) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PATCH')
                
                @if(request('from_dashboard'))
                    <input type="hidden" name="from_dashboard" value="1">
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Prénom -->
                    <div>
                        <x-input-label for="first_name" :value="__('Prénom')" />
                        <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" value="{{ old('first_name', $patient->first_name) }}" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <!-- Nom -->
                    <div>
                        <x-input-label for="last_name" :value="__('Nom de famille')" />
                        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" value="{{ old('last_name', $patient->last_name) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date de Naissance -->
                    <div>
                        <x-input-label for="birth_date" :value="__('Date de naissance')" />
                        <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" value="{{ old('birth_date', $patient->birth_date) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                    </div>

                    <!-- Sexe -->
                    <div>
                        <x-input-label for="gender" :value="__('Sexe')" />
                        <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900">
                            <option value="Masculin" @selected(old('gender', $patient->gender) == 'Masculin')>Masculin</option>
                            <option value="Féminin" @selected(old('gender', $patient->gender) == 'Féminin')>Féminin</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Téléphone -->
                    <div>
                        <x-input-label for="phone" :value="__('Téléphone')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', $patient->phone) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <!-- Statut -->
                    <div>
                        <x-input-label for="status" :value="__('Statut actuel')" />
                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900 font-bold">
                            <option value="En attente" @selected(old('status', $patient->status) == 'En attente')>En attente</option>
                            <option value="Actif" @selected(old('status', $patient->status) == 'Actif')>Actif</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    </div>
                </div>

                <!-- Adresse -->
                <div>
                    <x-input-label for="address" :value="__('Adresse')" />
                    <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900">{{ old('address', $patient->address) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <div class="pt-6 border-t flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 transition transform active:scale-95">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
