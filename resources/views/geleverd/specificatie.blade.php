<x-app-layout>
    <x-slot name="header">
        <h1 class="display-4 text-center mb-4">
            Specificatie Geleverde Product: {{ $productNaam ?? 'Onbekend' }}
        </h1>
    </x-slot>

    <div class="container py-4">

        {{-- Info card --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <p class="mb-0">
                    <strong>Leverancier:</strong> {{ $leverancierNaam ?? 'Onbekend' }}<br>
                    <strong>Periode:</strong>
                    <span class="text-primary">{{ $start }}</span> t/m <span class="text-primary">{{ $end }}</span>
                </p>
            </div>
        </div>

        {{-- Leveringen tabel --}}
        <div class="card shadow-sm">
            @if (count($leveringen) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Leveringsdatum</th>
                                <th class="text-end">Aantal geleverd</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leveringen as $levering)
                                <tr>
                                    <td>{{ $levering->DatumLevering }}</td>
                                    <td class="text-end">{{ $levering->Aantal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card-body text-center text-muted">
                    Geen leveringen van dit product in deze periode.
                </div>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('geleverd.index', ['startdatum' => $start, 'einddatum' => $end]) }}" class="btn btn-secondary">
                &larr; Terug naar overzicht
            </a>
        </div>
    </div>
</x-app-layout>