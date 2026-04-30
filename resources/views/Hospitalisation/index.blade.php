@if(!$hosp->date_sortie)
    <form action="{{ route('hospitalisations.sortir', $hosp->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-sm btn-outline-danger">Enregistrer Sortie</button>
    </form>
@else
    <span class="badge bg-secondary">Sorti le {{ \Carbon\Carbon::parse($hosp->date_sortie)->format('d/m/Y') }}</span>
@endif