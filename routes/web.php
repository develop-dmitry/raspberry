<?php

use Illuminate\Support\Facades\Route;
use Raspberry\Messenger\Application\LookBot\LookBot;
use Raspberry\Messenger\Infrastructure\Gui\Telegram\TelegramMessenger;

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

Route::get('/test', function () {
    app(LookBot::class, ['messenger' => app(TelegramMessenger::class)]);
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
