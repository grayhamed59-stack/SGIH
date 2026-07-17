<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Paramètres de l'Établissement</h1>
            <p class="text-gray-500 mt-2">Personnalisez l'identité visuelle et les coordonnées de votre hôpital. Ces informations apparaîtront sur les factures, reçus et l'interface de vos collaborateurs.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 shadow-sm">
                <i data-lucide="check-circle-2" class="w-5 h-5 mr-3 text-emerald-600"></i>
                <p class="font-semibold text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden">
            <div class="p-6 sm:p-8">
                <form action="{{ route('admin.settings.hospital.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Left Column: Logo -->
                        <div class="col-span-1 flex flex-col items-center">
                            <label class="block text-sm font-semibold text-gray-700 mb-4 text-center">Logo de l'établissement</label>
                            
                            <div class="relative w-48 h-48 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center overflow-hidden group hover:border-sgih-royalblue transition-colors">
                                @if($setting->logo_path)
                                    <img src="{{ asset('storage/' . $setting->logo_path) }}" alt="Logo Hôpital" class="w-full h-full object-contain p-2">
                                @else
                                    <div class="text-center p-4">
                                        <i data-lucide="image" class="w-10 h-10 mx-auto text-gray-400 group-hover:text-sgih-royalblue transition-colors mb-2"></i>
                                        <span class="text-xs text-gray-500">Aucun logo (SVG, PNG, JPG)</span>
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer" onclick="document.getElementById('logo_upload').click()">
                                    <span class="text-white text-sm font-bold flex items-center"><i data-lucide="upload" class="w-4 h-4 mr-2"></i> Changer</span>
                                </div>
                            </div>
                            <input type="file" id="logo_upload" name="logo" class="hidden" accept="image/png, image/jpeg, image/svg+xml">
                            @error('logo') <span class="text-xs text-red-500 mt-2">{{ $message }}</span> @enderror
                        </div>

                        <!-- Right Column: Infos -->
                        <div class="col-span-1 md:col-span-2 space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de la clinique / Hôpital <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="building-2" class="w-5 h-5 text-gray-400"></i>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name', $setting->name) }}" required class="pl-10 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue sm:text-sm h-11">
                                </div>
                                @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="map-pin" class="w-5 h-5 text-gray-400"></i>
                                    </div>
                                    <input type="text" name="address" value="{{ old('address', $setting->address) }}" class="pl-10 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue sm:text-sm h-11">
                                </div>
                                @error('address') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i data-lucide="phone" class="w-5 h-5 text-gray-400"></i>
                                        </div>
                                        <input type="text" name="phone" value="{{ old('phone', $setting->phone) }}" class="pl-10 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue sm:text-sm h-11">
                                    </div>
                                    @error('phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email de contact</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                                        </div>
                                        <input type="email" name="email" value="{{ old('email', $setting->email) }}" class="pl-10 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-sgih-royalblue focus:border-sgih-royalblue sm:text-sm h-11">
                                    </div>
                                    @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                        <p class="text-xs text-gray-400 flex items-center">
                            <i data-lucide="info" class="w-4 h-4 mr-1"></i> Modifié le {{ $setting->updated_at->format('d/m/Y à H:i') }}
                        </p>
                        <button type="submit" class="px-8 py-3 bg-sgih-royalblue hover:bg-blue-700 text-white font-bold rounded-xl shadow-soft hover:shadow-lg transition-all hover:-translate-y-0.5 flex items-center">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i> Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
