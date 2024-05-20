<?php

use Illuminate\Support\Facades\Route;

Route::any('ping', fn() => 'pong')->name('ping');
