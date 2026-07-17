<!-- Topbar -->
<nav class="h-20 bg-white/80 backdrop-blur-xl border-b border-gray-100 flex items-center justify-between px-6 lg:px-8 shrink-0 z-10 shadow-sm sticky top-0"
     x-data="{ quickMenuOpen: false }">
    
    <!-- Left Section: Toggle & Breadcrumb -->
    <div class="flex items-center space-x-4">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-sgih-royalblue transition-colors focus:outline-none p-2 rounded-lg hover:bg-blue-50">
            <i data-lucide="menu" class="w-5 h-5" x-show="!sidebarOpen"></i>
            <i data-lucide="align-left" class="w-5 h-5" x-show="sidebarOpen"></i>
        </button>

        <!-- Hospital Selector -->
        <div class="hidden md:flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 cursor-pointer hover:bg-gray-100 transition">
            @if(isset($globalHospital) && $globalHospital->logo_path)
                <img src="{{ asset('storage/' . $globalHospital->logo_path) }}" alt="Logo" class="w-6 h-6 object-contain mr-2">
            @else
                <div class="w-6 h-6 rounded bg-sgih-deepblue text-white flex items-center justify-center text-xs font-bold mr-2">
                    {{ isset($globalHospital) ? strtoupper(substr($globalHospital->name, 0, 1)) : 'H' }}
                </div>
            @endif
            <span class="text-sm font-semibold text-gray-700 truncate max-w-[150px]">{{ $globalHospital->name ?? 'Mon Établissement' }}</span>
            @if(Auth::user()->role === 'superadmin')
                <a href="{{ route('admin.settings.hospital') }}" class="ml-2 text-gray-400 hover:text-sgih-royalblue transition-colors" title="Paramètres de l'établissement">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                </a>
            @endif
        </div>
    </div>

    <!-- Middle Section: Global Search linked to patients -->
    <div class="hidden lg:flex flex-1 max-w-xl mx-8 relative group">
        <form action="{{ route('patients.index') }}" method="GET" class="w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 group-focus-within:text-sgih-royalblue transition-colors"></i>
            </div>
            <input type="text" name="search" placeholder="Rechercher un patient par nom, téléphone... (↵)"
                   class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl leading-5 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-sgih-cyan/50 focus:border-sgih-cyan transition duration-200 sm:text-sm">
        </form>
    </div>

    <!-- Right Section: Actions & Profile -->
    <div class="flex items-center space-x-2 sm:space-x-3">

        <!-- Quick Create Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false"
                    class="hidden sm:flex items-center justify-center bg-sgih-royalblue hover:bg-blue-700 text-white p-2 rounded-lg shadow-sm transition-colors" 
                    title="Création rapide">
                <i data-lucide="plus" class="w-5 h-5"></i>
            </button>
            <!-- Dropdown -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 style="display: none;"
                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                <div class="px-4 py-2 border-b border-gray-50 mb-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Création rapide</p>
                </div>
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('patients.create') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-sgih-royalblue transition-colors">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center mr-3">
                        <i data-lucide="user-plus" class="w-4 h-4 text-sgih-royalblue"></i>
                    </div>
                    Nouveau Patient
                </a>
                @endif
                @if(Auth::user()->role === 'superadmin')
                <a href="{{ route('admin.invitations.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-sgih-royalblue transition-colors">
                    <div class="w-7 h-7 rounded-lg bg-purple-50 flex items-center justify-center mr-3">
                        <i data-lucide="user-cog" class="w-4 h-4 text-purple-600"></i>
                    </div>
                    Inviter un Employé
                </a>
                @endif
                @if(Auth::user()->role === 'accountant')
                <a href="{{ route('accountant.payments.create') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-sgih-royalblue transition-colors">
                    <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center mr-3">
                        <i data-lucide="receipt" class="w-4 h-4 text-emerald-600"></i>
                    </div>
                    Nouvelle Facture
                </a>
                @endif
            </div>
        </div>

        <!-- Notifications -->
        <div class="relative" x-data="{ notifOpen: false }">
            @php
                $unreadNotifications = Auth::user()->unreadNotifications;
                $unreadCount = $unreadNotifications->count();
            @endphp
            <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="text-gray-400 hover:text-sgih-royalblue transition-colors relative p-2 rounded-lg hover:bg-blue-50">
                <i data-lucide="bell" class="w-5 h-5"></i>
                @if($unreadCount > 0)
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
                @endif
            </button>

            <!-- Notifications Dropdown -->
            <div x-show="notifOpen" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 style="display: none;"
                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-50 flex items-center justify-between">
                    <p class="text-sm font-bold text-gray-900">Notifications</p>
                    @if($unreadCount > 0)
                        <form action="{{ route('notifications.readAll') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-sgih-royalblue hover:underline font-medium">Tout marquer comme lu</button>
                        </form>
                    @endif
                </div>
                <div class="max-h-[300px] overflow-y-auto">
                    @forelse($unreadNotifications as $notification)
                        <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-blue-50/50 transition-colors border-b border-gray-50 last:border-0">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <div class="w-8 h-8 rounded-full bg-{{ $notification->data['color'] ?? 'blue' }}-100 text-{{ $notification->data['color'] ?? 'blue' }}-600 flex items-center justify-center">
                                        <i data-lucide="{{ $notification->data['icon'] ?? 'bell' }}" class="w-4 h-4"></i>
                                    </div>
                                </div>
                                <div class="ml-3 w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5 leading-snug">{{ $notification->data['message'] ?? '' }}</p>
                                    <p class="text-[10px] text-gray-400 mt-1 font-medium">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="ml-2 flex-shrink-0 flex">
                                    <div class="w-2 h-2 bg-sgih-cyan rounded-full"></div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-6 text-center">
                            <div class="mx-auto w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center mb-2">
                                <i data-lucide="bell-off" class="w-5 h-5 text-gray-400"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Aucune notification</p>
                            <p class="text-xs text-gray-500 mt-1">Vous êtes à jour !</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="h-8 w-px bg-gray-200 mx-1 hidden sm:block"></div>

        <!-- User Profile Dropdown -->
        <div class="relative" x-data="{ dropdownOpen: false }">
            <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="flex items-center focus:outline-none transition-transform hover:scale-105">
                <div class="text-right mr-3 hidden md:block">
                    <p class="text-sm font-bold text-gray-800 leading-tight">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                    <p class="text-xs text-gray-500 font-medium capitalize">{{ Auth::user()->role ?? 'Admin' }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl border-2 border-white shadow-sm overflow-hidden bg-gradient-sgih text-white flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="dropdownOpen" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50"
                 style="display: none;">
                
                <div class="px-4 py-3 border-b border-gray-50 mb-1">
                    <p class="text-xs text-gray-500">Connecté en tant que</p>
                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email ?? 'user@sgih.com' }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-sgih-royalblue border border-blue-100 mt-1 capitalize">
                        {{ Auth::user()->role ?? 'Admin' }}
                    </span>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-sgih-royalblue transition-colors">
                    <i data-lucide="user" class="w-4 h-4 mr-3"></i> Mon Profil
                </a>

                @if(Auth::user()->role === 'superadmin')
                <a href="{{ route('admin.invitations.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-sgih-royalblue transition-colors">
                    <i data-lucide="key-round" class="w-4 h-4 mr-3"></i> Gérer les Accès
                </a>
                @endif
                
                <div class="border-t border-gray-50 my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4 mr-3"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
