<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ReviewApiController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/
// Authentication Endpoints
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

// Store Catalog Endpoints (For mobile/frontend customers to browse)
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{id}', [ProductApiController::class, 'show']);
Route::get('/categories', [CategoryApiController::class, 'index']);

// Public Route (Let anyone read product feedback)
Route::get('/products/{product_id}/reviews', [ReviewApiController::class, 'getProductReviews']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Requires a Valid Bearer Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Revoke current session token (Logout)
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // Order Management Endpoints
    Route::get('/orders', [OrderApiController::class, 'index']);         // Get user order history
    Route::post('/orders', [OrderApiController::class, 'store']);        // Place a new order
    Route::get('/orders/{id}', [OrderApiController::class, 'show']);     // View order status details
    
    //review
    Route::post('/reviews', [ReviewApiController::class, 'store']);

    // Get currently logged-in user profile (Already existing)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // 🆕 Add this route to update user profile information
    Route::put('/user/profile', [\App\Http\Controllers\Api\AuthApiController::class, 'updateProfile']);

    // Revoke current session token (Logout)
    Route::post('/logout', [\App\Http\Controllers\Api\AuthApiController::class, 'logout']);
    
});