<?php

use App\Http\Middleware\HasToken;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;

Route::any('ping', fn() => 'pong')->name('ping');
Route::post('log', [LogController::class, 'logData'])->middleware(HasToken::class);