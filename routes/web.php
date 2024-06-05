<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VipController;
use App\Http\Controllers\Timber\TimberSpeciesController;
use App\Http\Controllers\Timber\SavedMaterialsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\Timber\TimberListings;
// use App\Http\Controllers\News\NewsController;
use App\Http\Middleware\EnsureUserIsVip;
use Illuminate\Database\Query\IndexHint;
use Illuminate\Foundation\Application;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


// Web Routes Pages
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/api/user-count', [StatisticsController::class, 'getUserCount']);
    Route::get('/api/timber-count', [StatisticsController::class, 'getTimberCount']);

    //Timber stuff
    Route::get('/timber-category', [TimberSpeciesController::class, 'index'])->name('timber-category.index');
    Route::get('/timber-chart/{species}', [TimberSpeciesController::class, 'show'])->name('timber-chart.show');
    Route::post('/api/save-material', [SavedMaterialsController::class, 'store'])
    ->middleware(['auth', 'web', 'isVip']);

    Route::get('/saved-materials', [SavedMaterialsController::class, 'index'])
        ->name('saved-materials.index')->middleware(['auth', 'isVip']);
    Route::delete('/saved-materials/{id}', [SavedMaterialsController::class, 'destroy'])
        ->name('saved-materials.destroy')->middleware(['auth', 'isVip']);


    Route::get('/user-listing/{id}', [TimberListings::class, 'show'])->name('user-listings.index');
    Route::get('/user-listings', [TimberListings::class, 'index'])->name('user-listings.show');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/toggle-vip', [VipController::class, 'toggleVipStatus'])->name('toggle-vip');
});



require __DIR__.'/auth.php';
