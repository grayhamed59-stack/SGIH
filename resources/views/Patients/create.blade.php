@extends('layouts.app') {{-- Si vous avez un layout de base --}}

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
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Enregistrer un nouveau Patient</h4>
        </div>
        <div class="card-body">
            
            {{-- Affichage des erreurs de validation --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patients.store') }}" method="POST">
                @csrf {{-- INDISPENSABLE pour la sécurité dans Laravel --}}

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date_naissance">Date de Naissance</label>
                        <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="genre">Genre</label>
                        <select name="genre" class="form-control" required>
                            <option value="">Sélectionnez...</option>
                            <option value="M" {{ old('genre') == 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('genre') == 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="telephone">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
                </div>

                <div class="mb-3">
                    <label for="adresse">Adresse</label>
                    <textarea name="adresse" class="form-control" rows="3">{{ old('adresse') }}</textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Enregistrer le patient</button>
                    <a href="{{ route('patients.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection