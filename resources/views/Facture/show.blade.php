<div class="card p-4">
    <h3 class="text-center">FACTURE GLOBALE</h3>
    <hr>
    <p><strong>Patient :</strong> {{ $facture->hospitalisation->patient->nom }}</p>
    <p><strong>Chambre :</strong> {{ $facture->hospitalisation->chambre->numero_chambre }}</p>
    
    <table class="table">
        <tr>
            <td>Frais de séjour ({{ $nbJours }} jours)</td>
            <td class="text-end">{{ number_format($facture->montant_chambre, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <td>Avance versée</td>
            <td class="text-end text-danger">- {{ number_format($facture->hospitalisation->frais_avance, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr class="table-dark">
            <th>TOTAL À PAYER</th>
            <th class="text-end">{{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA</th>
        </tr>
    </table>
</div>