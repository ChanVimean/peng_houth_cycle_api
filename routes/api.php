<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RentalController;
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
Route::get('/bikes', [BikeController::class, 'index']); // Show all Bike
Route::get('/bikes/{bike}', [BikeController::class, 'show']); // Show one Bike

// Group Routes: Login Required
Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Group Routes: Customer Only
Route::middleware(['auth:sanctum', 'customer'])->group(function () {
    // Rentals
    Route::get('/rentals', [RentalController::class, 'index']); // Rental history
    Route::get('/rentals/active', [RentalController::class, 'active']); // Current active rental
    Route::get('/rentals/{rental}', [RentalController::class, 'show']); // Show one rental
    Route::post('/rentals', [RentalController::class, 'store']); // Start rental (rent a bike)
    Route::post('/rentals/{rental}/return', [RentalController::class, 'returnBike']); // Return bike

    // Payments
    Route::get('/payments/{payment}', [PaymentController::class, 'show']); // Show payment status
    Route::post('/payments', [PaymentController::class, 'store']); // Create payment for a rental
    Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm']); // Confirm/mock-pay
});

// Group Routes: Admin Only
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/rentals', [RentalController::class, 'allRentals']); // Show all rentals
});
