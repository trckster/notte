<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;

Route::any('ping', fn() => 'pong')->name('ping');
Route::post('log', [LogController::class, 'logData'])->name('log');
