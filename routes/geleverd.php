<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeleverdController;

Route::middleware(['auth'])->group(function () {
    Route::get('/geleverd', [GeleverdController::class, 'overzicht'])->name('geleverd.overzicht');
});
