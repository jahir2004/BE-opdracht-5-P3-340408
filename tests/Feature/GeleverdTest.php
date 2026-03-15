<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GeleverdTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create minimal test data for the database
        DB::table('Contact')->insert([
            ['Id' => 1, 'Straat' => 'Teststraat', 'Huisnummer' => 1, 'Postcode' => '1234 AB', 'Stad' => 'Teststad']
        ]);

        DB::table('Product')->insert([
            ['Id' => 1, 'Naam' => 'Product 1', 'Barcode' => '1234567890123'],
            ['Id' => 2, 'Naam' => 'Product 2', 'Barcode' => '1234567890124'],
        ]);

        DB::table('Leverancier')->insert([
            ['Id' => 1, 'Naam' => 'Leverancier 1', 'ContactPersoon' => 'John Doe', 'LeverancierNummer' => 'L001', 'Mobiel' => '0612345678', 'ContactId' => 1]
        ]);

        DB::table('ProductPerLeverancier')->insert([
            [
                'Id' => 1,
                'LeverancierId' => 1,
                'ProductId' => 1,
                'DatumLevering' => '2023-04-10',
                'Aantal' => 100,
                'DatumEerstVolgendeLevering' => '2023-04-20'
            ],
            [
                'Id' => 2,
                'LeverancierId' => 1,
                'ProductId' => 2,
                'DatumLevering' => '2023-04-15',
                'Aantal' => 50,
                'DatumEerstVolgendeLevering' => '2023-04-25'
            ],
        ]);
    }

    public function test_geleverd_index_requires_authentication()
    {
        // Arrange: geen user ingelogd
        // Act: probeer pagina te bezoeken zonder inloggen
        $response = $this->get('/geleverd');

        // Assert: wordt doorgestuurd naar login (302 redirect)
        $response->assertRedirect();
    }

    public function test_authenticated_user_can_access_geleverd_page()
    {
        // Arrange: ingelogde user
        $user = User::factory()->create();

        // Act: bezoek pagina als ingelogde user
        $response = $this->actingAs($user)->get('/geleverd');

        // Assert: pagina laadt succesvol (200 OK)
        $response->assertStatus(200);
        $response->assertViewIs('geleverd.index');
    }

    public function test_geleverd_page_renders_without_dates()
    {
        // Arrange: ingelogde user
        $user = User::factory()->create();

        // Act: bezoek pagina zonder startdatum en einddatum
        $response = $this->actingAs($user)->get('/geleverd');

        // Assert: pagina laadt en bevat form
        $response->assertStatus(200);
        $response->assertSee('Startdatum');
        $response->assertSee('Einddatum');
        $response->assertSee('Maak selectie');
    }
}
