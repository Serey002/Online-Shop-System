<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ReviewApiController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

// Authentication Endpoints
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

// Store Catalog Endpoints
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{id}', [ProductApiController::class, 'show']);
Route::get('/categories', [CategoryApiController::class, 'index']);

// Public Product Reviews Feedback
Route::get('/products/{product_id}/reviews', [ReviewApiController::class, 'getProductReviews']);


/*
|--------------------------------------------------------------------------
| Protected Routes (Requires a Valid Bearer Token via Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // User Session & Profile Management
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/user/profile', [AuthApiController::class, 'updateProfile']); 
    Route::post('/logout', [AuthApiController::class, 'logout']);            

    // Order Management Endpoints
    Route::get('/orders', [OrderApiController::class, 'index']);         // Get order histories
    Route::post('/orders', [OrderApiController::class, 'store']);        // Place a new order
    Route::get('/orders/{id}', [OrderApiController::class, 'show']);     // View explicit order details
    
    // CORRECTED: Single dedicated API endpoint for the Vue Admin panel dropdown to use
    Route::patch('/orders/{id}/status', [OrderApiController::class, 'updateStatus']);
    
    // Review Management Endpoints
    Route::post('/products/{product}/reviews', [ReviewApiController::class, 'store']);
    
});