<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllergeenController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/allergenen', [AllergeenController::class, 'index'])->name('allergenen.index');
    Route::get('/allergenen/leverancier/{productId}', [AllergeenController::class, 'leverancier'])->name('allergenen.leverancier');
});

require __DIR__.'/auth.php';
