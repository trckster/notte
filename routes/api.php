<?php

use App\Http\Middleware\HasToken;
use App\Http\Middleware\HasValidTelegramToken;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use Telegram\Bot\Laravel\Facades\Telegram;


Route::any('ping', fn() => 'pong')->name('ping');
Route::post('log', [LogController::class, 'logData'])->name('log')->middleware(HasToken::class);
Route::post("/webhook", function () {
    Telegram::commandsHandler(true);

    return 'ok';
})->middleware(HasValidTelegramToken::class);