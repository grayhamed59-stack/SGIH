<div class="mb-3">
    <label>Médecin prescripteur</label>
    <select name="medecin_id" class="form-control">
        @foreach($medecins as $medecin)
            <option value="{{ $medecin->id }}">Dr. {{ $medecin->nom }} ({{ $medecin->specialite }})</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Médicaments et Posologie</label>
    <textarea name="medicaments" class="form-control" placeholder="Ex: Paracétamol 500mg, 1 mat/soir"></textarea>
</div>