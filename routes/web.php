<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlsController;

Route::get('/', function () {
    return 'oi';
});

Route::get('/{shortcode}', [UrlsController::class, 'getUrlByShortcode']);
