<?php

use App\Http\Middleware\HasToken;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use Telegram\Bot\Laravel\Facades\Telegram;


Route::any('ping', fn() => 'pong')->name('ping');
Route::post('log', [LogController::class, 'logData'])->name('log')->middleware(HasToken::class);
Route::post('/<token>/webhook', function () {
    $updates = Telegram::getWebhookUpdate();

    return 'ok';
});