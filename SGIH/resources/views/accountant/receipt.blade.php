<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }} - {{ $globalHospital->name ?? 'SGIH HospiCare' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans p-8 flex justify-center">

    <!-- Action Bar (Not Printed) -->
    <div class="no-print fixed top-4 right-4 flex space-x-4">
        <a href="{{ route('accountant.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded shadow hover:bg-gray-300 transition">Retour</a>
        <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">Imprimer le Reçu</button>
    </div>

    <!-- Receipt Container -->
    <div class="bg-white w-full max-w-2xl p-10 rounded-xl shadow-lg border border-gray-200 relative">
        
        <!-- Header -->
        <div class="flex justify-between items-start border-b border-gray-200 pb-6 mb-6">
            <div class="flex items-center space-x-4">
                @if(isset($globalHospital) && $globalHospital->logo_path)
                    <img src="{{ Storage::url($globalHospital->logo_path) }}" alt="Logo" class="h-16 object-contain">
                @else
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xl rounded-xl">H</div>
                @endif
                <div>
                    <h1 class="text-2xl font-black text-gray-900 tracking-tight">{{ $globalHospital->name ?? 'Hôpital SGIH' }}</h1>
                    <p class="text-sm text-gray-500">{{ $globalHospital->address ?? 'Adresse de l\'hôpital' }}</p>
                    <p class="text-sm text-gray-500">{{ $globalHospital->phone ?? 'Téléphone' }} | {{ $globalHospital->email ?? 'Email' }}</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-3xl font-light text-gray-400 uppercase tracking-widest mb-1">Reçu</h2>
                <p class="font-bold text-gray-800">#REC-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($payment->updated_at)->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Patient Info -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-1">Patient</p>
                <p class="font-bold text-gray-900 text-lg">{{ $payment->patient->first_name }} {{ strtoupper($payment->patient->last_name) }}</p>
                <p class="text-sm text-gray-600">Code: PT-{{ str_pad($payment->patient->id, 4, '0', STR_PAD_LEFT) }}</p>
                <p class="text-sm text-gray-600">{{ $payment->patient->phone }}</p>
            </div>
            @if($payment->appointment)
            <div class="text-right">
                <p class="text-xs uppercase tracking-wider text-gray-400 font-bold mb-1">Consultation</p>
                <p class="font-medium text-gray-800">Dr. {{ $payment->appointment && $payment->appointment->doctor ? $payment->appointment->doctor->first_name . ' ' . $payment->appointment->doctor->last_name : 'Non assigné' }}</p>
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($payment->appointment->appointment_date)->format('d/m/Y à H:i') }}</p>
            </div>
            @endif
        </div>

        <!-- Table -->
        <table class="w-full text-left mb-8">
            <thead>
                <tr class="border-b-2 border-gray-800 text-gray-800">
                    <th class="py-3 font-bold uppercase text-sm tracking-wider">Description</th>
                    <th class="py-3 font-bold uppercase text-sm tracking-wider text-right">Montant</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr class="border-b border-gray-100">
                    <td class="py-4 font-medium">{{ $payment->description ?? 'Consultation Médicale' }}</td>
                    <td class="py-4 text-right font-mono">{{ number_format($payment->amount, 0, ',', ' ') }} F CFA</td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <div class="flex justify-end mb-10">
            <div class="w-1/2 text-right">
                <div class="flex justify-between items-center py-2 text-lg font-bold text-gray-900 border-t-2 border-gray-800">
                    <span>Total Payé</span>
                    <span class="font-mono text-blue-600">{{ number_format($payment->amount, 0, ',', ' ') }} F CFA</span>
                </div>
            </div>
        </div>

        <!-- Status Stamp -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-10 pointer-events-none">
            <div class="border-4 border-emerald-500 text-emerald-500 rounded-full w-64 h-64 flex items-center justify-center -rotate-12">
                <span class="text-5xl font-black uppercase tracking-widest">Payé</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-200 pt-6 text-center">
            <p class="text-sm text-gray-500 italic mb-2">Merci de votre confiance. Prenez soin de vous.</p>
            <p class="text-xs text-gray-400">Généré le {{ now()->format('d/m/Y H:i') }}</p>
            <div class="mt-4 pt-4 border-t border-dashed border-gray-200 flex items-center justify-center text-xs text-gray-400 space-x-2">
                <span>Powered by</span>
                <span class="font-bold text-blue-600 tracking-wider">SGIH HospiCare</span>
            </div>
        </div>
    </div>

    <!-- Auto-print script -->
    <script>
        window.onload = function() {
            // Uncomment to auto-print
            // window.print();
        }
    </script>
</body>
</html>
