<form action="{{ route('hospitalisations.store') }}" method="POST">
    @csrf
    
    <div class="mb-3">
        <label>Sélectionner le Patient</label>
        <select name="patient_id" class="form-control" required>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}">{{ $patient->nom }} {{ $patient->prenom }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Chambre Disponible</label>
        <select name="chambre_id" class="form-control" required>
            @foreach($chambres as $chambre)
                <option value="{{ $chambre->id }}">
                    Chambre N°{{ $chambre->numero_chambre }} ({{ $chambre->type }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Date d'entrée</label>
        <input type="datetime-local" name="date_entree" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Confirmer l'Hospitalisation</button>
</form>