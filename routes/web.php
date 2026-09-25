<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BirthdayController;

Route::get('/', [BirthdayController::class, 'home'])->name('home');
Route::get('/cake', [BirthdayController::class, 'cake'])->name('cake');
Route::get('/letter', [BirthdayController::class, 'letter'])->name('letter');
Route::get('/memories', [BirthdayController::class, 'memories'])->name('memories');
Route::get('/wishes', [BirthdayController::class, 'wishes'])->name('wishes');
Route::get('/game', [BirthdayController::class, 'game'])->name('game');

// Interactive APIs
Route::post('/api/wishes', [BirthdayController::class, 'storeWish'])->name('wishes.store');
Route::post('/api/wishes/{id}/like', [BirthdayController::class, 'likeWish'])->name('wishes.like');
Route::post('/api/memories', [BirthdayController::class, 'storeMemory'])->name('memories.store');
Route::post('/api/memories/{id}/like', [BirthdayController::class, 'likeMemory'])->name('memories.like');
Route::post('/api/settings', [BirthdayController::class, 'updateSettings'])->name('settings.update');
