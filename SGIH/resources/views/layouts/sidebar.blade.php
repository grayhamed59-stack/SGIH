<div class="flex flex-col w-64 bg-white border-r h-full overflow-y-auto">
    <!-- Logo -->
    <div class="flex items-center justify-start h-16 px-6 border-b">
        <div class="bg-blue-600 p-1.5 rounded-lg mr-3">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-800 leading-tight">HospiCare</h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Portail Hospitalier Unifié</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex-1 px-4 py-6 space-y-2">
        @if(Auth::user()->role === 'superadmin')
            <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-4">Direction</p>
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-bold">Vue Globale</span>
            </a>
            <a href="{{ route('admin.invitations.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.invitations.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                <span class="font-bold">Codes d'accès</span>
            </a>
        @endif

        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
            <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-4">Accueil Médical</p>
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="font-bold">Bureau Réception</span>
            </a>
            <a href="{{ route('patients.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('patients.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="font-bold">Base Patients</span>
            </a>
        @endif

        @if(Auth::user()->role === 'doctor')
            <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-4">Espace Médecin</p>
            <a href="{{ route('doctor.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('doctor.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="font-bold">Mes Consultations</span>
            </a>
        @endif

        @if(Auth::user()->role === 'accountant' || Auth::user()->role === 'superadmin')
            <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-4">Comptabilité</p>
            <a href="{{ route('accountant.dashboard', [], false) }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('accountant.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-bold">Finance & Caisse</span>
            </a>
        @endif
    </div>

    <!-- User Profile (Mali Specific context) -->
    <div class="px-6 py-4 border-t border-gray-100 flex items-center bg-gray-50">
        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3 shadow-sm border border-blue-200">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500 truncate">Personnel Administratif</p>
        </div>
    </div>
</div>
