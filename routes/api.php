<?php

use App\Http\Controllers\TelegramBotCommandsController;
use App\Http\Middleware\HasToken;
use App\Http\Middleware\HasValidTelegramToken;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;


Route::any('ping', fn() => 'pong')->name('ping');

Route::post('log', [LogContoller::class, 'logData'])->name('log')->middleware(HasToken::class);

Route::post("/webhook", [TelegramBotCommandsController::class, 'handleCommands'])->middleware(HasValidTelegramToken::class);