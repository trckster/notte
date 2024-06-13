<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;

Route::any('ping', fn() => 'pong')->name('ping');
Route::post('/log', [TokenController::class,'logData']);
