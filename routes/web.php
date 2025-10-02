<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

Route::get('/', [AnimeController::class, 'index'])->name('anime.index');
Route::get('/search', [AnimeController::class, 'search'])->name('anime.search');
