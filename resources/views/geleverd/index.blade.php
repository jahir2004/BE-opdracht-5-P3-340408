<x-app-layout>
    <x-slot name="header">
        <h1 class="display-4 text-center mb-4">Overzicht Geleverde Producten</h1>
    </x-slot>

    <div class="container py-4">

        {{-- Filter form --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('geleverd.index') }}" class="row align-items-end g-3">
                    <div class="col-auto">
                        <label for="startdatum" class="form-label fw-medium">Startdatum:</label>
                        <input type="date" name="startdatum" id="startdatum" class="form-control" value="{{ $start }}">
                    </div>
                    <div class="col-auto">
                        <label for="einddatum" class="form-label fw-medium">Einddatum:</label>
                        <input type="date" name="einddatum" id="einddatum" class="form-control" value="{{ $end }}">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Maak selectie</button>
                    </div>
                </form>

                @if ($start && $end)
                    <p class="mt-2 mb-0 text-muted small">
                        Geleverde producten van <strong class="text-primary">{{ $start }}</strong> t/m <strong class="text-primary">{{ $end }}</strong>
                    </p>
                @endif
            </div>
        </div>

        {{-- Products table --}}
        <div class="card shadow-sm">
            @if ($producten->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product naam</th>
                                <th>Leverancier</th>
                                <th class="text-end">Totaal geleverd</th>
                                <th class="text-center">Specificatie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producten as $product)
                                <tr>
                                    <td class="fw-medium">{{ $product->ProductNaam ?? '-' }}</td>
                                    <td>{{ $product->LeverancierNaam ?? '-' }}</td>
                                    <td class="text-end">{{ $product->TotaalGeleverd ?? '-' }}</td>
                                    <td class="text-center">
                                        @if(isset($product->ProductId))
                                        <a href="{{ route('geleverd.specificatie', $product->ProductId) }}"
                                           title="Specificatie voor {{ $product->ProductNaam ?? '' }}"
                                           class="btn btn-sm btn-outline-primary rounded-circle fw-bold">
                                            ?
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card-body text-center text-muted">
                    Er zijn geen leveringen geweest van producten in deze periode.
                </div>
            @endif
            <div class="mt-3 d-flex justify-content-center">
                {{ $producten->withQueryString()->links() }}
            </div>
        </div>

    </div>
</x-app-layout>