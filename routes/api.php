<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlsController;


Route::post('/shorten', [UrlsController::class, 'createShortUrl']);
