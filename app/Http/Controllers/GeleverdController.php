<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeleverdController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('startdatum');
        $end = $request->input('einddatum');

        $perPage = 4;
        $page = $request->input('page', 1);
        if ($start && $end) {
            $all = DB::select('CALL GetGeleverdeProductenInTijdvak(?, ?)', [$start, $end]);
            if (empty($all)) {
                $all = DB::select('
                    SELECT p.Id as ProductId, p.Naam as ProductNaam, l.Naam as LeverancierNaam, SUM(ppl.Aantal) as TotaalGeleverd
                    FROM ProductPerLeverancier ppl
                    JOIN Product p ON ppl.ProductId = p.Id
                    JOIN Leverancier l ON ppl.LeverancierId = l.Id
                    GROUP BY p.Id, l.Id
                    ORDER BY l.Naam ASC, p.Naam ASC
                ');
            }
        } else {
            $all = DB::select('
                SELECT p.Id as ProductId, p.Naam as ProductNaam, l.Naam as LeverancierNaam, SUM(ppl.Aantal) as TotaalGeleverd
                FROM ProductPerLeverancier ppl
                JOIN Product p ON ppl.ProductId = p.Id
                JOIN Leverancier l ON ppl.LeverancierId = l.Id
                GROUP BY p.Id, l.Id
                ORDER BY l.Naam ASC, p.Naam ASC
            ');
        }
        // Handmatige pagination (omdat DB::select geen Eloquent collection is)
        $total = count($all);
        $offset = ($page - 1) * $perPage;
        $producten = array_slice($all, $offset, $perPage);
        $producten = new \Illuminate\Pagination\LengthAwarePaginator($producten, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);
        return view('geleverd.index', [
            'producten' => $producten,
            'start' => $start,
            'end' => $end
        ]);
    }

    public function overzicht(Request $request)
    {
        $start = $request->input('startdatum');
        $eind = $request->input('einddatum');
        $result = collect();
        if ($start && $eind) {
            $result = collect(DB::select('CALL GetGeleverdeProductenInTijdvak(?, ?)', [$start, $eind]));
        }
        return view('geleverd.overzicht', [
            'geleverdeProducten' => $result,
            'startdatum' => $start,
            'einddatum' => $eind
        ]);
    }

    public function specificatie($productId, Request $request)
    {
        $start = $request->input('startdatum');
        $end = $request->input('einddatum');

        // Haal leveringen van dit product in het tijdsvak op
        $leveringen = [];
        if ($start && $end) {
            $leveringen = DB::select(
                'SELECT DatumLevering, Aantal 
                 FROM ProductPerLeverancier 
                 WHERE ProductId = ? AND DatumLevering BETWEEN ? AND ? 
                 ORDER BY DatumLevering ASC',
                [$productId, $start, $end]
            );
        }

        // Haal productnaam op (optioneel)
        $product = DB::table('Product')->where('Id', $productId)->first();

        return view('geleverd.specificatie', [
            'leveringen' => $leveringen,
            'product' => $product,
            'start' => $start,
            'end' => $end
        ]);
    }
}