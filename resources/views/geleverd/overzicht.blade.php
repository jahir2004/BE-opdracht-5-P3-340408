@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Overzicht Geleverde Producten</h1>
    <form method="GET" action="{{ route('geleverd.overzicht') }}" class="flex gap-4 mb-6">
        <div>
            <label>Startdatum:</label>
            <input type="date" name="startdatum" value="{{ $startdatum }}" class="border rounded p-2">
        </div>
        <div>
            <label>Einddatum:</label>
            <input type="date" name="einddatum" value="{{ $einddatum }}" class="border rounded p-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Maak selectie</button>
    </form>
    @if($geleverdeProducten->count())
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border">Product</th>
                <th class="py-2 px-4 border">Leverancier</th>
                <th class="py-2 px-4 border">Totaal geleverd</th>
            </tr>
        </thead>
        <tbody>
            @foreach($geleverdeProducten as $product)
            <tr>
                <td class="py-2 px-4 border">{{ $product->product_naam }}</td>
                <td class="py-2 px-4 border">{{ $product->leverancier_naam }}</td>
                <td class="py-2 px-4 border">{{ $product->totaal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="bg-gray-100 p-4 rounded text-center mt-4">
        Er zijn geen leveringen geweest van producten in deze periode.
    </div>
    @endif
</div>
@endsection
