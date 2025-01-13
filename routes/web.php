<?php

use App\Http\Controllers\Timber\TimberSpeciesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', [TimberSpeciesController::class, 'index'])->name('timber.index');
Route::get('/timber/{species}', [TimberSpeciesController::class, 'show'])->name('timber.show');
Route::post('/timber/filter', [TimberSpeciesController::class, 'filter'])->name('timber.filter');
Route::get('/timber/stats', [TimberSpeciesController::class, 'getStats'])->name('timber.stats');
