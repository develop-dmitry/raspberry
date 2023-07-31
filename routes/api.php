<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Raspberry\Wardrobe\Infrastructure\Http\Controllers\AddClothesController;
use Raspberry\Wardrobe\Infrastructure\Http\Controllers\RemoveClothesController;
use Raspberry\Wardrobe\Infrastructure\Http\Controllers\WardrobeListController;
use Raspberry\Wardrobe\Infrastructure\Http\Controllers\WardrobeOffersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('wardrobe')->group(function () {
        Route::prefix('{user_id}')->group(function () {
            Route::post('add', AddClothesController::class);
            Route::post('remove', RemoveClothesController::class);
            Route::post('offers', WardrobeOffersController::class);
            Route::post('/', WardrobeListController::class);
        });
    });
});
