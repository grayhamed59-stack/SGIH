<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Service Comptabilité</h1>
                <p class="text-sm text-gray-500">Gestion des facturations et paiements des patients.</p>
            </div>
            <div>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Nouvelle Facture
                </button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        <!-- KPIs Finance -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-green-100 flex items-center space-x-4">
                <div class="bg-green-100 p-4 rounded-2xl text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Revenus Encaissés</p>
                    <p class="text-2xl font-black text-gray-800">{{ number_format($totalRevenue, 0, ',', ' ') }} F</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-orange-100 flex items-center space-x-4">
                <div class="bg-orange-100 p-4 rounded-2xl text-orange-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Paiements en Attente</p>
                    <p class="text-2xl font-black text-gray-800">{{ number_format($pendingRevenue, 0, ',', ' ') }} F</p>
                </div>
            </div>
        </div>

        <!-- Transactions List -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800 tracking-tight">Historique des Transactions</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-50 border-b">
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Patient</th>
                            <th class="px-6 py-4">Description</th>
                            <th class="px-6 py-4">Montant</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-gray-50 transition group">
                            <td class="px-6 py-4 text-sm text-gray-500 font-medium">
                                {{ $payment->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $payment->patient->first_name }} {{ $payment->patient->last_name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $payment->description }}
                            </td>
                            <td class="px-6 py-4 font-black text-gray-800">
                                {{ number_format($payment->amount, 0, ',', ' ') }} F
                            </td>
                            <td class="px-6 py-4">
                                @if($payment->status === 'paid')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Payé</span>
                                @else
                                    <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">En attente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($payment->status === 'pending')
                                <button class="text-sm font-bold text-indigo-600 hover:text-indigo-800">Encaisser</button>
                                @else
                                <button class="text-sm font-bold text-gray-400 hover:text-gray-600">Reçu</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
