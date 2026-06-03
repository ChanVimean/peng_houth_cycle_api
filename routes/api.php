<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\StationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Test Route
Route::get('/test', function () {
    return response()->json([
        'message' => 'Hello, World!',
    ]);
});

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public Routes
Route::get('/stations', [StationController::class, 'index']); // Show All
Route::get('/stations/{station}', [StationController::class, 'show']); // Show one Station
Route::get('/stations/{station}/bikes', [BikeController::class, 'byStation']); // Show all Bikes at specific Station
Route::get('/bikes/{bike}', [BikeController::class, 'show']); // Show one Bike

// Group Routes: Login Required
Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

});
