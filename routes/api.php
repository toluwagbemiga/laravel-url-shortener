<?php

use App\Http\Controllers\UrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// URL Shortener API Routes
Route::prefix('v1')->group(function () {
    Route::get('/urls', [UrlController::class, 'apiIndex']);
    Route::post('/urls', [UrlController::class, 'store']);
    Route::get('/urls/{shortCode}', [UrlController::class, 'show']);
    Route::get('/urls/{shortCode}/stats', [UrlController::class, 'stats']);
});