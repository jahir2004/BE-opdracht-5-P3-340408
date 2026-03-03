<x-app-layout>
    <x-slot name="header">
        <h1 class="display-4 text-center mb-4">Overzicht Leverancier Gegevens</h1>
    </x-slot>

    <div class="container py-4">

        <a href="{{ route('allergenen.index') }}" class="btn btn-link text-decoration-none mb-3 ps-0">
            ← Terug naar Overzicht Allergenen
        </a>

        @if ($leverancier)
            <div class="card shadow-sm mb-4">
                <div class="card-body bg-light">
                    <h5 class="mb-0 fw-semibold">
                        Leverancier van: <span class="text-primary">{{ $leverancier->ProductNaam ?? 'N/A' }}</span>
                    </h5>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary bg-opacity-10 text-primary fw-semibold text-uppercase small">
                    Leveranciersinformatie
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex gap-3">
                        <span class="text-muted" style="width:150px">Naam Leverancier</span>
                        <span>{{ $leverancier->LeverancierNaam ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex gap-3">
                        <span class="text-muted" style="width:150px">Contactpersoon</span>
                        <span>{{ $leverancier->ContactPersoon ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex gap-3">
                        <span class="text-muted" style="width:150px">Mobiel</span>
                        <span>{{ $leverancier->Mobiel ?? 'N/A' }}</span>
                    </li>
                    @if ($leverancier->Stad ?? false)
                    <li class="list-group-item d-flex gap-3">
                        <span class="text-muted" style="width:150px">Stad</span>
                        <span>{{ $leverancier->Stad }}</span>
                    </li>
                    @endif
                </ul>
            </div>

            @if ($geenAdres)
                <div class="alert alert-warning mb-0">
                    ⚠️ Er zijn geen adresgegevens bekend voor deze leverancier.
                </div>
            @endif

        @else
            <div class="card shadow-sm">
                <div class="card-body text-center text-muted">
                    Er zijn geen leveranciergegevens bekend voor dit product.
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
