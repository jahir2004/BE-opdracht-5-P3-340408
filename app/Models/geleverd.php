<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class geleverd extends Model
{
    protected $table = 'geleverd';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['bestelling_id', 'datum', 'tijd'];

    public function bestelling()
    {
        return $this->belongsTo(bestelling::class, 'bestelling_id');
    }

    public static function getAllGeleverd()
    {
        return self::with('bestelling')->get();
    }

    public function index(Request $request)
    {
        $start = $request->input('startdatum');
        $end = $request->input('einddatum');

        // Huidige producten-overzicht (zoals je nu hebt)
        if ($start && $end) {
            $producten = DB::select('CALL GetGeleverdeProductenInTijdvak(?, ?)', [$start, $end]);
        } else {
            $producten = DB::select('
                SELECT p.Id as ProductId, p.Naam as ProductNaam, l.Naam as LeverancierNaam, SUM(ppl.Aantal) as TotaalGeleverd
                FROM ProductPerLeverancier ppl
                JOIN Product p ON ppl.ProductId = p.Id
                JOIN Leverancier l ON ppl.LeverancierId = l.Id
                GROUP BY p.Id, l.Id
                ORDER BY l.Naam ASC, p.Naam ASC
            ');
        }

        // Extra: alle rijen uit de tabel 'geleverd' via het model
        $alleGeleverd = geleverd::getAllGeleverd();

        return view('geleverd.index', [
            'producten' => $producten,
            'alleGeleverd' => $alleGeleverd,
            'start' => $start,
            'end' => $end
        ]);
    }
}