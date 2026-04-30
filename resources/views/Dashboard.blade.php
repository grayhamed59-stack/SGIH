@extends('layouts.app')

@section('content')
<style>
    /* Styles spécifiques à cette page */
    .card { border-radius: 10px; transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }
    .card-body h1 { font-size: 2.2rem; font-weight: bold; }
    .table thead th { background-color: #343a40; color: white; }
    .table tbody tr:hover { background-color: rgba(0,0,0,.05); }
    .bg-custom-info { background-color: #17a2b8; color: white; }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold">Tableau de Bord Hospitalier</h2>
        <span class="badge badge-dark">Mise à jour : {{ now()->format('d/m/Y H:i') }}</span>
    </div>

    <!-- Section des Statistiques -->
    <div class="row">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h6 class="text-uppercase small">Patients</h6>
                    <h1>{{ $totalPatients }}</h1>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h6 class="text-uppercase small">Médecins</h6>
                    <h1>{{ $totalMedecins }}</h1>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body">
                    <h6 class="text-uppercase small">Occupation Lits</h6>
                    <h1>{{ $chambresOccupees }} / {{ $totalChambres }}</h1>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <h6 class="text-uppercase small">Recettes (FCFA)</h6>
                    <h1>{{ number_format($revenusTotal, 0, ',', ' ') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Tableau des Admissions -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                    <span>Dernières Admissions</span>
                    <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body p-0"> <!-- p-0 pour que le tableau colle aux bords -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Chambre</th>
                                    <th>Date d'entrée</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dernieresHosp as $hosp)
                                    <tr>
                                        <td class="font-weight-bold">{{ $hosp->patient->nom }} {{ $hosp->patient->prenom }}</td>
                                        <td><span class="badge badge-light border">{{ $hosp->chambre->numero_chambre }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($hosp->date_entree)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge {{ $hosp->statut == 'en cours' ? 'badge-success' : 'badge-secondary' }}">
                                                {{ ucfirst($hosp->statut) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Aucune admission récente.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection