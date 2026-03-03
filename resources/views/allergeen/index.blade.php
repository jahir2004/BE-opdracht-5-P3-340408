<x-app-layout>
    <x-slot name="header">
        <h1 class="display-4 text-center mb-4">Overzicht Allergenen</h1>
    </x-slot>

    <div class="container py-4">

        {{-- Filter form --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('allergenen.index') }}" class="row align-items-end g-3">
                    <div class="col-auto">
                        <label for="allergeen" class="form-label fw-medium">Selecteer allergeen:</label>
                        <select name="allergeen" id="allergeen" class="form-select">
                            <option value="">-- Alle allergenen --</option>
                            @foreach ($allergenen as $allergeen)
                                <option value="{{ $allergeen->Naam }}"
                                    {{ $geselecteerdAllergeen === $allergeen->Naam ? 'selected' : '' }}>
                                    {{ $allergeen->Naam }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Maak selectie</button>
                    </div>
                </form>

                @if ($geselecteerdAllergeen)
                    <p class="mt-2 mb-0 text-muted small">
                        Producten gefilterd op allergeen:
                        <strong class="text-primary">{{ $geselecteerdAllergeen }}</strong>
                    </p>
                @endif
            </div>
        </div>

        {{-- Products table --}}
        <div class="card shadow-sm">
            @if (count($producten) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product naam</th>
                                <th>Barcode</th>
                                <th>Allergeen</th>
                                <th>Omschrijving</th>
                                <th class="text-center">Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producten as $product)
                                <tr>
                                    <td class="fw-medium">{{ $product->ProductNaam }}</td>
                                    <td>{{ $product->Barcode }}</td>
                                    <td>
                                        <span class="badge bg-danger">{{ $product->AllergeenNaam }}</span>
                                    </td>
                                    <td class="text-muted">{{ $product->AllergeenOmschrijving }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('allergenen.leverancier', $product->Id) }}"
                                           title="Leveranciersinformatie voor {{ $product->ProductNaam }}"
                                           class="btn btn-sm btn-outline-primary rounded-circle fw-bold">
                                            ?
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Links --}}
                @if ($producten->hasPages())
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Pagina {{ $producten->currentPage() }} van {{ $producten->lastPage() }}
                                ({{ $producten->total() }} producten, {{ $producten->perPage() }} per pagina)
                            </div>
                            <div>
                                {{ $producten->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="card-body text-center text-muted">
                    Geen producten gevonden
                    @if ($geselecteerdAllergeen)
                        voor allergeen <strong>{{ $geselecteerdAllergeen }}</strong>
                    @endif
                    .
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
