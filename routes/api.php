<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Grouped API routes with rate limiting (10 requests per minute)
Route::middleware(['throttle:10,1'])->group(function () {
    Route::apiResource('locations', LocationController::class);
    Route::get('/routes', [RouteController::class, 'calculateRoute']);
});