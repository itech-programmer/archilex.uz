<?php

use App\Http\Controllers\Api\DictionaryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dictionary API Routes
|--------------------------------------------------------------------------
|
| Compatible with Android app format (matches api.dictionaryapi.dev structure)
|
*/

Route::get('/v2/entries/{lang}/{word}', [DictionaryController::class, 'show'])
    ->where('lang', 'en|uz|ru')
    ->whereAlpha('word');
