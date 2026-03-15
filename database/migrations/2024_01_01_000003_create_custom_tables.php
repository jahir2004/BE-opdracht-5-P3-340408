<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create Contact table (no foreign keys)
        Schema::create('Contact', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Straat', 255)->nullable();
            $table->integer('Huisnummer')->nullable();
            $table->string('Postcode', 10)->nullable();
            $table->string('Stad', 255)->nullable();
        });

        // Create Product table
        Schema::create('Product', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Naam', 255)->nullable();
            $table->string('Barcode', 13)->nullable();
        });

        // Create Allergen table
        Schema::create('Allergeen', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Naam', 255)->nullable();
            $table->text('Omschrijving')->nullable();
        });

        // Create Leverancier table (references Contact)
        Schema::create('Leverancier', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Naam', 255)->nullable();
            $table->string('ContactPersoon', 255)->nullable();
            $table->string('LeverancierNummer', 20)->nullable();
            $table->string('Mobiel', 15)->nullable();
            $table->integer('ContactId')->nullable();
            $table->foreign('ContactId')->references('Id')->on('Contact')->onDelete('set null');
        });

        // Create Magazijn table (references Product)
        Schema::create('Magazijn', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('ProductId')->nullable();
            $table->decimal('VerpakkingsEenheid', 10, 2)->nullable();
            $table->integer('AantalAanwezig')->nullable();
            $table->foreign('ProductId')->references('Id')->on('Product')->onDelete('set null');
        });

        // Create ProductPerAllergeen table (references Product and Allergeen)
        Schema::create('ProductPerAllergeen', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('ProductId')->nullable();
            $table->integer('AllergeenId')->nullable();
            $table->foreign('ProductId')->references('Id')->on('Product')->onDelete('cascade');
            $table->foreign('AllergeenId')->references('Id')->on('Allergeen')->onDelete('cascade');
        });

        // Create ProductPerLeverancier table (references Leverancier and Product)
        Schema::create('ProductPerLeverancier', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('LeverancierId')->nullable();
            $table->integer('ProductId')->nullable();
            $table->date('DatumLevering')->nullable();
            $table->integer('Aantal')->nullable();
            $table->date('DatumEerstVolgendeLevering')->nullable();
            $table->foreign('LeverancierId')->references('Id')->on('Leverancier')->onDelete('cascade');
            $table->foreign('ProductId')->references('Id')->on('Product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProductPerLeverancier');
        Schema::dropIfExists('ProductPerAllergeen');
        Schema::dropIfExists('Magazijn');
        Schema::dropIfExists('Leverancier');
        Schema::dropIfExists('Allergeen');
        Schema::dropIfExists('Product');
        Schema::dropIfExists('Contact');
    }
};
