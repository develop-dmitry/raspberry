<?php

use Illuminate\Support\Facades\Route;
use Raspberry\Look\Infrastructure\Controllers\DetailLookController;
use Raspberry\Wardrobe\Infrastructure\Http\Controllers\WardrobeController;
use Raspberry\Wardrobe\Infrastructure\Http\Controllers\WardrobeOffersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/look/{id}', DetailLookController::class);

Route::middleware('auth:api')->prefix('/wardrobe')->group(function () {
    Route::get('/', WardrobeController::class);
    Route::get('/offers', WardrobeOffersController::class);
});


/*Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');*/
