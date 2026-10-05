<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArchitectureController;
use App\Http\Controllers\EnvironmentController;

Route::get('/', function () {
    return redirect()->route('architecture.index');
})->name('home');

Route::get('/architecture', [ArchitectureController::class, 'index'])
    ->name('architecture.index');

Route::get('/lifecycle', [ArchitectureController::class, 'lifecycle'])
    ->name('lifecycle');

Route::get('/environment', [EnvironmentController::class, 'index'])
    ->name('environment');

Route::get('/about', function () {
    return view('about');
})->name('about');