@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des Patients</h2>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un Patient
        </a>
    </div>

    {{-- Message de succès après enregistrement --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom & Prénom</th>
                        <th>Genre</th>
                        <th>Date de Naissance</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $patient->id }}</td>
                            <td>{{ strtoupper($patient->nom) }} {{ $patient->prenom }}</td>
                            <td>
                                <span class="badge {{ $patient->genre == 'M' ? 'bg-info' : 'bg-danger' }}">
                                    {{ $patient->genre }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($patient->date_naissance)->format('d/m/Y') }}</td>
                            <td>{{ $patient->telephone ?? 'Non renseigné' }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning">Modifier</a>
                                <button class="btn btn-sm btn-danger">Supprimer</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucun patient enregistré pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection