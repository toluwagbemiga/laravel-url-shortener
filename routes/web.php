<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UrlController::class, 'index'])->name('urls.index');
Route::get('/create', [UrlController::class, 'create'])->name('urls.create');
Route::post('/urls', [UrlController::class, 'store'])->name('urls.store');
Route::get('/stats/{shortCode}', [UrlController::class, 'stats'])->name('urls.stats');
Route::get('/{shortCode}', [UrlController::class, 'show'])->name('urls.redirect');
