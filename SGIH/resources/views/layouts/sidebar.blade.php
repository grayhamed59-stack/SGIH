<!-- Sidebar -->
<aside class="flex flex-col bg-gradient-sgih text-white transition-all duration-300 ease-in-out relative z-20 shadow-xl"
       :class="sidebarOpen ? 'w-64' : 'w-20'">
    
    <!-- Logo Section -->
    <div class="h-20 flex items-center justify-center px-4 border-b border-white/10 shrink-0">
        <div class="flex items-center space-x-3 w-full" :class="!sidebarOpen && 'justify-center'">
            <div class="bg-white/10 p-2 rounded-xl backdrop-blur-sm shrink-0 flex items-center justify-center">
                <i data-lucide="activity" class="w-7 h-7 text-sgih-cyan" x-show="!sidebarOpen"></i>
                <img src="{{ asset('images/SGIHlogo.svg') }}" alt="SGIH" class="h-8 object-contain" x-show="sidebarOpen">
            </div>
        </div>
    </div>

    <!-- Navigation Area -->
    <div class="flex-1 overflow-y-auto py-6 px-3 custom-scrollbar space-y-1">

        @if(Auth::user()->role === 'superadmin')
            <div class="pt-4 pb-1" x-show="sidebarOpen" x-transition.opacity>
                <p class="px-3 text-xs font-semibold text-sgih-cyan uppercase tracking-wider opacity-80">Direction</p>
            </div>
            <a href="{{ route('superadmin.dashboard') }}" 
               class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('superadmin.dashboard') ? 'bg-gradient-active shadow-glow text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
               title="Vue Globale">
                <i data-lucide="bar-chart-2" class="w-5 h-5 shrink-0" :class="!sidebarOpen && 'mx-auto'"></i>
                <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen" x-transition.opacity>Vue Globale</span>
            </a>
            <a href="{{ route('admin.invitations.index') }}" 
               class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.invitations.*') ? 'bg-gradient-active shadow-glow text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
               title="Gestion des employés">
                <i data-lucide="users" class="w-5 h-5 shrink-0" :class="!sidebarOpen && 'mx-auto'"></i>
                <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen" x-transition.opacity>Gestion des employés</span>
            </a>
        @endif

        @if(Auth::user()->role === 'receptionist')
            <div class="pt-4 pb-1" x-show="sidebarOpen" x-transition.opacity>
                <p class="px-3 text-xs font-semibold text-sgih-cyan uppercase tracking-wider opacity-80">Accueil Médical</p>
            </div>
            <a href="{{ route('receptionist.dashboard') }}" 
               class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('receptionist.dashboard') ? 'bg-gradient-active shadow-glow text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
               title="Bureau Réception">
                <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0" :class="!sidebarOpen && 'mx-auto'"></i>
                <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen" x-transition.opacity>Bureau Réception</span>
            </a>
            <a href="{{ route('patients.index') }}" 
               class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('patients.*') ? 'bg-gradient-active shadow-glow text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
               title="Base Patients">
                <i data-lucide="users" class="w-5 h-5 shrink-0" :class="!sidebarOpen && 'mx-auto'"></i>
                <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen" x-transition.opacity>Base Patients</span>
            </a>
        @endif

        @if(Auth::user()->role === 'doctor')
            <div class="pt-4 pb-1" x-show="sidebarOpen" x-transition.opacity>
                <p class="px-3 text-xs font-semibold text-sgih-cyan uppercase tracking-wider opacity-80">Espace Médecin</p>
            </div>
            <a href="{{ route('doctor.dashboard') }}" 
               class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('doctor.dashboard') ? 'bg-gradient-active shadow-glow text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
               title="Mes Consultations">
                <i data-lucide="stethoscope" class="w-5 h-5 shrink-0" :class="!sidebarOpen && 'mx-auto'"></i>
                <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen" x-transition.opacity>Mes Consultations</span>
            </a>
        @endif

        @if(Auth::user()->role === 'accountant')
            <div class="pt-4 pb-1" x-show="sidebarOpen" x-transition.opacity>
                <p class="px-3 text-xs font-semibold text-sgih-cyan uppercase tracking-wider opacity-80">Comptabilité</p>
            </div>
            <a href="{{ route('accountant.dashboard', [], false) }}" 
               class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('accountant.*') ? 'bg-gradient-active shadow-glow text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
               title="Finance & Caisse">
                <i data-lucide="wallet" class="w-5 h-5 shrink-0" :class="!sidebarOpen && 'mx-auto'"></i>
                <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen" x-transition.opacity>Finance & Caisse</span>
            </a>
        @endif

        <div class="h-6"></div> <!-- spacer -->
    </div>
</aside>

<style>
    /* Minimalist custom scrollbar for sidebar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
</style>
