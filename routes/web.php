<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllergeenController;
use App\Http\Controllers\GeleverdController;

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
Route::middleware(['auth'])->group(function () {
    Route::get('/geleverd', [GeleverdController::class, 'index'])->name('geleverd.index');
    Route::get('/geleverd/{product}/specificatie', [GeleverdController::class, 'specificatie'])->name('geleverd.specificatie');
});

require __DIR__.'/auth.php';
