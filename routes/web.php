<?php

use App\Http\Controllers\Timber\TimberSpeciesController;
use App\Http\Controllers\Timber\SavedMaterialsController;
use App\Http\Controllers\Timber\TimberListings;
use App\Http\Controllers\Timber\PublicTimberController;
use App\Http\Middleware\EnsureUserIsVip;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main Routes - Timber Category as homepage
Route::get('/', [TimberSpeciesController::class, 'index'])->name('home');
Route::get('/timber-chart/{species}', [TimberSpeciesController::class, 'show'])->name('timber-chart.show');

// Saved Materials Routes (requires VIP)
Route::middleware(['auth', 'isVip'])->group(function () {
    Route::post('/api/save-material', [SavedMaterialsController::class, 'store'])->name('save-material');
    Route::get('/saved-materials', [SavedMaterialsController::class, 'index'])->name('saved-materials.index');
    Route::delete('/saved-materials/{id}', [SavedMaterialsController::class, 'destroy'])->name('saved-materials.destroy');
});

// User Listings
Route::get('/user-listing/{id}', [TimberListings::class, 'show'])->name('user-listings.index');
Route::get('/user-listings', [TimberListings::class, 'index'])->name('user-listings.show');

require __DIR__.'/auth.php';
