<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Raspberry\Look\Infrastructure\Controllers\DetailLookController;
use Raspberry\Look\Infrastructure\Controllers\PickerScoreController;
use Raspberry\Messenger\Infrastructure\Controllers\TelegramLookBotController;
use Raspberry\Wardrobe\Infrastructure\Http\Controllers\AddClothesController;
use Raspberry\Wardrobe\Infrastructure\Http\Controllers\RemoveClothesController;
use Raspberry\Wardrobe\Infrastructure\Http\Controllers\WardrobeController;
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
    Route::middleware('auth:api')->prefix('wardrobe')->group(function () {
        Route::post('/', [WardrobeController::class, 'userWardrobe']);
        Route::post('add', AddClothesController::class);
        Route::post('remove', RemoveClothesController::class);
        Route::post('offers', [WardrobeOffersController::class, 'userOffers']);
    });

    Route::middleware('auth:api')->prefix('look')->group(function () {
        Route::prefix('{look_id}')->group(function () {
            Route::post('/', DetailLookController::class);
            Route::post('how-fit', PickerScoreController::class);
        });
    });

    Route::prefix('look-bot')->group(function () {
        Route::post('telegram', TelegramLookBotController::class);
    });
});
