<?php

namespace App\Http\Controllers;

use App\Models\allergeen;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class AllergeenController extends Controller
{
    /**
     * Scenario 01 & 02: Show the allergen overview.
     * Displays all products containing allergens (sorted A-Z).
     * When an allergen is selected and "Maak selectie" is clicked,
     * only the products with that allergen are shown.
     * Pagination: Max 4 records per page.
     */
    public function index(Request $request): View
    {
        $geselecteerdAllergeen = $request->input('allergeen');

        // Get data from stored procedures
        if ($geselecteerdAllergeen) {
            $productenData = allergeen::getProductenOpAllergeen($geselecteerdAllergeen);
        } else {
            $productenData = allergeen::getProductenMetAllergeen();
        }

        // Convert to collection for pagination
        $productenCollection = collect($productenData);
        
        // Pagination settings
        $perPage = 4; // Max 4 records per page as required
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $productenCollection->slice(($currentPage - 1) * $perPage, $perPage);
        
        // Create paginator
        $producten = new LengthAwarePaginator(
            $currentItems->values(), // Items for current page
            $productenCollection->count(), // Total number of items
            $perPage, // Items per page
            $currentPage, // Current page
            [
                'path' => $request->url(),
                'pageName' => 'page',
                'query' => $request->query(), // Preserve query parameters (like allergeen)
            ]
        );

        $allergenen = allergeen::getAllergeensVoorDropdown();

        return view('allergeen.index', [
            'producten'             => $producten,
            'allergenen'            => $allergenen,
            'geselecteerdAllergeen' => $geselecteerdAllergeen,
        ]);
    }

    /**
     * Scenario 02 & 03: Show supplier info for a product.
     * When no address data is available, the view shows
     * "Er is zijn geen adresgegevens bekent".
     */
    public function leverancier(int $productId): View
    {
        $gegevens = allergeen::getLeverancierInfoMetAdresCheck($productId);

        $leverancier  = $gegevens[0] ?? null;
        $geenAdres    = $leverancier && $leverancier->NoAddressData == 1;

        return view('allergeen.leverancier', [
            'leverancier' => $leverancier,
            'geenAdres'   => $geenAdres,
        ]);
    }
}
