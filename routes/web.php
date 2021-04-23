<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('dashboard',  [App\Http\Controllers\HomeController::class, 'dashboard'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('dashboard');


Route::get('/',  [App\Http\Controllers\HomeController::class, 'index']);

Route::resource('locations',  App\Http\Controllers\LocationController::class)
    ->middleware(['auth:sanctum', 'verified'])
    ->only('index', 'show', 'store', 'update', 'destroy')
    ->name('*', 'locations');

Route::resource('recommendations',  App\Http\Controllers\RecommendationController::class)
    ->middleware(['auth:sanctum', 'verified'])
    ->only('store')
    ->name('*', 'recommendations');