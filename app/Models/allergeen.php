<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class allergeen extends Model
{
    protected $table = 'Allergeen';

    public $timestamps = false;

    protected $fillable = ['Naam', 'Omschrijving'];

    /**
     * Get all allergens for the dropdown (stored procedure).
     */
    public static function getAllergeensVoorDropdown(): array
    {
        return DB::select('CALL sp_GetAllAllergensForDropdown()');
    }

    /**
     * Get all products that contain any allergen, sorted A-Z (stored procedure).
     */
    public static function getProductenMetAllergeen(): array
    {
        return DB::select('CALL sp_GetAllProductsWithAllergies()');
    }

    /**
     * Get products filtered by allergen name (stored procedure).
     */
    public static function getProductenOpAllergeen(string $allergeenNaam): array
    {
        return DB::select('CALL sp_GetProductsByAllergen(?)', [$allergeenNaam]);
    }

    /**
     * Get supplier info for a product with address validation (stored procedure).
     * Returns message "Er is zijn geen adresgegevens bekent" when no address exists.
     */
    public static function getLeverancierInfoMetAdresCheck(int $productId): array
    {
        return DB::select('CALL sp_GetSupplierInfoWithAddressCheck(?)', [$productId]);
    }
}
