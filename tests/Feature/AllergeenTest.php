<?php

use App\Models\allergeen;

// Test 1: Test if allergeen model class exists and can be instantiated
test('allergeen model can be instantiated', function () {
    // Arrange & Act
    $allergeen = new allergeen();
    
    // Assert
    expect($allergeen)->toBeInstanceOf(allergeen::class);
    expect($allergeen->getTable())->toBe('Allergeen');
    expect($allergeen->timestamps)->toBe(false);
});

// Test 2: Test if allergeen model has correct fillable attributes
test('allergeen model has correct fillable attributes', function () {
    // Arrange
    $allergeen = new allergeen();
    $expectedFillable = ['Naam', 'Omschrijving'];
    
    // Act
    $actualFillable = $allergeen->getFillable();
    
    // Assert
    expect($actualFillable)->toBe($expectedFillable);
    expect($actualFillable)->toContain('Naam');
    expect($actualFillable)->toContain('Omschrijving');
});

// Test 3: Test if all required static methods exist on allergeen model
test('allergeen model has all required static methods', function () {
    // Arrange & Act
    $methods = get_class_methods(allergeen::class);
    
    // Assert - check if all required methods exist
    expect($methods)->toContain('getAllergeensVoorDropdown');
    expect($methods)->toContain('getProductenMetAllergeen');
    expect($methods)->toContain('getProductenOpAllergeen');
    expect($methods)->toContain('getLeverancierInfoMetAdresCheck');
});

// Test 4: Test allergeen model attributes setting and getting
test('allergeen model can set and get attributes', function () {
    // Arrange
    $allergeen = new allergeen();
    $testNaam = 'Test Allergeen';
    $testOmschrijving = 'Dit is een test omschrijving';
    
    // Act
    $allergeen->Naam = $testNaam;
    $allergeen->Omschrijving = $testOmschrijving;
    
    // Assert
    expect($allergeen->Naam)->toBe($testNaam);
    expect($allergeen->Omschrijving)->toBe($testOmschrijving);
});