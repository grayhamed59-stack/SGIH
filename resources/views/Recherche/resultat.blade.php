@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Résultats pour : "{{ $q }}"</h4>
    <p>{{ $results->count() }} patient(s) trouvé(s)</p>

    <div class="list-group mt-3">
        @forelse($results as $patient)
            <a href="{{ route('patients.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ strtoupper($patient->nom) }} {{ $patient->prenom }}</strong><br>
                    <small class="text-muted">📞 {{ $patient->telephone ?? 'Pas de numéro' }}</small>
                </div>
                <span class="badge bg-primary rounded-pill">Voir fiche</span>
            </a>
        @empty
            <div class="alert alert-warning">Aucun patient ne correspond à votre recherche.</div>
        @endforelse
    </div>
</div>
@endsection