<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::get('/',  [App\Http\Controllers\HomeController::class, 'index']);

Route::resource('locations',  App\Http\Controllers\LocationController::class)
    ->only('index', 'show', 'update')
    ->middleware('auth:sanctum');