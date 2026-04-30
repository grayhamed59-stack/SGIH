<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Hôpital Manager</a>
    
        <form class="d-flex ms-auto" action="{{ route('search') }}" method="GET">
            <input class="form-control me-2" type="search" name="q" placeholder="Trouver un patient..." aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Rechercher</button>
        </form>
    </div>
</nav>