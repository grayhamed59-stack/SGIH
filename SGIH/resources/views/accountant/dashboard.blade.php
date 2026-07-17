<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-sgih-royalblue transition-colors">SGIH</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900 font-medium">Finance & Caisse</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Service Comptabilité</h1>
            <p class="text-gray-500 mt-1">Gestion des facturations et paiements des patients.</p>
        </div>
        <div>
            <div class="flex gap-3">
                <a href="{{ route('accountant.expenses.create') }}" class="flex items-center px-4 py-2 bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 rounded-xl font-medium shadow-sm transition-colors focus:ring-2 focus:ring-rose-500/50">
                    <i data-lucide="trending-down" class="w-4 h-4 mr-2"></i>
                    Dépense
                </a>
                <a href="{{ route('accountant.payments.create') }}" class="flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium shadow-soft transition-colors focus:ring-2 focus:ring-emerald-500/50">
                    <i data-lucide="receipt" class="w-4 h-4 mr-2"></i>
                    Facture
                </a>
            </div>
        </div>
    </div>

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
        
        @if(session('success'))
        <div class="flex items-center p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 shadow-sm">
            <i data-lucide="check-circle-2" class="w-5 h-5 mr-3 text-emerald-600"></i>
            <p class="font-semibold text-sm">{{ session('success') }}</p>
        </div>
        @endif

        <!-- KPIs Finance -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" x-data="{ showPaid: false, showPending: false, showExpenses: false }">
            <div @click="showPaid = true" class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Revenus Encaissés</p>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-emerald-600 bg-emerald-50 group-hover:scale-110 transition-transform">
                        <i data-lucide="trending-up" class="w-5 h-5"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-gray-900">{{ number_format($totalRevenue, 0, ',', ' ') }} F</p>
            </div>

            <div @click="showPending = true" class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Paiements en Attente</p>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-orange-600 bg-orange-50 group-hover:scale-110 transition-transform">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-gray-900">{{ number_format($pendingRevenue, 0, ',', ' ') }} F</p>
            </div>

            <div @click="showExpenses = true" class="bg-white p-6 rounded-2xl shadow-soft border border-gray-100 flex flex-col hover:shadow-md transition-shadow group cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Dépenses (Charges)</p>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-rose-600 bg-rose-50 group-hover:scale-110 transition-transform">
                        <i data-lucide="trending-down" class="w-5 h-5"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-gray-900">{{ number_format($totalExpenses, 0, ',', ' ') }} F</p>
            </div>

            <div class="bg-gradient-sgih p-6 rounded-2xl shadow-soft flex flex-col hover:shadow-lg transition-shadow group text-white relative overflow-hidden">
                <div class="absolute -right-4 -top-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <i data-lucide="wallet" class="w-32 h-32"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xs font-bold text-blue-100 uppercase tracking-wider">Bénéfice Net</p>
                    </div>
                    <p class="text-3xl font-black">{{ number_format($netProfit, 0, ',', ' ') }} F</p>
                    <p class="text-xs text-blue-200 mt-2 flex items-center">
                        <i data-lucide="info" class="w-3 h-3 mr-1"></i> Revenus - Dépenses
                    </p>
                </div>
            </div>

            <!-- Modals pour les KPI -->
            <x-modal name="paid-modal" show="showPaid">
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Derniers Revenus Encaissés</h2>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach(\App\Models\Payment::with('patient')->where('status', 'paid')->latest()->take(5)->get() as $pay)
                            <div class="p-3 bg-gray-50 rounded-lg flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-sm text-gray-900">{{ $pay->patient->first_name }} {{ $pay->patient->last_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $pay->created_at->format('d/m/Y') }}</p>
                                </div>
                                <span class="font-black text-emerald-600">{{ number_format($pay->amount, 0, ',', ' ') }} F</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button @click="showPaid = false">Fermer</x-secondary-button>
                    </div>
                </div>
            </x-modal>

            <x-modal name="pending-modal" show="showPending">
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Derniers Paiements en Attente</h2>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach(\App\Models\Payment::with('patient')->where('status', 'pending')->latest()->take(5)->get() as $pay)
                            <div class="p-3 bg-gray-50 rounded-lg flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-sm text-gray-900">{{ $pay->patient->first_name }} {{ $pay->patient->last_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $pay->created_at->format('d/m/Y') }}</p>
                                </div>
                                <span class="font-black text-orange-500">{{ number_format($pay->amount, 0, ',', ' ') }} F</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button @click="showPending = false">Fermer</x-secondary-button>
                    </div>
                </div>
            </x-modal>

            <x-modal name="expenses-modal" show="showExpenses">
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Dernières Dépenses</h2>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach(\App\Models\Expense::latest()->take(5)->get() as $exp)
                            <div class="p-3 bg-gray-50 rounded-lg flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-sm text-gray-900">{{ $exp->category }}</p>
                                    <p class="text-xs text-gray-500">{{ $exp->description }}</p>
                                </div>
                                <span class="font-black text-rose-600">-{{ number_format($exp->amount, 0, ',', ' ') }} F</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button @click="showExpenses = false">Fermer</x-secondary-button>
                    </div>
                </div>
            </x-modal>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Entrées (Paiements) -->
            <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden flex flex-col h-full">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mr-3">
                            <i data-lucide="arrow-down-to-line" class="w-4 h-4"></i>
                        </div>
                        Derniers Paiements
                    </h3>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50">
                            <tr class="text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                <th class="px-5 py-3">Patient</th>
                                <th class="px-5 py-3">Description</th>
                                <th class="px-5 py-3">Montant</th>
                                <th class="px-5 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($payments->take(8) as $payment)
                            <tr class="hover:bg-gray-50/50 transition-colors" x-data="{ confirmOpen: false }">
                                <td class="px-5 py-3">
                                    <div class="font-bold text-gray-900 truncate max-w-[130px]">
                                        {{ $payment->patient->first_name }} {{ $payment->patient->last_name }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $payment->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-5 py-3 text-gray-600 text-xs">
                                    {{ $payment->description ?? 'Consultation' }}
                                </td>
                                <td class="px-5 py-3 font-black {{ $payment->status === 'paid' ? 'text-emerald-600' : 'text-orange-500' }}">
                                    {{ number_format($payment->amount, 0, ',', ' ') }} F
                                </td>
                                <td class="px-5 py-3 text-right">
                                    @if($payment->status === 'paid')
                                        <div class="flex items-center justify-end gap-2">
                                            <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold border border-emerald-100">Payé</span>
                                            <a href="{{ route('accountant.payments.receipt', $payment) }}" target="_blank"
                                               class="p-1.5 bg-gray-50 hover:bg-blue-50 text-gray-400 hover:text-sgih-royalblue rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Imprimer le Reçu">
                                                <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                            </a>
                                        </div>
                                    @else
                                        <button @click="confirmOpen = true" type="button"
                                            class="text-xs font-bold text-orange-600 bg-orange-50 hover:bg-orange-500 hover:text-white px-3 py-1.5 rounded-lg transition-all border border-orange-100 flex items-center ml-auto gap-1">
                                            <i data-lucide="banknote" class="w-3.5 h-3.5"></i>
                                            Encaisser
                                        </button>

                                        <!-- Confirmation Modal -->
                                        <div x-show="confirmOpen" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center" @keydown.escape.window="confirmOpen = false">
                                            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="confirmOpen = false"></div>
                                            <div class="relative bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4 border border-gray-100"
                                                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                                                <!-- Icon -->
                                                <div class="flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-2xl mx-auto mb-5">
                                                    <i data-lucide="check-circle" class="w-8 h-8 text-emerald-600"></i>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-900 text-center mb-1">Confirmer l'encaissement</h3>
                                                <p class="text-sm text-gray-500 text-center mb-6">
                                                    Patient : <strong>{{ $payment->patient->first_name }} {{ $payment->patient->last_name }}</strong><br>
                                                    Montant : <strong class="text-emerald-600 text-lg">{{ number_format($payment->amount, 0, ',', ' ') }} F CFA</strong>
                                                </p>
                                                <div class="flex gap-3">
                                                    <button @click="confirmOpen = false" type="button"
                                                        class="flex-1 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">Annuler</button>
                                                    <form action="{{ route('accountant.payments.paid', $payment) }}" method="POST" class="flex-1">
                                                        @csrf @method('PUT')
                                                        <button type="submit"
                                                            class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition-colors shadow-sm flex items-center justify-center gap-2">
                                                            <i data-lucide="check" class="w-4 h-4"></i> Valider
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm">Aucun paiement enregistré</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sorties (Dépenses) -->
            <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden flex flex-col h-full">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center mr-3">
                            <i data-lucide="arrow-up-from-line" class="w-4 h-4"></i>
                        </div>
                        Dernières Dépenses
                    </h3>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50">
                            <tr class="text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                <th class="px-5 py-3">Catégorie</th>
                                <th class="px-5 py-3">Montant</th>
                                <th class="px-5 py-3 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($expenses->take(6) as $expense)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="font-bold text-gray-900 truncate max-w-[150px]">
                                        {{ $expense->category }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-0.5 truncate max-w-[150px]">{{ $expense->description }}</div>
                                </td>
                                <td class="px-5 py-3 font-black text-rose-600">
                                    -{{ number_format($expense->amount, 0, ',', ' ') }} F
                                </td>
                                <td class="px-5 py-3 text-right text-gray-500 text-xs font-medium">
                                    {{ $expense->expense_date->format('d/m/Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-gray-400 text-sm">Aucune dépense enregistrée</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
